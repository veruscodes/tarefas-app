<template>
  <div class="tasks-container">
    <div class="container py-4">
      <!-- Todo o conteúdo atual permanece igual -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gerenciamento de Tarefas</h2>
        <div>
          <button @click="logout" class="btn btn-outline-danger me-2">
            <i class="fas fa-sign-out-alt"></i> Sair
          </button>
          <router-link to="/dashboard" class="btn btn-primary">
            <i class="fas fa-home"></i> Dashboard
          </router-link>
        </div>
      </div>

      <!-- Formulário de criação -->
      <task-form @created="loadTasks" />

      <!-- Filtros -->
      <div class="row mt-4 mb-3">
        <div class="col-md-3">
          <label>Status</label>
          <select v-model="filter.status" @change="loadTasks" class="form-control">
            <option value="">Todos</option>
            <option value="pending">Pendente</option>
            <option value="in_progress">Em andamento</option>
            <option value="done">Concluída</option>
          </select>
        </div>
        <div class="col-md-3">
          <label>Prioridade</label>
          <select v-model="filter.priority" @change="loadTasks" class="form-control">
            <option value="">Todas</option>
            <option value="low">Baixa</option>
            <option value="medium">Média</option>
            <option value="high">Alta</option>
          </select>
        </div>
        <div class="col-md-6 text-end">
          <button @click="exportCSV" class="btn btn-primary me-2">
            <i class="fas fa-file-csv"></i> Exportar CSV
          </button>
          <button @click="exportExcel" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Exportar Excel
          </button>
        </div>
      </div>

      <!-- Lista de Tarefas -->
      <div class="tasks-list">
        <div v-for="task in tasks" :key="task.id" class="task-card" :class="task.status">
          <div class="task-header">
            <h5 class="task-title">{{ task.title }}</h5>
            <span class="task-priority" :class="task.priority">
              {{ getPriorityLabel(task.priority) }}
            </span>
          </div>
          
          <p class="task-description" v-if="task.description">{{ task.description }}</p>
          
          <div class="task-meta">
            <span class="task-date" v-if="task.due_date">
              <i class="fas fa-calendar"></i> 
              {{ formatDate(task.due_date) }}
            </span>
            <span class="task-status" :class="task.status">
              {{ getStatusLabel(task.status) }}
            </span>
          </div>

          <div class="task-actions">
            <button v-if="task.status !== 'done'" 
                   @click="updateStatus(task, 'done')" 
                   class="btn btn-success btn-sm">
              <i class="fas fa-check"></i> Concluir
            </button>
            
            <button v-if="task.status === 'pending'" 
                   @click="updateStatus(task, 'in_progress')" 
                   class="btn btn-warning btn-sm">
              <i class="fas fa-play"></i> Iniciar
            </button>
            
            <button @click="removeTask(task.id)" class="btn btn-danger btn-sm">
              <i class="fas fa-trash"></i> Excluir
            </button>
          </div>
        </div>
      </div>

      <div v-if="tasks.length === 0" class="text-center mt-5">
        <p>Nenhuma tarefa encontrada.</p>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../services/api";
import TaskForm from "./TaskForm.vue";
import * as XLSX from "xlsx";
import { saveAs } from "file-saver";

export default {
  name: "TasksPage",
  components: { TaskForm },
  data() {
    return {
      tasks: [],
      filter: { status: "", priority: "" },
    };
  },
  mounted() {
    this.loadTasks();
  },
  methods: {
    async loadTasks() {
      try {
        const res = await api.get("/tasks", { params: this.filter });
        this.tasks = res.data.data ?? res.data;
      } catch (err) {
        console.error("Erro ao carregar tarefas:", err);
      }
    },

    async updateStatus(task, status) {
      try {
        await api.patch(`/tasks/${task.id}`, { 
          status: status
        });
        this.loadTasks();
      } catch (err) {
        console.error("Erro ao atualizar status:", err);
        alert("Erro ao atualizar tarefa: " + (err.response?.data?.message || err.message));
      }
    },

    async removeTask(id) {
      if (!confirm("Tem certeza que deseja excluir esta tarefa?")) return;
      
      try {
        await api.delete(`/tasks/${id}`);
        this.loadTasks();
      } catch (err) {
        console.error("Erro ao remover tarefa:", err);
      }
    },

    logout() {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },

    exportCSV() {
      const ws = XLSX.utils.json_to_sheet(this.tasks);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, "Tarefas");
      const wbout = XLSX.write(wb, { bookType: "csv", type: "array" });
      saveAs(new Blob([wbout], { type: "text/csv;charset=utf-8;" }), "tarefas.csv");
    },

    exportExcel() {
      const ws = XLSX.utils.json_to_sheet(this.tasks);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, "Tarefas");
      const wbout = XLSX.write(wb, { bookType: "xlsx", type: "array" });
      saveAs(new Blob([wbout], { type: "application/octet-stream" }), "tarefas.xlsx");
    },

    getStatusLabel(status) {
      const statusMap = {
        'pending': 'Pendente',
        'in_progress': 'Em andamento',
        'done': 'Concluída'
      };
      return statusMap[status] || status;
    },

    getPriorityLabel(priority) {
      const priorityMap = {
        'low': 'Baixa',
        'medium': 'Média',
        'high': 'Alta'
      };
      return priorityMap[priority] || priority;
    },

    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('pt-BR');
    }
  }
};
</script>

<style scoped>
/* BACKGROUND IGUAL AO DASHBOARD */
.tasks-container {
  min-height: 100vh;
  padding: 40px 20px;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Mantém todos os outros estilos originais */
.tasks-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.task-card {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  border-left: 4px solid #6c757d;
}

.task-card.done {
  border-left-color: #28a745;
  opacity: 0.8;
}

.task-card.in_progress {
  border-left-color: #ffc107;
}

.task-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.task-title {
  margin: 0;
  color: #2c3e50;
}

.task-priority {
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: 500;
}

.task-priority.low {
  background: #d4edda;
  color: #155724;
}

.task-priority.medium {
  background: #fff3cd;
  color: #856404;
}

.task-priority.high {
  background: #f8d7da;
  color: #721c24;
}

.task-description {
  color: #6c757d;
  margin-bottom: 15px;
}

.task-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  font-size: 0.9rem;
}

.task-date {
  color: #6c757d;
}

.task-status {
  padding: 4px 10px;
  border-radius: 12px;
  font-weight: 500;
}

.task-status.pending {
  background: #fff3cd;
  color: #856404;
}

.task-status.in_progress {
  background: #d1ecf1;
  color: #0c5460;
}

.task-status.done {
  background: #d4edda;
  color: #155724;
}

.task-actions {
  display: flex;
  gap: 10px;
}

.btn-sm {
  font-size: 0.8rem;
  padding: 5px 10px;
}
</style>
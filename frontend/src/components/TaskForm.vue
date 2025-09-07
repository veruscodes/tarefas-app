<template>
  <form @submit.prevent="createTask" class="card card-body mb-3">
    <h5>Criar nova tarefa</h5>
    <div class="form-group mb-2">
      <input v-model="title" class="form-control" placeholder="Título" required />
    </div>
    <div class="form-group mb-2">
      <select v-model="priority" class="form-control" required>
        <option disabled value="">Selecione prioridade</option>
        <option value="low">Baixa</option>
        <option value="medium">Média</option>
        <option value="high">Alta</option>
      </select>
    </div>
    <div class="form-group mb-2">
      <label>Data e Hora de Vencimento:</label>
      <input v-model="due_date" type="datetime-local" class="form-control" />
    </div>
    <button type="submit" class="btn btn-primary">Adicionar</button>
  </form>
</template>

<script>
import api from "../services/api";

export default {
  name: "TaskFormComponent",
  data() {
    return { 
      title: "", 
      priority: "medium", // VALOR PADRÃO
      due_date: ""
    };
  },
  methods: {
    async createTask() {
      try {
        await api.post("/tasks", {
          title: this.title,
          priority: this.priority,
          due_date: this.due_date,
          status: "pending" // STATUS PADRÃO OBRIGATÓRIO
        });
        this.title = "";
        this.priority = "medium";
        this.due_date = "";
        this.$emit("created");
      } catch (error) {
        console.error("Erro ao criar tarefa:", error);
        alert("Erro ao criar tarefa: " + (error.response?.data?.message || error.message));
      }
    },
  },
};
</script>
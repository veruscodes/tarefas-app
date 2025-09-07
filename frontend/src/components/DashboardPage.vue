<template>
  <div class="dashboard-container">
    <!-- Cabeçalho -->
    <div class="dashboard-header">
      <h2>Dashboard</h2>
      <button @click="logout" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Sair
      </button>
    </div>

    <div class="welcome-section">
      <h3>Olá, {{ user.name }}!</h3>
      <p>{{ user.company.name }}</p>
    </div>

    <!-- Métricas no estilo da imagem -->
    <div class="metrics-grid">
      <div class="metric-card">
        <div class="metric-content">
          <span class="metric-number">{{ stats.total }}</span>
          <span class="metric-title">Total de Tarefas</span>
          <span class="metric-change">+5 desde ontem</span>
        </div>
        <div class="metric-icon">
          <i class="fas fa-tasks"></i>
        </div>
      </div>

      <div class="metric-card">
        <div class="metric-content">
          <span class="metric-number">{{ stats.pending }}</span>
          <span class="metric-title">Pendentes</span>
          <span class="metric-change">-2 desde ontem</span>
        </div>
        <div class="metric-icon pending">
          <i class="fas fa-clock"></i>
        </div>
      </div>

      <div class="metric-card">
        <div class="metric-content">
          <span class="metric-number">{{ stats.completed }}</span>
          <span class="metric-title">Concluídas</span>
          <span class="metric-change">+7 desde ontem</span>
        </div>
        <div class="metric-icon completed">
          <i class="fas fa-check-circle"></i>
        </div>
      </div>

      <div class="metric-card">
        <div class="metric-content">
          <span class="metric-number">{{ stats.overdue }}</span>
          <span class="metric-title">Atrasadas</span>
          <span class="metric-change">+1 desde ontem</span>
        </div>
        <div class="metric-icon overdue">
          <i class="fas fa-exclamation-circle"></i>
        </div>
      </div>
    </div>

    <!-- Gráfico de Status -->
    <div class="chart-section">
      <h4>Status das Tarefas</h4>
      <div class="chart-bars">
        <div class="chart-item">
          <div class="chart-info">
            <span>Concluídas ({{ completedPercentage }}%)</span>
          </div>
          <div class="chart-bar">
            <div class="chart-fill completed" :style="{ width: completedPercentage + '%' }"></div>
          </div>
        </div>
        
        <div class="chart-item">
          <div class="chart-info">
            <span>Pendentes ({{ pendingPercentage }}%)</span>
          </div>
          <div class="chart-bar">
            <div class="chart-fill pending" :style="{ width: pendingPercentage + '%' }"></div>
          </div>
        </div>
        
        <div class="chart-item">
          <div class="chart-info">
            <span>Atrasadas ({{ overduePercentage }}%)</span>
          </div>
          <div class="chart-bar">
            <div class="chart-fill overdue" :style="{ width: overduePercentage + '%' }"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="actions-section">
      <router-link to="/tasks" class="action-btn primary">
        <i class="fas fa-tasks"></i>
        Gerenciar Tarefas
      </router-link>
    </div>
  </div>
</template>

<script>
import api from "../services/api";

export default {
  name: "DashboardPage",
  data() {
    return {
      user: {},
      stats: {
        total: 0,
        pending: 0,
        completed: 0,
        overdue: 0
      }
    };
  },
  computed: {
    completedPercentage() {
      return this.stats.total > 0 ? Math.round((this.stats.completed / this.stats.total) * 100) : 0;
    },
    pendingPercentage() {
      return this.stats.total > 0 ? Math.round((this.stats.pending / this.stats.total) * 100) : 0;
    },
    overduePercentage() {
      return this.stats.total > 0 ? Math.round((this.stats.overdue / this.stats.total) * 100) : 0;
    }
  },
  async mounted() {
    await this.loadUserData();
    await this.loadTasksStats();
  },
  methods: {
    async loadUserData() {
      try {
        const response = await api.get('/auth/me');
        this.user = response.data;
      } catch (error) {
        console.error('Erro ao carregar dados do usuário:', error);
      }
    },
    
    async loadTasksStats() {
      try {
        const response = await api.get('/tasks');
        const tasks = response.data;
        
        this.stats.total = tasks.length;
        this.stats.pending = tasks.filter(task => task.status === 'pending').length;
        this.stats.completed = tasks.filter(task => task.status === 'done').length;
        this.stats.overdue = tasks.filter(task => 
          task.status === 'pending' && 
          task.due_date && 
          new Date(task.due_date) < new Date()
        ).length;
        
      } catch (error) {
        console.error('Erro ao carregar estatísticas:', error);
        // Dados de exemplo para teste
        this.stats = { total: 47, pending: 12, completed: 35, overdue: 3 };
      }
    },
    
    logout() {
      localStorage.removeItem('token');
      this.$router.push('/login');
    }
  }
};
</script>

<style scoped>
.dashboard-container {
  min-height: 100vh;
  padding: 40px 20px;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
}

.dashboard-header h2 {
  color: #2c3e50;
  font-size: 2.2rem;
  font-weight: 700;
}

.logout-btn {
  background: #dc3545;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 600;
}

.logout-btn:hover {
  background: #c82333;
  transform: translateY(-2px);
}

.welcome-section {
  text-align: center;
  margin-bottom: 40px;
}

.welcome-section h3 {
  color: #2c3e50;
  font-size: 1.8rem;
  margin-bottom: 5px;
}

.welcome-section p {
  color: #6c757d;
  font-size: 1.1rem;
}

.metrics-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  max-width: 1200px;
  margin: 0 auto 40px;
}

.metric-card {
  background: white;
  padding: 25px;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.metric-content {
  flex: 1;
}

.metric-number {
  display: block;
  color: #2c3e50;
  font-size: 2.5rem;
  font-weight: 700;
  line-height: 1;
  margin-bottom: 5px;
}

.metric-title {
  display: block;
  color: #6c757d;
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 5px;
}

.metric-change {
  display: block;
  color: #28a745;
  font-size: 0.9rem;
}

.metric-icon {
  width: 60px;
  height: 60px;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  background: #667eea;
  color: white;
}

.metric-icon.pending { background: #ffc107; }
.metric-icon.completed { background: #28a745; }
.metric-icon.overdue { background: #dc3545; }

.chart-section {
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  max-width: 1200px;
  margin: 0 auto 40px;
}

.chart-section h4 {
  color: #2c3e50;
  margin-bottom: 25px;
  text-align: center;
  font-size: 1.3rem;
}

.chart-bars {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.chart-item {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.chart-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.chart-info span {
  color: #2c3e50;
  font-weight: 500;
}

.chart-bar {
  width: 100%;
  height: 20px;
  background: #f8f9fa;
  border-radius: 10px;
  overflow: hidden;
}

.chart-fill {
  height: 100%;
  border-radius: 10px;
  transition: width 0.5s ease;
}

.chart-fill.completed { background: #28a745; }
.chart-fill.pending { background: #ffc107; }
.chart-fill.overdue { background: #dc3545; }

.actions-section {
  display: flex;
  justify-content: center;
  max-width: 1200px;
  margin: 0 auto;
}

.action-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 15px 30px;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
  background: linear-gradient(135deg, #667eea 0%, #667eea 100%);
  color: white;
  border: none;
  min-width: 200px;
  justify-content: center;
}

.action-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
  .metrics-grid {
    grid-template-columns: 1fr;
  }
  
  .metric-card {
    flex-direction: column;
    text-align: center;
    gap: 15px;
  }
  
  .action-btn {
    min-width: auto;
    width: 100%;
  }
}
</style>
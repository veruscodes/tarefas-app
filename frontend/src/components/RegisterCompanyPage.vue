<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h2>Cadastro de Empresa e Usuário</h2>
        <p>Crie sua conta para acessar o sistema</p>
      </div>

      <form @submit.prevent="register" class="login-form">
        <div class="form-group">
          <label>Nome do Responsável</label>
          <input 
            v-model="userName" 
            type="text" 
            class="form-control" 
            placeholder="Digite o nome do responsável" 
            required 
          />
        </div>

        <div class="form-group">
          <label>Nome da Empresa</label>
          <input 
            v-model="companyName" 
            type="text" 
            class="form-control" 
            placeholder="Digite o nome da empresa" 
            required 
          />
        </div>
        
        <div class="form-group">
          <label>Email do Usuário</label>
          <input 
            v-model="userEmail" 
            type="email" 
            class="form-control" 
            placeholder="Digite o e-mail" 
            required 
          />
        </div>
        
        <div class="form-group">
          <label>Senha</label>
          <input 
            v-model="userPassword" 
            type="password" 
            class="form-control" 
            placeholder="Digite a senha" 
            required 
          />
        </div>
        
        <button type="submit" class="btn btn-primary w-100">
          <span v-if="!loading">Cadastrar</span>
          <span v-else>Processando...</span>
        </button>
      </form>
      
      <div v-if="message" :class="['alert', success ? 'alert-success' : 'alert-danger']">
        {{ message }}
      </div>
      
      <div class="login-footer">
        <p>
          Já tem conta? <router-link to="/">Faça login aqui</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../services/api";

export default {
  name: "RegisterCompanyPage",
  data() {
    return {
      userName: '',
      companyName: '',
      userEmail: '',
      userPassword: '',
      message: '',
      success: false,
      loading: false
    };
  },
  methods: {
    async register() {
      this.loading = true;
      this.message = '';
      
      try {
        const res = await api.post('/auth/register', {
          company_name: this.companyName,
          company_slug: this.companyName.toLowerCase().replace(/\s+/g, '-'),
          name: this.userName,
          email: this.userEmail,
          password: this.userPassword
        });

        this.message = 'Cadastro realizado com sucesso!';
        this.success = true;
        
        localStorage.setItem('token', res.data.token);
        this.$router.push('/dashboard');
        
      } catch (err) {
        console.error(err);
        this.message = err.response?.data?.message || 'Erro ao cadastrar. Verifique os dados.';
        this.success = false;
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.login-container {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 20px;
}

.login-card {
  background: white;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  padding: 40px;
  width: 100%;
  max-width: 450px;
}

.login-header {
  text-align: center;
  margin-bottom: 30px;
}

.login-header h2 {
  color: #2c3e50;
  font-weight: 700;
  margin-bottom: 10px;
}

.login-header p {
  color: #6c757d;
  font-size: 1rem;
}

.login-form {
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  color: #2c3e50;
  font-weight: 500;
}

.form-control {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #e9ecef;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: #667eea;
  outline: none;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  padding: 12px;
  border-radius: 8px;
  color: white;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-primary:disabled {
  opacity: 0.7;
  cursor: not-allowed;
  transform: none;
}

.alert {
  padding: 12px 16px;
  border-radius: 8px;
  margin-bottom: 20px;
  font-size: 0.9rem;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.login-footer {
  text-align: center;
  margin-top: 20px;
}

.login-footer p {
  color: #6c757d;
  margin: 0;
}

.login-footer a {
  color: #667eea;
  text-decoration: none;
  font-weight: 500;
}

.login-footer a:hover {
  text-decoration: underline;
}

@media (max-width: 576px) {
  .login-card {
    padding: 30px 20px;
  }
}
</style>
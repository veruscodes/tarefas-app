<template>
  <div class="login-container">
    <div class="auth-card">
      <h2 class="text-center">Login</h2>
      <form @submit.prevent="login">
        <div class="form-group">
          <input v-model="email" type="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <input v-model="password" type="password" placeholder="Senha" required>
        </div>
        <button type="submit">Entrar</button>
      </form>
      <p v-if="error" class="error">{{ error }}</p>
      <p class="text-center">
        Não tem conta? <router-link to="/register">Cadastre-se aqui</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import api from "../services/api";

export default {
  name: "LoginPage",
  data() {
    return { email: "", password: "", error: "" };
  },
  methods: {
    async login() {
      try {
        const res = await api.post("/auth/login", {
          email: this.email,
          password: this.password,
        });
        localStorage.setItem("token", res.data.token);
        this.$router.push("/dashboard");
      } catch (e) {
        this.error = "Credenciais inválidas";
      }
    },
  },
};
</script>

<style scoped>
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 20px;
}

.auth-card {
  background: white;
  padding: 2rem;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  width: 100%;
  max-width: 400px;
}

.form-group {
  margin-bottom: 1rem;
}

input {
  width: 100%;
  padding: 12px;
  border: 2px solid #ddd;
  border-radius: 8px;
  font-size: 16px;
}

button {
  width: 100%;
  padding: 12px;
  background: #667eea;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
}

.error {
  color: red;
  text-align: center;
}
</style>
// src/axios.js
import axios from 'axios';

// Cria uma instância do Axios
const api = axios.create({
  baseURL: 'http://localhost:8000/api', // ajuste para seu backend
});

// Interceptor para adicionar o token automaticamente
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token'); // pega token do localStorage
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default api;

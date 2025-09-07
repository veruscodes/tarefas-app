📝 Sistema de Tarefas Multiempresa
Sistema desenvolvido em Laravel + Vue.js + MySQL com autenticação JWT e suporte multiempresa.
Inclui CRUD de tarefas, filtros, dashboard, exportação de dados e frontend responsivo.

## 🖼️ Screenshots

### Dashboard
![tela-dashboard](https://github.com/user-attachments/assets/3ebbb1da-70c3-45ad-b76d-f21b52c3bdcb)


### Página de Tarefas  
![tela-tarefas](https://github.com/user-attachments/assets/dc046554-51e4-46b5-9dae-74070fc34974)


### Login
![tela-login](https://github.com/user-attachments/assets/c3069d6e-439a-45db-a50f-d4473e13b3e6)


### Registro
![tela-registro](https://github.com/user-attachments/assets/41da77f5-f89d-42e5-965e-32652545e4c1)


👤 Usuário de Acesso

Email: admin@empresa.com
Senha: 123456

🚀 Tecnologias
Backend: Laravel 10 (PHP 8.2)

Frontend: Vue.js 3 + Bootstrap 5

Autenticação: JWT

Banco: MySQL 8.0

Servidor: Nginx

📦 Instalação com Docker

# Clone o repositório
git clone <repositorio>
cd tarefas-app

# Suba os containers
docker-compose up -d --build

# Execute as migrações
docker-compose exec app php artisan migrate

# Instale as dependências do frontend (se necessário)
docker-compose exec app npm install
docker-compose exec app npm run build

🌐 Acesso
Aplicação: http://localhost:8000

PHPMyAdmin: http://localhost/phpmyadmin

MySQL: localhost:3306

📋 Funcionalidades
✅ Cadastro de empresas e usuários

✅ Autenticação JWT

✅ CRUD completo de tarefas

✅ Filtros por status e prioridade

✅ Dashboard com métricas

✅ Exportação CSV/Excel

✅ Interface responsiva

🎯 Rotas da API
Autenticação
POST /api/auth/register - Registrar empresa e usuário

POST /api/auth/login - Login

GET /api/auth/me - Dados do usuário

POST /api/auth/logout - Logout

Tarefas
GET /api/tasks - Listar tarefas (com filtros)

POST /api/tasks - Criar tarefa

PUT /api/tasks/{id} - Atualizar tarefa

DELETE /api/tasks/{id} - Excluir tarefa

🖥️ Frontend
Vue.js 3 com Composition API

Bootstrap 5 para styling

Layout responsivo

Gradientes e animações

Ícones FontAwesome

🐳 Estrutura Docker
app: Nginx + PHP-FPM + Vue.js

mysql: Banco de dados MySQL

phpmyadmin: Interface de administração

🔧 Variáveis de Ambiente
As configurações estão no arquivo .env com:

Conexão MySQL

Chave JWT

Configurações da aplicação

📊 Dashboard
Métricas de tarefas (total, pendentes, concluídas, atrasadas)

Gráficos de status

Ações rápidas para gerenciamento

Desenvolvido com Laravel, Vue.js e Docker.

✅ REQUISITOS BÔNUS IMPLEMENTADOS
🎯 BÔNUS 1: DASHBOARD COM MÉTRICAS
✅ Dashboard interativo com métricas em tempo real

✅ Cartões de métricas: Total de tarefas, Pendentes, Concluídas, Atrasadas

✅ Gráfico de barras com porcentagem por status

✅ Design responsivo com gradiente e animações

🎯 BÔNUS 2: FILTROS AVANÇADOS
✅ Filtro por status (Todos, Pendente, Em andamento, Concluída)

✅ Filtro por prioridade (Todas, Baixa, Média, Alta)

✅ Filtros combinados que funcionam simultaneamente

✅ Atualização em tempo real sem recarregar a página

🎯 BÔNUS 3: EXPORTAÇÃO DE DADOS
✅ Exportação CSV com botão dedicado

✅ Exportação Excel (XLSX) com formatação

✅ Download automático dos arquivos exportados

✅ Todos os dados das tarefas incluídos na exportação

🎯 BÔNUS 4: DESIGN RESPONSIVO
✅ Layout mobile-first totalmente responsivo

✅ Gradientes visuais consistentes em todas as páginas

✅ Componentes Bootstrap 5 com customização

✅ Animações CSS suaves e profissionais

🎯 BÔNUS 5: DOCKERIZAÇÃO COMPLETA
✅ Dockerfile multi-estágio (Frontend + Backend)

✅ Docker Compose com serviços integrados

✅ MySQL containerizado com volume persistente

✅ PHPMyAdmin incluído para administração

✅ Ambiente de desenvolvimento pronto para uso

🎯 BÔNUS 6: EXPERIÊNCIA DO USUÁRIO
✅ Loading states durante operações

✅ Mensagens de feedback (sucesso/erro)

✅ Confirmações antes de exclusões

✅ Navegação intuitiva entre páginas

✅ Logout funcional com redirecionamento

🎯 BÔNUS 7: FUNCIONALIDADES EXTRAS
✅ Sistema multiempresa completo

✅ Atualização em tempo real da lista de tarefas

✅ Formatação de datas em português (pt-BR)

✅ Ícones FontAwesome em toda a interface

✅ Validações frontend e backend

📋 TODOS OS BÔNUS IMPLEMENTADOS:
✅ Dashboard com métricas

✅ Filtros avançados

✅ Exportação de dados (CSV + Excel)

✅ Design responsivo e moderno

✅ Dockerização completa

✅ Experiência premium do usuário

✅ Funcionalidades extras profissionais

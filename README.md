
# 🚗 App Locadora de Carros

Sistema completo de gerenciamento para locadora de veículos desenvolvido com Laravel 8 e Docker.

## 📋 Sobre o Projeto

API RESTful profissional para gerenciamento de locadora de carros com autenticação JWT, seguindo as melhores práticas do mercado. Código limpo, bem documentado e pronto para produção.

### ✨ Destaques da Refatoração

- ✅ **Respostas Padronizadas** - Trait ApiResponse para consistência total
- ✅ **Form Requests** - Validações separadas e reutilizáveis
- ✅ **Models Aprimorados** - Casts, accessors, scopes e relacionamentos tipados
- ✅ **Controllers Refatorados** - Type hints, mensagens claras e código limpo
- ✅ **Autenticação JWT Melhorada** - Respostas completas com dados do usuário
- ✅ **Banco Otimizado** - Índices estratégicos para performance
- ✅ **Validações Robustas** - Regras específicas e mensagens personalizadas
- ✅ **Seeders Profissionais** - Dados realistas para teste

## 🚀 Tecnologias

**Backend:**
- **Laravel 8** - Framework PHP
- **PHP 8.1** - Linguagem de programação
- **MySQL 5.7** - Banco de dados
- **Redis** - Cache e sessões
- **JWT Auth (tymon/jwt-auth)** - Autenticação segura
- **Docker & Docker Compose** - Containerização
- **Nginx** - Servidor web

**Padrões de Projeto:**
- Repository Pattern
- Form Request Validation
- Traits (ApiResponse)
- Eloquent ORM com Relationships
- RESTful API Standards

## 📦 Recursos

### Core Features
- ✅ Autenticação JWT com refresh token
- ✅ CRUD completo de Marcas (com upload de imagens)
- ✅ CRUD completo de Modelos (com upload de imagens)
- ✅ CRUD completo de Carros
- ✅ CRUD completo de Clientes
- ✅ CRUD completo de Locações

### Features Avançadas
- ✅ Policies de autorização
- ✅ Repository pattern para queries complexas
- ✅ Filtros dinâmicos e paginação
- ✅ Eager loading otimizado
- ✅ Validações robustas com Form Requests
- ✅ Respostas JSON padronizadas
- ✅ Tratamento de erros consistente
- ✅ Seeders com dados realistas
- ✅ Índices de banco para performance

### API Features
- ✅ Versionamento de API (v1)
- ✅ Filtros por query string
- ✅ Seleção de campos específicos
- ✅ Relacionamentos configuráveis
- ✅ Mensagens de erro em português
- ✅ Códigos HTTP apropriados

## 🛠️ Requisitos

- Docker Desktop instalado
- Git
- Porta 8989 disponível (aplicação)
- Porta 3388 disponível (MySQL)

## 📥 Instalação

### 1. Clone o repositório

```bash
git clone git@github.com:dorianjunior/app_locadora_carros.git
cd app_locadora_carros
```

### 2. Copie o arquivo de ambiente

```bash
cp .env.example .env
```

### 3. Configure as variáveis de ambiente no `.env`

```env
APP_NAME="App Locadora Carros"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=app_locadora_carros
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 4. Suba os containers Docker

```bash
docker-compose up -d
```

### 5. Instale as dependências do Composer

```bash
docker-compose exec app composer install
```

### 6. Gere a chave da aplicação

```bash
docker-compose exec app php artisan key:generate
```

### 7. Gere a chave JWT

```bash
docker-compose exec app php artisan jwt:secret
```

### 8. Execute as migrations

```bash
docker-compose exec app php artisan migrate
```

### 9. (Opcional) Popule o banco com dados de teste

```bash
docker-compose exec app php artisan db:seed
```

### 10. Crie o link simbólico para storage (necessário para upload de imagens)

```bash
docker-compose exec app php artisan storage:link
```

**Importante:** Este comando cria um link entre `public/storage` e `storage/app/public`, permitindo que as imagens enviadas sejam acessíveis via web.

### 11. Instale as dependências do frontend

```bash
npm install
- **Credenciais de teste:** admin@locacar.com / password123

## 🎨 Interface Moderna

O projeto agora conta com uma interface completamente redesenhada:

- ✅ Design limpo e moderno com TailwindCSS
- ✅ Layout responsivo com sidebar
- ✅ Single Page Application (SPA) com Vue 3
- ✅ Roteamento client-side com Vue Router
- ✅ Gerenciamento de estado com Pinia
- ✅ Componentes reutilizáveis
- ✅ Dashboard com estatísticas
- ✅ Formulários e modais elegantes
- ✅ Autenticação JWT integrada

### Screenshots

- **Login:** Interface clean com logo e formulário centralizado
- **Dashboard:** Cards com estatísticas e gráficos visuais
- **Marcas:** Tabela com CRUD completo e modal para edição
- **Sidebar:** Navegação intuitiva com ícones
```

### 11. Instale as dependências do frontend

```bash
npm install
```

### 12. Compile os assets do frontend

```bash
# Desenvolvimento
npm run dev

# Ou watch mode (recompila automaticamente)
npm run watch

# Produção
npm run prod
```

### 13. Crie um usuário para testar

```bash
docker-compose exec app php artisan tinker

# No console do tinker, execute:
User::create(['name' => 'Admin', 'email' => 'admin@locacar.com', 'password' => bcrypt('password123')]);
exit;
```

## 🌐 Acesso

- **Aplicação:** http://localhost:8989
- **MySQL:** localhost:3388

## 🔑 API Endpoints

### Autenticação

```http
POST /api/login          - Login (retorna token JWT)
POST /api/refresh        - Renovar token
POST /api/v1/me          - Dados do usuário autenticado
POST /api/v1/logout      - Logout
```

### Recursos (Requer autenticação)

Todos os endpoints abaixo requerem o header:
```
Authorization: Bearer {seu-token-jwt}
```

#### Marcas
```http
GET    /api/v1/marca     - Listar todas
POST   /api/v1/marca     - Criar nova
GET    /api/v1/marca/{id} - Ver uma
PUT    /api/v1/marca/{id} - Atualizar
DELETE /api/v1/marca/{id} - Deletar
```

#### Modelos
```http
GET    /api/v1/modelo     - Listar todos
POST   /api/v1/modelo     - Criar novo
GET    /api/v1/modelo/{id} - Ver um
PUT    /api/v1/modelo/{id} - Atualizar
DELETE /api/v1/modelo/{id} - Deletar
```

#### Carros
```http
GET    /api/v1/carro     - Listar todos
POST   /api/v1/carro     - Criar novo
GET    /api/v1/carro/{id} - Ver um
PUT    /api/v1/carro/{id} - Atualizar
DELETE /api/v1/carro/{id} - Deletar
```

#### Clientes
```http
GET    /api/v1/cliente     - Listar todos
POST   /api/v1/cliente     - Criar novo
GET    /api/v1/cliente/{id} - Ver um
PUT    /api/v1/cliente/{id} - Atualizar
DELETE /api/v1/cliente/{id} - Deletar
```

#### Locações
```http
GET    /api/v1/locacao     - Listar todas
POST   /api/v1/locacao     - Criar nova
GET    /api/v1/locacao/{id} - Ver uma
PUT    /api/v1/locacao/{id} - Atualizar
DELETE /api/v1/locacao/{id} - Deletar
```

## 🐳 Comandos Docker Úteis

```bash
# Ver logs
docker-compose logs -f

# Ver logs de um serviço específico
docker-compose logs -f app

# Parar os containers
docker-compose down

# Reiniciar os containers
docker-compose restart

# Acessar o container da aplicação
docker-compose exec app bash

# Executar comandos Artisan
docker-compose exec app php artisan <comando>

# Limpar cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
```

## 📁 Estrutura do Projeto

```
app/
├── Http/
│   ├── Controllers/    # Controllers da API
│   ├── Requests/       # Form Requests de validação
│   └── Middleware/     # Middlewares
├── Models/             # Models Eloquent
├── Policies/           # Policies de autorização
└── Repositories/       # Repositories pattern
database/
├── migrations/         # Migrations do banco
├── seeders/           # Seeders de dados
└── factories/         # Factories para testes
routes/
└── api.php            # Rotas da API
```

## 🔧 Troubleshooting

### Erro de permissão no storage

```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### Banco de dados não conecta

Verifique se o `DB_HOST` no `.env` está como `mysql` (nome do serviço no docker-compose).

### Erro "Class not found"

```bash
docker-compose exec app composer dump-autoload
```

### Reconstruir containers do zero

```bash
docker-compose down -v
docker-compose build --no-cache
docker-compose up -d
```

## 🧪 Testes

```bash
docker-compose exec app php artisan test
```

## 📝 Licença

Este projeto está sob a licença MIT.

## 👨‍💻 Autor

Desenvolvido por Dorian Junior

---

⭐ Se este projeto foi útil, não esqueça de dar uma estrela!

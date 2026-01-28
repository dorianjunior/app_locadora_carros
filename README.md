
# 🚗 App Locadora de Carros

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-8.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**Sistema de gerenciamento para locadora de veículos**

[Sobre](#-sobre-o-projeto) • [Instalação](#-instalação-e-execução) • [API](#-api-endpoints) • [Documentação](#-índice)

</div>

---

## Índice

- [Sobre o Projeto](#-sobre-o-projeto)
- [Tecnologias](#-tecnologias)
- [Recursos](#-recursos)
- [Requisitos](#️-requisitos)
- [Instalação e Execução](#-instalação-e-execução)
- [Interface Moderna](#-interface-moderna)
- [Acessos do Sistema](#-acessos-do-sistema)
- [API Endpoints](#-api-endpoints)
  - [Autenticação](#-autenticação-público)
  - [Marcas](#️-marcas-de-veículos)
  - [Modelos](#-modelos-de-veículos)
  - [Carros](#-carros)
  - [Clientes](#-clientes)
  - [Locações](#-locações)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Comandos Docker](#-comandos-docker-úteis)
- [Troubleshooting](#-troubleshooting)
- [Testes](#-testes)
- [Arquitetura](#️-arquitetura-e-padrões)
- [FAQ](#-perguntas-frequentes-faq)
- [Próximos Passos](#-próximos-passos-e-melhorias)
- [Contribuindo](#-contribuindo)

---

## Sobre o Projeto

**App Locadora de Carros** é uma API RESTful profissional para gerenciar todas as operações de uma locadora de veículos. O sistema permite o controle completo de marcas, modelos, carros, clientes e locações, com autenticação segura via JWT e interface moderna em Vue 3.

### O que o sistema faz?

Este sistema oferece uma solução completa para locadoras de veículos gerenciarem seu negócio:

- **Gerenciamento de Marcas**: Cadastre e gerencie marcas de veículos (Toyota, Volkswagen, etc.) com upload de logos
- **Gerenciamento de Modelos**: Cadastre modelos específicos de cada marca (Corolla, Gol, etc.) com detalhes técnicos e imagens
- **Controle de Carros**: Registre cada veículo do seu estoque com informações como placa, disponibilidade e modelo
- **Cadastro de Clientes**: Mantenha o cadastro completo de clientes com CPF, CNH e contatos
- **Sistema de Locações**: Registre locações com datas de início/fim, valores e controle de devoluções
- **Autenticação Segura**: Sistema de login com tokens JWT para segurança das operações
- **Interface Moderna**: Dashboard com estatísticas e formulários intuitivos para facilitar o uso

O código segue as melhores práticas do mercado: arquitetura limpa, validações robustas, respostas padronizadas e alta performance.

## Tecnologias

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

## Recursos

### Core Features
- ✅ Autenticação JWT com refresh token
- ✅ CRUD completo de Marcas (com upload de imagens)
- ✅ CRUD completo de Modelos (com upload de imagens)
- ✅ CRUD completo de Carros
- ✅ CRUD completo de Clientes
- ✅ CRUD completo de Locações

### Features Avançadas
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

## Requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

- **Docker Desktop** (com Docker Compose) - [Download aqui](https://www.docker.com/products/docker-desktop)
- **Git** - Para clonar o repositório
- **Node.js 16+** e **npm** - Para compilar o frontend
- **Portas Disponíveis:**
  - `8989` - Aplicação web
  - `3388` - MySQL (para acesso externo, caso necessário)

## Início Rápido (Quick Start)

Para os desenvolvedores que querem rodar rapidamente:

```bash
# Clone e entre no diretório
git clone git@github.com:dorianjunior/app_locadora_carros.git
cd app_locadora_carros

# Configure ambiente
cp .env.example .env

# Suba os containers
docker-compose up -d

# Instale dependências e configure
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan jwt:secret
docker-compose exec app php artisan migrate --seed
docker-compose exec app php artisan storage:link

# Frontend
npm install && npm run dev
ou npx mix

# Acesse: http://localhost:8989
# Login: admin@locacar.com / password123
```

## 📥 Instalação e Execução (Passo a Passo Detalhado)

### Guia Passo a Passo detalhado

Siga este tutorial completo para rodar o projeto em sua máquina:

### 1️⃣ Clone o repositório

Abra seu terminal e execute:

```bash
git clone git@github.com:dorianjunior/app_locadora_carros.git
cd app_locadora_carros
```

### 2️⃣ Configure o arquivo de ambiente

Copie o arquivo de exemplo `.env.example` para criar seu `.env`:

```bash
cp .env.example .env
```

**Windows (PowerShell):**
```powershell
copy .env.example .env
```

### 3️⃣ Edite as variáveis de ambiente

Abra o arquivo `.env` e verifique se contém estas configurações:

```env
APP_NAME="App Locadora Carros"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8989

# Banco de Dados MySQL
DB_CONNECTION=mysql
DB_HOST=mysql                    # Nome do serviço no Docker
DB_PORT=3306
DB_DATABASE=app_locadora_carros
DB_USERNAME=root
DB_PASSWORD=root

# Cache e Sessões com Redis
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis                 # Nome do serviço no Docker
REDIS_PASSWORD=null
REDIS_PORT=6379

# JWT (será gerado automaticamente)
JWT_SECRET=
```

### 4️⃣ Inicie os containers Docker

Este comando vai baixar as imagens necessárias e iniciar todos os serviços (PHP, MySQL, Redis, Nginx):

```bash
docker-compose up -d
```

Aguarde o download e inicialização dos containers. Isso pode levar alguns minutos na primeira vez.

Para verificar se os containers estão rodando:

```bash
docker-compose ps
```

Você deve ver os serviços `app`, `mysql`, `redis` e `nginx` com status "Up".

### 5️⃣ Instale as dependências PHP

Instale os pacotes PHP necessários usando o Composer dentro do container:

```bash
docker-compose exec app composer install
```

### 6️⃣ Gere a chave da aplicação Laravel

Esta chave é usada para criptografia:

```bash
docker-compose exec app php artisan key:generate
```

### 7️⃣ Gere a chave JWT para autenticação

Esta chave é usada para assinar os tokens de autenticação:

```bash
docker-compose exec app php artisan jwt:secret
```

### 8️⃣ Crie as tabelas no banco de dados

Execute as migrations para criar a estrutura do banco:

```bash
docker-compose exec app php artisan migrate
```

### 9️⃣ (Recomendado) Popule o banco com dados de teste

Para facilitar os testes, insira dados fictícios no banco:

```bash
docker-compose exec app php artisan db:seed
```

Isso criará:
- Marcas de veículos (Toyota, Honda, Volkswagen, etc.)
- Modelos de carros (Corolla, Civic, Gol, etc.)
- Carros disponíveis para locação
- Clientes cadastrados
- Algumas locações de exemplo

### 🔟 Configure o storage para upload de imagens

Crie o link simbólico necessário para que as imagens enviadas sejam acessíveis:

```bash
docker-compose exec app php artisan storage:link
```

**O que isso faz?** Cria um atalho de `public/storage` para `storage/app/public`, permitindo que arquivos enviados (como logos de marcas e fotos de modelos) sejam acessíveis via navegador.

### 1️⃣1️⃣ Instale as dependências do frontend

```bash
npm install
```

### 1️⃣2️⃣ Compile os assets do frontend (CSS e JavaScript)

Para desenvolvimento com recarga automática:

```bash
npm run watch
```

Ou compile uma vez apenas:

```bash
npm run dev
```

Para produção (otimizado e minificado):

```bash
npm run prod
```

### 1️⃣3️⃣ Crie um usuário administrador (O Seed já cria)

Acesse o console interativo do Laravel:

```bash
docker-compose exec app php artisan tinker
```

Dentro do tinker, crie um usuário:

```php
User::create([
    'name' => 'Admin', 
    'email' => 'admin@locacar.com', 
    'password' => bcrypt('password123')
]);
exit
```

Pressione `Ctrl+C` ou digite `exit` para sair do tinker.

### ✅ Pronto! Acesse o sistema

Abra seu navegador e acesse:

**🌐 Interface Web:** http://localhost:8989

**📧 Credenciais:**
- **Email:** admin@locacar.com
- **Senha:** password123

Se você executou o seeder (passo 9), também pode usar:
- **Email:** usuario@teste.com
- **Senha:** password

### 🔄 Para parar e reiniciar

**Parar os containers:**
```bash
docker-compose down
```

**Iniciar novamente:**
```bash
docker-compose up -d
```

**Reiniciar apenas um serviço:**
```bash
docker-compose restart app
```

## 🎨 Interface Moderna

O projeto conta com uma interface web completa e moderna:

- ✅ **Design limpo** com TailwindCSS
- ✅ **Layout responsivo** com sidebar colapsável
- ✅ **Single Page Application (SPA)** com Vue 3
- ✅ **Roteamento** client-side com Vue Router
- ✅ **Gerenciamento de estado** com Pinia
- ✅ **Componentes reutilizáveis** e bem organizados
- ✅ **Dashboard** com estatísticas em tempo real
- ✅ **Formulários elegantes** e modais para CRUD
- ✅ **Autenticação JWT** integrada

### Telas Disponíveis

- **Login**: Autenticação com email e senha
- **Dashboard**: Visão geral com cards de estatísticas (total de carros, clientes, locações ativas, etc.)
- **Marcas**: Listagem, cadastro, edição e exclusão de marcas com upload de logo
- **Modelos**: CRUD completo de modelos vinculados a marcas
- **Carros**: Gerenciamento completo do estoque de veículos
- **Clientes**: Cadastro e gestão de clientes
- **Locações**: Registro e controle de locações ativas e finalizadas

## 🌐 Acessos do Sistema

### Interface Web (Frontend)
- **URL:** http://localhost:8989
- **Email:** admin@locacar.com
- **Senha:** password123

### API REST (Backend)
- **Base URL:** http://localhost:8989/api/v1
- **Documentação:** Veja seção [API Endpoints](#-api-endpoints) abaixo

### Banco de Dados (Conexão Externa)
- **Host:** localhost
- **Porta:** 3388
- **Database:** app_locadora_carros
- **Usuário:** root
- **Senha:** root

## 🔑 API Endpoints

A API segue o padrão RESTful e retorna respostas em JSON. Todas as respostas seguem um formato padronizado com `success`, `message` e `data`.

### 🔓 Autenticação (Público)

Endpoints que **não requerem** autenticação:

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "admin@locacar.com",
  "password": "password123"
}
```

**Resposta de Sucesso (200):**
```json
{
  "success": true,
  "message": "Login realizado com sucesso",
  "data": {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
      "id": 1,
      "name": "Admin",
      "email": "admin@locacar.com"
    }
  }
}
```

**Como usar o token:** Copie o `access_token` e envie nas próximas requisições no header:
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

#### Renovar Token
```http
POST /api/refresh
Authorization: Bearer {seu-token-antigo}
```

Retorna um novo token quando o atual estiver próximo de expirar.

### 🔒 Endpoints Autenticados

**Importante:** Todos os endpoints abaixo **requerem autenticação**. Inclua sempre o header:

```
Authorization: Bearer {seu-token-jwt}
```

#### Meus Dados
```http
GET /api/v1/me
```

Retorna os dados do usuário logado.

#### Logout
```http
POST /api/v1/logout
```

Invalida o token atual.

---

### 🏷️ Marcas de Veículos

Gerenciamento de marcas (Toyota, Honda, Volkswagen, etc.).

#### Listar Todas as Marcas
```http
GET /api/v1/marca
```

**Query Parameters (opcionais):**
- `?atributos=id,nome` - Seleciona apenas campos específicos
- `?atributos_modelos=id,nome,marca_id` - Campos dos modelos relacionados

**Resposta:**
```json
{
  "success": true,
  "message": "Marcas recuperadas com sucesso",
  "data": [
    {
      "id": 1,
      "nome": "Toyota",
      "imagem": "http://localhost:8989/storage/marcas/toyota.png",
      "created_at": "2024-01-15T10:30:00.000000Z",
      "modelos": [...]
    }
  ]
}
```

#### Buscar Marca Específica
```http
GET /api/v1/marca/{id}
```

Retorna uma marca com seus modelos relacionados.

#### Criar Nova Marca
```http
POST /api/v1/marca
Content-Type: multipart/form-data

nome: Toyota
imagem: [arquivo.png]
```

**Validações:**
- `nome`: obrigatório, único, mínimo 3 caracteres
- `imagem`: obrigatório, formato: png/jpg/jpeg, máximo 2MB

#### Atualizar Marca
```http
PUT /api/v1/marca/{id}
Content-Type: multipart/form-data

nome: Toyota Motors
imagem: [novo-arquivo.png]  (opcional)
```

**Método alternativo para formulários:**
```http
POST /api/v1/marca/{id}
_method: PUT
```

#### Deletar Marca
```http
DELETE /api/v1/marca/{id}
```

**Nota:** Não é possível deletar marcas que possuem modelos cadastrados.

---

### 🚙 Modelos de Veículos

Modelos específicos de cada marca (Corolla, Civic, Gol, etc.).

#### Listar Todos os Modelos
```http
GET /api/v1/modelo
```

**Filtros disponíveis:**
- `?atributos=id,nome,marca_id`
- `?atributos_marca=id,nome` - Inclui dados da marca

**Resposta:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "marca_id": 1,
      "nome": "Corolla",
      "imagem": "http://localhost:8989/storage/modelos/corolla.jpg",
      "numero_portas": 4,
      "lugares": 5,
      "air_bag": true,
      "abs": true,
      "marca": {
        "id": 1,
        "nome": "Toyota"
      }
    }
  ]
}
```

#### Criar Novo Modelo
```http
POST /api/v1/modelo
Content-Type: multipart/form-data

marca_id: 1
nome: Corolla
imagem: [arquivo.jpg]
numero_portas: 4
lugares: 5
air_bag: true
abs: true
```

**Validações:**
- `marca_id`: deve existir na tabela marcas
- `nome`: obrigatório, único por marca
- `numero_portas`: 1-6
- `lugares`: 1-20
- `air_bag`, `abs`: true/false

#### Atualizar e Deletar
```http
PUT /api/v1/modelo/{id}
DELETE /api/v1/modelo/{id}
```

Funcionam de forma similar às marcas.

---

### 🚗 Carros

Veículos físicos do estoque da locadora.

#### Listar Todos os Carros
```http
GET /api/v1/carro
```

**Filtros:**
- `?modelo_id=1` - Filtra por modelo específico
- `?disponivel=1` - Apenas carros disponíveis

**Resposta:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "modelo_id": 1,
      "placa": "ABC-1234",
      "disponivel": true,
      "km": 15000,
      "modelo": {
        "id": 1,
        "nome": "Corolla",
        "marca": {
          "nome": "Toyota"
        }
      }
    }
  ]
}
```

#### Criar Novo Carro
```http
POST /api/v1/carro
Content-Type: application/json

{
  "modelo_id": 1,
  "placa": "XYZ-5678",
  "disponivel": true,
  "km": 0
}
```

**Validações:**
- `placa`: formato brasileiro (ABC-1234 ou ABC1D23), única
- `km`: número inteiro, mínimo 0

---

### 👥 Clientes

Pessoas que alugam veículos.

#### Listar Clientes
```http
GET /api/v1/cliente
```

**Resposta:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nome": "João Silva",
      "cpf": "123.456.789-00",
      "cnh": "12345678900",
      "telefone": "(11) 98765-4321",
      "email": "joao@email.com",
      "endereco": "Rua ABC, 123"
    }
  ]
}
```

#### Criar Cliente
```http
POST /api/v1/cliente
Content-Type: application/json

{
  "nome": "Maria Santos",
  "cpf": "987.654.321-00",
  "cnh": "98765432100",
  "telefone": "(11) 91234-5678",
  "email": "maria@email.com",
  "endereco": "Av. XYZ, 456",
  "data_nascimento": "1990-05-15"
}
```

**Validações:**
- `cpf`: formato válido, único
- `cnh`: 11 dígitos, único
- `email`: formato válido, único (opcional)

---

### 📝 Locações

Solicitações de aluguel de veículos.

#### Listar Locações
```http
GET /api/v1/locacao
```

**Filtros:**
- `?ativa=1` - Apenas locações em andamento
- `?cliente_id=1` - Locações de um cliente específico

**Resposta:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "cliente_id": 1,
      "carro_id": 1,
      "data_inicio": "2024-01-15",
      "data_fim_previsto": "2024-01-20",
      "data_fim_realizado": null,
      "valor_diaria": 150.00,
      "km_inicial": 15000,
      "km_final": null,
      "cliente": {
        "nome": "João Silva"
      },
      "carro": {
        "placa": "ABC-1234",
        "modelo": {
          "nome": "Corolla"
        }
      }
    }
  ]
}
```

#### Criar Nova Locação
```http
POST /api/v1/locacao
Content-Type: application/json

{
  "cliente_id": 1,
  "carro_id": 1,
  "data_inicio": "2024-01-20",
  "data_fim_previsto": "2024-01-25",
  "valor_diaria": 150.00,
  "km_inicial": 15000
}
```

**Validações:**
- `carro_id`: o carro deve estar disponível
- `data_fim_previsto`: deve ser posterior a `data_inicio`
- `valor_diaria`: valor decimal positivo
- `km_inicial`: deve corresponder à km atual do carro

#### Finalizar Locação (Devolução)
```http
PUT /api/v1/locacao/{id}
Content-Type: application/json

{
  "data_fim_realizado": "2024-01-24",
  "km_final": 15450
}
```

Atualiza a km do carro e marca como disponível novamente.

---

### 📊 Códigos de Resposta HTTP

| Código | Significado | Quando ocorre |
|--------|-------------|---------------|
| 200 | OK | Requisição bem-sucedida (GET, PUT) |
| 201 | Created | Recurso criado com sucesso (POST) |
| 204 | No Content | Recurso deletado com sucesso (DELETE) |
| 400 | Bad Request | Dados inválidos enviados |
| 401 | Unauthorized | Token ausente ou inválido |
| 403 | Forbidden | Usuário não tem permissão |
| 404 | Not Found | Recurso não encontrado |
| 422 | Unprocessable Entity | Erro de validação |
| 500 | Internal Server Error | Erro no servidor |

### 🧪 Testando a API

**Usando cURL:**
```bash
# Login
curl -X POST http://localhost:8989/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@locacar.com","password":"password123"}'

# Listar marcas (substitua TOKEN pelo recebido no login)
curl -X GET http://localhost:8989/api/v1/marca \
  -H "Authorization: Bearer TOKEN"
```

**Usando Postman:**
1. Importe a collection (se disponível)
2. Configure a variável `{{baseUrl}}` = `http://localhost:8989`
3. Faça login e copie o token
4. Configure Authorization > Bearer Token com o token obtido

**Usando Insomnia:**
Similar ao Postman, crie requisições com o Bearer Token no header.

## 💡 Exemplos Práticos de Uso

### Cenário 1: Cadastrar uma nova marca e modelo

```bash
# 1. Fazer login
curl -X POST http://localhost:8989/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@locacar.com","password":"password123"}'

# Copie o access_token da resposta

# 2. Criar nova marca (substitua TOKEN)
curl -X POST http://localhost:8989/api/v1/marca \
  -H "Authorization: Bearer TOKEN" \
  -F "nome=Fiat" \
  -F "imagem=@/caminho/para/logo-fiat.png"

# 3. Criar modelo para a marca (use o ID retornado, ex: 10)
curl -X POST http://localhost:8989/api/v1/modelo \
  -H "Authorization: Bearer TOKEN" \
  -F "marca_id=10" \
  -F "nome=Uno" \
  -F "numero_portas=4" \
  -F "lugares=5" \
  -F "air_bag=true" \
  -F "abs=false" \
  -F "imagem=@/caminho/para/uno.jpg"
```

### Cenário 2: Registrar um novo carro e locá-lo

```bash
# 1. Cadastrar o carro
curl -X POST http://localhost:8989/api/v1/carro \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "modelo_id": 15,
    "placa": "ABC-1234",
    "disponivel": true,
    "km": 0
  }'

# 2. Verificar clientes disponíveis
curl -X GET http://localhost:8989/api/v1/cliente \
  -H "Authorization: Bearer TOKEN"

# 3. Criar locação
curl -X POST http://localhost:8989/api/v1/locacao \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "cliente_id": 1,
    "carro_id": 20,
    "data_inicio": "2024-02-01",
    "data_fim_previsto": "2024-02-05",
    "valor_diaria": 120.00,
    "km_inicial": 0
  }'
```

### Cenário 3: Finalizar uma locação (devolução)

```bash
# Atualizar locação com dados de devolução
curl -X PUT http://localhost:8989/api/v1/locacao/5 \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "data_fim_realizado": "2024-02-05",
    "km_final": 450
  }'
```

### Cenário 4: Buscar carros disponíveis de uma marca específica

```bash
# Listar modelos da Toyota (marca_id=1)
curl -X GET "http://localhost:8989/api/v1/modelo?marca_id=1" \
  -H "Authorization: Bearer TOKEN"

# Listar apenas carros disponíveis
curl -X GET "http://localhost:8989/api/v1/carro?disponivel=1" \
  -H "Authorization: Bearer TOKEN"
```

### 📱 Exemplo de Integração com JavaScript/Fetch

```javascript
// Login
async function login() {
  const response = await fetch('http://localhost:8989/api/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      email: 'admin@locacar.com',
      password: 'password123'
    })
  });
  
  const data = await response.json();
  const token = data.data.access_token;
  localStorage.setItem('token', token);
  return token;
}

// Buscar marcas
async function getMarcas() {
  const token = localStorage.getItem('token');
  
  const response = await fetch('http://localhost:8989/api/v1/marca', {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json'
    }
  });
  
  const data = await response.json();
  return data.data;
}

// Criar novo cliente
async function createCliente(clienteData) {
  const token = localStorage.getItem('token');
  
  const response = await fetch('http://localhost:8989/api/v1/cliente', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(clienteData)
  });
  
  return await response.json();
}
```

## 🐳 Comandos Docker Úteis

### Gerenciamento de Containers

```bash
# Ver status dos containers
docker-compose ps

# Ver logs de todos os serviços
docker-compose logs -f

# Ver logs de um serviço específico
docker-compose logs -f app          # Logs do Laravel/PHP
docker-compose logs -f mysql        # Logs do MySQL
docker-compose logs -f nginx        # Logs do Nginx

# Parar todos os containers (mantém dados)
docker-compose down

# Parar e remover volumes (APAGA O BANCO!)
docker-compose down -v

# Reiniciar todos os containers
docker-compose restart

# Reiniciar apenas um serviço
docker-compose restart app
docker-compose restart mysql

# Reconstruir containers (após mudanças no Dockerfile)
docker-compose build
docker-compose up -d --build
```

### Acessar Containers

```bash
# Entrar no container da aplicação (Laravel/PHP)
docker-compose exec app bash

# Entrar no MySQL
docker-compose exec mysql bash
# Ou conectar direto ao MySQL
docker-compose exec mysql mysql -uroot -proot app_locadora_carros

# Entrar no Redis
docker-compose exec redis redis-cli
```

### Comandos Laravel (Artisan)

```bash
# Executar qualquer comando Artisan
docker-compose exec app php artisan <comando>

# Limpar caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Ver lista de rotas
docker-compose exec app php artisan route:list

# Rodar migrations
docker-compose exec app php artisan migrate

# Reverter última migration
docker-compose exec app php artisan migrate:rollback

# Resetar banco e rodar migrations novamente
docker-compose exec app php artisan migrate:fresh

# Resetar banco + seeders
docker-compose exec app php artisan migrate:fresh --seed

# Criar nova migration
docker-compose exec app php artisan make:migration create_example_table

# Criar novo Model
docker-compose exec app php artisan make:model Example

# Criar Controller
docker-compose exec app php artisan make:controller ExampleController

# Console interativo (Tinker)
docker-compose exec app php artisan tinker
```

### Composer (Gerenciador de Pacotes PHP)

```bash
# Instalar dependências
docker-compose exec app composer install

# Atualizar dependências
docker-compose exec app composer update

# Adicionar novo pacote
docker-compose exec app composer require nome/pacote

# Remover pacote
docker-compose exec app composer remove nome/pacote

# Atualizar autoload
docker-compose exec app composer dump-autoload
```

### Permissões (Linux/Mac)

```bash
# Corrigir permissões do storage e cache
docker-compose exec app chmod -R 777 storage bootstrap/cache

# Ou dar permissão ao usuário www-data
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

## 📁 Estrutura do Projeto

```
app_locadora_carros/
│
├── app/                           # Código da aplicação
│   ├── Http/
│   │   ├── Controllers/          # Controladores da API
│   │   │   ├── AuthController.php         # Autenticação JWT
│   │   │   ├── MarcaController.php        # CRUD de Marcas
│   │   │   ├── ModeloController.php       # CRUD de Modelos
│   │   │   ├── CarroController.php        # CRUD de Carros
│   │   │   ├── ClienteController.php      # CRUD de Clientes
│   │   │   └── LocacaoController.php      # CRUD de Locações
│   │   ├── Requests/             # Form Requests (validações)
│   │   │   ├── StoreMarcaRequest.php
│   │   │   ├── StoreModeloRequest.php
│   │   │   └── ...
│   │   ├── Resources/            # API Resources (transformação de dados)
│   │   └── Middleware/           # Middlewares (autenticação, CORS, etc.)
│   │
│   ├── Models/                   # Models Eloquent
│   │   ├── User.php              # Usuário do sistema
│   │   ├── Marca.php             # Marca de veículo
│   │   ├── Modelo.php            # Modelo de veículo
│   │   ├── Carro.php             # Carro físico
│   │   ├── Cliente.php           # Cliente da locadora
│   │   └── Locacao.php           # Locação (aluguel)
│   │
│   ├── Policies/                 # Policies de autorização
│   │   ├── CarroPolicy.php
│   │   ├── ClientePolicy.php
│   │   └── LocacaoPolicy.php
│   │
│   ├── Repositories/             # Repository Pattern
│   │   ├── AbstractRepository.php      # Repositório base
│   │   ├── MarcaRepository.php
│   │   ├── ModeloRepository.php
│   │   └── ...
│   │
│   ├── Services/                 # Camada de serviços (lógica de negócio)
│   │   ├── AuthService.php
│   │   ├── CarroService.php
│   │   └── ...
│   │
│   └── Traits/
│       └── ApiResponse.php       # Trait para respostas padronizadas
│
├── config/                        # Arquivos de configuração
│   ├── database.php              # Configuração do banco
│   ├── jwt.php                   # Configuração JWT
│   └── ...
│
├── database/
│   ├── migrations/               # Migrations (estrutura do banco)
│   │   ├── create_marcas_table.php
│   │   ├── create_modelos_table.php
│   │   ├── create_carros_table.php
│   │   └── ...
│   ├── seeders/                  # Seeders (dados iniciais)
│   │   ├── MarcaSeeder.php
│   │   ├── ModeloSeeder.php
│   │   └── ...
│   └── factories/                # Factories para testes
│
├── public/                        # Arquivos públicos
│   ├── index.php                 # Entry point da aplicação
│   ├── storage/                  # Link para uploads (criado com storage:link)
│   ├── css/                      # CSS compilado
│   └── js/                       # JavaScript compilado
│
├── resources/
│   ├── js/                       # Código Vue.js (SPA)
│   │   ├── app.js                # Bootstrap do Vue
│   │   ├── router.js             # Rotas do frontend
│   │   ├── components/           # Componentes Vue
│   │   └── views/                # Páginas Vue
│   ├── css/                      # Estilos (TailwindCSS)
│   └── views/                    # Blade templates (Laravel)
│
├── routes/
│   ├── api.php                   # Rotas da API REST
│   └── web.php                   # Rotas web
│
├── storage/
│   ├── app/
│   │   └── public/               # Arquivos enviados (imagens)
│   │       ├── marcas/           # Logos de marcas
│   │       └── modelos/          # Fotos de modelos
│   ├── framework/                # Cache, sessões, views compiladas
│   └── logs/                     # Logs da aplicação
│
├── tests/                         # Testes automatizados
│   ├── Feature/                  # Testes de integração
│   └── Unit/                     # Testes unitários
│
├── docker/                        # Configurações Docker
│   └── nginx/                    # Configuração do Nginx
│
├── .env                          # Variáveis de ambiente (não versionado)
├── .env.example                  # Exemplo de .env
├── composer.json                 # Dependências PHP
├── package.json                  # Dependências JavaScript
├── docker-compose.yml            # Orquestração dos containers
├── Dockerfile                    # Imagem Docker do PHP
└── README.md                     # Este arquivo
```

### 🔍 Principais Diretórios Explicados

- **`app/Http/Controllers/`**: Lógica de controle das requisições HTTP
- **`app/Models/`**: Representação das tabelas do banco como objetos PHP
- **`app/Repositories/`**: Encapsula queries complexas do banco
- **`app/Services/`**: Lógica de negócio reutilizável
- **`database/migrations/`**: Versionamento da estrutura do banco
- **`resources/js/`**: Frontend Vue.js (SPA)
- **`routes/api.php`**: Definição de todos os endpoints da API
- **`storage/app/public/`**: Onde ficam os arquivos enviados pelos usuários

### 🗄️ Diagrama do Banco de Dados

```
┌─────────────┐
│   users     │
│─────────────│
│ id          │
│ name        │
│ email       │◄────────────────┐
│ password    │                 │
└─────────────┘                 │
                                │
┌─────────────┐      ┌──────────┴──────┐      ┌─────────────┐
│   marcas    │      │   locacoes      │      │  clientes   │
│─────────────│      │─────────────────│      │─────────────│
│ id          │◄─┐   │ id              │   ┌─►│ id          │
│ nome        │  │   │ cliente_id      │───┘  │ nome        │
│ imagem      │  │   │ carro_id        │───┐  │ cpf         │
└─────────────┘  │   │ data_inicio     │   │  │ cnh         │
                 │   │ data_fim_prev   │   │  │ telefone    │
┌─────────────┐  │   │ data_fim_real   │   │  │ email       │
│  modelos    │  │   │ valor_diaria    │   │  └─────────────┘
│─────────────│  │   │ km_inicial      │   │
│ id          │  │   │ km_final        │   │  ┌─────────────┐
│ marca_id    │──┘   └─────────────────┘   │  │   carros    │
│ nome        │                             └─►│─────────────│
│ imagem      │◄───────────────────────────────│ id          │
│ num_portas  │                                │ modelo_id   │
│ lugares     │                                │ placa       │
│ air_bag     │                                │ disponivel  │
│ abs         │                                │ km          │
└─────────────┘                                └─────────────┘

Relacionamentos:
• Uma Marca tem muitos Modelos (1:N)
• Um Modelo pertence a uma Marca (N:1)
• Um Modelo tem muitos Carros (1:N)
• Um Carro pertence a um Modelo (N:1)
• Um Cliente tem muitas Locações (1:N)
• Um Carro tem muitas Locações (1:N)
• Uma Locação pertence a um Cliente e um Carro (N:1)
```

## 🔧 Troubleshooting

### ❌ Erro de permissão no storage

**Problema:** Erro ao fazer upload de imagens ou ao escrever logs.

**Solução:**
```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

---

### ❌ Banco de dados não conecta

**Problema:** `SQLSTATE[HY000] [2002] Connection refused`

**Causas e Soluções:**

1. **Verificar se o DB_HOST está correto no `.env`:**
   ```env
   DB_HOST=mysql  # Deve ser 'mysql' (nome do serviço Docker), não 'localhost'
   ```

2. **Aguardar o MySQL inicializar completamente:**
   ```bash
   docker-compose logs -f mysql
   # Aguarde a mensagem: "ready for connections"
   ```

3. **Limpar cache de configuração:**
   ```bash
   docker-compose exec app php artisan config:clear
   ```

---

### ❌ Erro "Class not found"

**Problema:** `Class 'App\Http\Controllers\ExemploController' not found`

**Solução:**
```bash
docker-compose exec app composer dump-autoload
```

---

### ❌ Token JWT inválido ou expirado

**Problema:** `Token has expired` ou `Token not provided`

**Soluções:**

1. **Regenerar chave JWT:**
   ```bash
   docker-compose exec app php artisan jwt:secret --force
   ```

2. **Fazer login novamente** para obter novo token

3. **Limpar cache:**
   ```bash
   docker-compose exec app php artisan cache:clear
   ```

---

### ❌ Porta já está em uso

**Problema:** `Bind for 0.0.0.0:8989 failed: port is already allocated`

**Soluções:**

1. **Descobrir quem está usando a porta:**
   ```bash
   # Windows
   netstat -ano | findstr :8989
   
   # Linux/Mac
   lsof -i :8989
   ```

2. **Matar o processo que está usando a porta** ou alterar a porta no `docker-compose.yml`:
   ```yaml
   nginx:
     ports:
       - "8990:80"  # Mude de 8989 para 8990
   ```

---

### ❌ Imagens não aparecem após upload

**Problema:** Imagens são enviadas mas retornam 404.

**Solução:**
```bash
# Criar link simbólico do storage
docker-compose exec app php artisan storage:link

# Verificar se o link foi criado
docker-compose exec app ls -la public/storage
```

---

### ❌ Reconstruir containers do zero

**Problema:** Containers corrompidos ou comportamento estranho.

**Solução:**
```bash
# Parar e remover tudo (CUIDADO: apaga o banco!)
docker-compose down -v

# Reconstruir sem usar cache
docker-compose build --no-cache

# Subir novamente
docker-compose up -d

# Reinstalar dependências e recriar banco
docker-compose exec app composer install
docker-compose exec app php artisan migrate:fresh --seed
```

---

### ❌ Erro 500 ao acessar a aplicação

**Problema:** Erro interno do servidor.

**Diagnóstico:**

1. **Ver logs detalhados:**
   ```bash
   docker-compose logs -f app
   docker-compose logs -f nginx
   ```

2. **Verificar logs do Laravel:**
   ```bash
   docker-compose exec app tail -f storage/logs/laravel.log
   ```

3. **Ativar modo debug no `.env`:**
   ```env
   APP_DEBUG=true
   ```
   **Importante:** Desative após identificar o problema!

---

### ❌ NPM/Frontend não compila

**Problema:** Erro ao executar `npm run dev` ou `npm run watch`.

**Soluções:**

1. **Remover node_modules e reinstalar:**
   ```bash
   rm -rf node_modules package-lock.json
   npm install
   ```

2. **Limpar cache do npm:**
   ```bash
   npm cache clean --force
   npm install
   ```

3. **Verificar versão do Node:**
   ```bash
   node --version  # Deve ser 16.x ou superior
   ```

---

### ❌ CORS Error ao usar a API

**Problema:** `Access to XMLHttpRequest blocked by CORS policy`

**Solução:**

1. **Verificar configuração em `config/cors.php`:**
   ```php
   'allowed_origins' => ['http://localhost:8989'],
   ```

2. **Limpar cache de configuração:**
   ```bash
   docker-compose exec app php artisan config:clear
   ```

---

### 🆘 Ainda com problemas?

1. **Verifique os logs:**
   ```bash
   docker-compose logs -f
   ```

2. **Teste a conexão com o banco:**
   ```bash
   docker-compose exec mysql mysql -uroot -proot -e "SHOW DATABASES;"
   ```

3. **Verifique se todos os containers estão rodando:**
   ```bash
   docker-compose ps
   ```

4. **Reinicie tudo:**
   ```bash
   docker-compose restart
   ```

## 🧪 Testes

O projeto inclui testes automatizados usando PHPUnit.

### Executar Todos os Testes

```bash
docker-compose exec app php artisan test
```

### Executar Testes Específicos

```bash
# Testes de uma classe específica
docker-compose exec app php artisan test --filter=MarcaTest

# Testes de um método específico
docker-compose exec app php artisan test --filter=test_can_create_marca
```

### Executar com Cobertura

```bash
docker-compose exec app php artisan test --coverage
```

### Estrutura de Testes

```
tests/
├── Feature/              # Testes de integração (API endpoints)
│   ├── MarcaTest.php
│   ├── ModeloTest.php
│   ├── CarroTest.php
│   └── ...
└── Unit/                 # Testes unitários (lógica isolada)
    ├── Models/
    ├── Services/
    └── ...
```

### Criar Novos Testes

```bash
# Teste de feature
docker-compose exec app php artisan make:test ExemploTest

# Teste unitário
docker-compose exec app php artisan make:test ExemploTest --unit
```

## 🏗️ Arquitetura e Padrões

### Fluxo de uma Requisição

```
1. Requisição HTTP → Nginx
2. Nginx → PHP-FPM (Laravel)
3. Laravel → Middleware (autenticação, CORS, etc.)
4. Middleware → Route (routes/api.php)
5. Route → Controller
6. Controller → Form Request (validação)
7. Form Request → Service (lógica de negócio)
8. Service → Repository (acesso ao banco)
9. Repository → Model → Database
10. Database → Model → Repository
11. Repository → Service → Controller
12. Controller → ApiResponse Trait (formatação)
13. ApiResponse → JSON Response → Cliente
```

### Padrões Utilizados

#### 1. Repository Pattern
Separa a lógica de acesso aos dados da lógica de negócio.

```php
// MarcaRepository.php
public function findWithModelos($id) {
    return Marca::with('modelos')->findOrFail($id);
}
```

#### 2. Service Layer
Encapsula lógica de negócio complexa.

```php
// CarroService.php
public function alugar($carroId) {
    // Verifica disponibilidade
    // Atualiza status
    // Registra histórico
}
```

#### 3. Form Request Validation
Validações separadas e reutilizáveis.

```php
// StoreMarcaRequest.php
public function rules() {
    return [
        'nome' => 'required|unique:marcas|min:3',
        'imagem' => 'required|image|max:2048'
    ];
}
```

#### 4. API Response Trait
Respostas padronizadas em toda a API.

```php
// ApiResponse.php (Trait)
return $this->successResponse($data, 'Mensagem', 200);
return $this->errorResponse('Erro', 400);
```

#### 5. Policy-Based Authorization
Controle de acesso granular.

```php
// CarroPolicy.php
public function delete(User $user, Carro $carro) {
    return !$carro->locacoes()->whereNull('data_fim_realizado')->exists();
}
```

### Camadas da Aplicação

```
┌─────────────────────────────────────┐
│         API Client                  │ (Frontend Vue.js / Mobile / Postman)
└───────────────┬─────────────────────┘
                ↓
┌─────────────────────────────────────┐
│         Routes (API)                │ (routes/api.php)
└───────────────┬─────────────────────┘
                ↓
┌─────────────────────────────────────┐
│         Middleware                  │ (auth:api, cors, etc.)
└───────────────┬─────────────────────┘
                ↓
┌─────────────────────────────────────┐
│         Controllers                 │ (HTTP Layer)
└───────────────┬─────────────────────┘
                ↓
┌─────────────────────────────────────┐
│         Form Requests               │ (Validação)
└───────────────┬─────────────────────┘
                ↓
┌─────────────────────────────────────┐
│         Services                    │ (Lógica de Negócio)
└───────────────┬─────────────────────┘
                ↓
┌─────────────────────────────────────┐
│         Repositories                │ (Queries Complexas)
└───────────────┬─────────────────────┘
                ↓
┌─────────────────────────────────────┐
│         Models (Eloquent)           │ (ORM)
└───────────────┬─────────────────────┘
                ↓
┌─────────────────────────────────────┐
│         Database (MySQL)            │
└─────────────────────────────────────┘
```

### Benefícios da Arquitetura

- ✅ **Separação de Responsabilidades**: Cada camada tem uma função específica
- ✅ **Testabilidade**: Fácil de testar cada camada isoladamente
- ✅ **Manutenibilidade**: Código organizado e fácil de manter
- ✅ **Escalabilidade**: Fácil adicionar novos recursos
- ✅ **Reusabilidade**: Código pode ser reutilizado em diferentes contextos

## ❓ Perguntas Frequentes (FAQ)

### Posso usar este projeto em produção?

Sim! O código está preparado para produção, mas você deve:
- Alterar `APP_DEBUG=false` no `.env`
- Usar senhas fortes para banco de dados
- Configurar HTTPS
- Configurar backup do banco de dados
- Revisar políticas de segurança

### 🔒 Checklist de Segurança para Produção

Antes de colocar em produção, configure:

```env
# .env - Configurações de Produção
APP_ENV=production
APP_DEBUG=false                    # Nunca true em produção!
APP_URL=https://seudominio.com

# Senhas fortes
DB_PASSWORD=senha-complexa-aqui
REDIS_PASSWORD=outra-senha-forte

# HTTPS obrigatório
FORCE_HTTPS=true

# CORS restrito
SANCTUM_STATEFUL_DOMAINS=seudominio.com
```

**Outras medidas:**
- ✅ Configure SSL/TLS (HTTPS)
- ✅ Habilite firewall no servidor
- ✅ Configure backups automáticos do banco
- ✅ Limite rate limiting da API
- ✅ Configure logs de segurança
- ✅ Use senhas fortes e únicas
- ✅ Mantenha dependências atualizadas
- ✅ Configure variáveis de ambiente corretamente

### Como adicionar um novo recurso (ex: Funcionários)?

1. Criar migration: `php artisan make:migration create_funcionarios_table`
2. Criar model: `php artisan make:model Funcionario`
3. Criar controller: `php artisan make:controller FuncionarioController --api`
4. Criar repository: Copiar e adaptar um repository existente
5. Criar form requests para validação
6. Adicionar rotas em `routes/api.php`
7. Criar seeders e factories para testes

### Como fazer deploy?

**Opções:**
- **Docker**: Use o `docker-compose.yml` em um servidor VPS
- **Compartilhado**: Faça upload via FTP (menos recomendado)
- **Cloud**: AWS, Google Cloud, DigitalOcean, Heroku
- **Laravel Forge**: Plataforma especializada em Laravel

### Posso usar MongoDB ao invés de MySQL?

Sim, mas precisará:
- Instalar o driver MongoDB para PHP
- Usar o pacote `jenssegers/mongodb`
- Adaptar os models
- Reescrever as migrations

### Como adicionar mais usuários administradores?

```bash
docker-compose exec app php artisan tinker

User::create([
    'name' => 'Novo Admin',
    'email' => 'admin2@locacar.com',
    'password' => bcrypt('senha-segura')
]);
```

### A API tem limite de requisições (rate limit)?

Por padrão, Laravel limita a 60 requisições por minuto por IP. Você pode ajustar em `app/Http/Kernel.php`.

### Como integrar com um app mobile?

A API já está pronta! Basta:
1. Fazer requisições HTTP para `http://seu-dominio.com/api/v1/`
2. Implementar autenticação JWT
3. Armazenar o token recebido no login
4. Enviar o token em todas as requisições autenticadas

### Posso mudar a porta 8989?

Sim! Edite o `docker-compose.yml`:

```yaml
nginx:
  ports:
    - "9000:80"  # Mude para a porta desejada
```

Após alterar, execute:
```bash
docker-compose down
docker-compose up -d
```

### Como fazer backup do banco de dados?

```bash
# Exportar banco
docker-compose exec mysql mysqldump -uroot -proot app_locadora_carros > backup.sql

# Importar banco
docker-compose exec -T mysql mysql -uroot -proot app_locadora_carros < backup.sql
```

### O projeto tem documentação Swagger/OpenAPI?

Não está implementado ainda, mas você pode adicionar usando o pacote `darkaonline/l5-swagger`.

## 🚀 Próximos Passos e Melhorias

Ideias para expandir o projeto:

- [ ] Implementar sistema de pagamentos (Stripe, PagSeguro)
- [ ] Adicionar notificações por email (locação confirmada, devolução, etc.)
- [ ] Dashboard com gráficos e relatórios
- [ ] Sistema de multas por atraso
- [ ] Histórico de manutenção dos carros
- [ ] Sistema de reservas online
- [ ] Integração com WhatsApp para notificações
- [ ] App mobile (React Native / Flutter)
- [ ] Sistema de avaliação de clientes
- [ ] Documentação Swagger/OpenAPI
- [ ] Testes automatizados completos
- [ ] CI/CD com GitHub Actions
- [ ] Dockerização otimizada para produção

## 📚 Recursos de Aprendizado

Se você está aprendendo com este projeto:

**Laravel:**
- [Documentação Oficial Laravel 8](https://laravel.com/docs/8.x)
- [Laracasts](https://laracasts.com/) - Screencast tutoriais
- [Laravel Daily](https://www.youtube.com/c/LaravelDaily) - YouTube

**Docker:**
- [Documentação Docker](https://docs.docker.com/)
- [Docker para Desenvolvedores](https://www.youtube.com/watch?v=Kzcz-EVKBEQ)

**Vue.js:**
- [Documentação Vue 3](https://vuejs.org/)
- [Vue Mastery](https://www.vuemastery.com/)

**APIs RESTful:**
- [REST API Tutorial](https://restfulapi.net/)
- [HTTP Status Codes](https://httpstatuses.com/)

## 📝 Licença

Este projeto está sob a licença MIT. Isso significa que você pode:

- ✅ Usar comercialmente
- ✅ Modificar
- ✅ Distribuir
- ✅ Uso privado

**Condições:**
- Incluir a licença e direitos autorais originais

Veja o arquivo `LICENSE` para mais detalhes.

## 🤝 Contribuindo

Contribuições são bem-vindas! Para contribuir:

1. Fork este repositório
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

### Diretrizes de Contribuição

- Siga o PSR-12 (padrão de código PHP)
- Escreva testes para novas funcionalidades
- Documente mudanças significativas
- Mantenha o código limpo e legível

## 👨‍💻 Autor

**Dorian Junior**

- GitHub: [@dorianjunior](https://github.com/dorianjunior)
- LinkedIn: [Adicione seu LinkedIn]
- Email: [Adicione seu email]

## 🙏 Agradecimentos

- Laravel Framework
- TailwindCSS
- Vue.js
- Comunidade open source

---

<div align="center">

⭐ Se este projeto foi útil, não esqueça de dar uma estrela!

**Made with ❤️ and ☕**

</div>

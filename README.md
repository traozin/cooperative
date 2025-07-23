# 📌 Desafio Unicred - Cadastro de Cooperados

Este projeto foi desenvolvido como parte do processo seletivo da **Unicred**, com o objetivo de criar uma API RESTful e uma interface web para cadastro, listagem e visualização de cooperados.

---

## 🧠 Contexto

O sistema permite o **CRUD de cooperados**, que podem ser pessoas físicas ou jurídicas. Cada cooperado possui dados essenciais como nome, CPF/CNPJ, data de nascimento/constituição, renda/faturamento, telefone e email.

As regras de negócio definem validações obrigatórias e impedem duplicidade de documentos (CPF/CNPJ).

A solução foi implementada utilizando **Laravel (API)**, **React (Frontend)**, **MySQL** e **Docker**, com testes automatizados usando **PHPUnit**.

---

## 🚀 Como subir o projeto

### ✅ Pré-requisitos

* [Docker](https://www.docker.com/) e [Docker Compose](https://docs.docker.com/compose/) instalados.
* Portas **8001** (API), **3001** (frontend) e **3306** (MySQL) livres.

### 🧨 Subir ambiente completo (API + Web + Banco)

```bash
docker compose up --build
```

Esse comando irá:

* Criar e subir os containers do **backend**, **frontend** e **MySQL**;
* Instalar dependências automaticamente;
* Executar as migrations e inicializar o servidor Laravel;

> ⚠️ Use `--build` na primeira vez ou após alterações no Dockerfile.
> 🐢 Se você estiver utilizando Windows com WSL, o script do entrypoint (especialmente do backend) pode levar mais tempo para ser executado.

### 🌐 Acessos locais

* API: [http://localhost:8001](http://localhost:8001)
* Frontend: [http://localhost:3001](http://localhost:3001)

---

## 🧱 Estrutura do Projeto

```bash
/cooperative
├── api            # Backend Laravel
│   ├── app
│   ├── routes
│   └── tests
├── web            # Frontend React
│   ├── src
│   └── public
├── docker-compose.yml
└── README.md
```

---

## 📡 Endpoints Principais

### Criar cooperado

`POST /api/v1/cooperados`

**Payload:**

```json
{
  "nome": "João da Silva",
  "documento": "12345678909",
  "data_nascimento": "1990-01-01",
  "renda": 5000.00,
  "telefone": "(11) 91234-5678",
  "email": "joao@email.com"
}
```

### Listar cooperados

`GET /api/v1/cooperados`

### Buscar cooperado por ID

`GET /api/v1/cooperados/{id}`

### Atualizar cooperado

`PUT /api/v1/cooperados/{id}`

### Deletar cooperado

`DELETE /api/v1/cooperados/{id}`

---

## ✅ Validações Implementadas

* Documento (CPF/CNPJ) válido
* Documento único no banco
* Data obrigatória (nascimento ou constituição)
* Renda/faturamento numérico
* Telefone com DDD e formato válido

---

## 🧪 Rodando os Testes

### Acessar o container da API:

```bash
docker exec -it cooperative-api bash
```

### Rodar os testes com PHPUnit:

```bash
php artisan test
```

Ou:

```bash
./vendor/bin/phpunit
```

---

## 📌 Diferenciais Aplicados

* Separação por camadas (Controller, Service, Repository)
* Validações customizadas com `FormRequest`
* Testes automatizados com `PHPUnit`
* Ambiente dockerizado de forma simples (`docker compose up --build`)
* Organização e legibilidade de código
* Frontend desacoplado e consumindo a API

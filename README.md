# Back End Test Project <img src="https://www.moveissimonetti.com.br/arquivos/header-logo.png?v=636639862737800000" align="right" height="50px" />

## Acesse a documentação da API em http://localhost:8000/api/doc.
http://http://localhost:8080/docs/documentation.html

# Controle de Investimento API

Bem-vindo à documentação da API Controle de Investimento. Esta API é projetada para fornecer funcionalidades relacionadas ao controle de investimentos.

## Instruções de Uso

### 1. Instalação

## Certifique-se de ter o [Composer](https://getcomposer.org/) instalado. Em seguida, execute o seguinte comando para instalar as dependências do projeto:

composer install

## Instale o Symfony Skeleton
composer create-project symfony/skeleton api_investment_genivan

# Instale o componente Doctrine para manipulação de banco de dados:
composer require symfony/orm-pack

#Instale o componente maker-bundle:
composer require symfony/maker-bundle –dev

# Crie uma entidade Investment:
bin/console make:entity Investment
bin/console make:entity 

# Siga as instruções para criar a entidade, adicionando os campos necessários como owner, creationDate, value, withdrawn, e gains.
#Apos a criação da entidade rode os seguinets comandos para verificar as tabelas necesarias e depois para crialas:
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate

# Crie um controlador para gerenciar os investimentos:
bin/console make:controller InvestmentController
#Implemente as ações necessárias neste controlador, como createInvestment, viewInvestment, withdrawInvestment, e listInvestments.

### Estrutura da API
/your-project
│
├── bin/
│   └── console
│
├── config/
│   ├── packages/
│   │   └── ... (Configurações do pacote)
│   ├── routes/
│   │   └── ... (Definição de rotas)
│   └── ... (Outras configurações)
│
├── public/
│   ├── index.php
│   └── ... (Recursos públicos, como imagens)
│
├── src/
│   ├── Controller/
│   │   └── ... (Controladores da API)
│   ├── Entity/
│   │   └── ... (Entidades Doctrine)
│   ├── Repository/
│   │   └── ... (Repositórios Doctrine)
│   └── ... (Outras classes PHP)
│
├── templates/
│   └── ... (Templates Twig, opcional)
│
├── tests/
│   └── ... (Testes PHPUnit)
│
├── translations/
│   └── ... (Arquivos de tradução, opcional)
│
├── var/
│   └── ... (Cache, logs, sessions, etc.)
│
├── vendor/
│   └── ... (Dependências do Composer)
│
├── .env
├── .env.dist
├── .gitignore
├── composer.json
├── phpunit.xml.dist
├── symfony.lock
└── ... (Outros arquivos de configuração)

### Execução do Servidor
php bin/console server:start

### Endpoints Principais
POST /api/investment: Cria um novo investimento.
GET /api/investments/listInvestments: Lista investimentos paginados.
GET /api/investment/{investmentId}: Visualiza detalhes de um investimento.
PUT /api/investment/{investmentId}/withdraw: Realiza saque de um investimento.

### Documentação
. Symfony Framework
. Doctrine ORM
. OpenAPI para geração de documentação API.

### Dos Testes Via Insomnia
## Passo 1: Adicionar um Novo Request
Abra o Insomnia.
No menu lateral esquerdo, clique em "+", e selecione "Request".
Dê um nome ao seu request e escolha o método HTTP apropriado (GET, POST, PUT, etc.).

## Passo 2: Configurar os Detalhes do Request
Insira a URL do endpoint que você deseja testar. Por exemplo, http://localhost:8080/api/investment.
Selecione a guia "Body" para adicionar dados de requisição, caso necessário.
Selecione a guia "Headers" para adicionar cabeçalhos, como "Content-Type" se estiver enviando dados JSON.

## Passo 3: Executar o Request
Clique no botão "Send" para executar o request.
Observe a resposta na guia "Response". Certifique-se de que a resposta está de acordo com o esperado.

### Exemplos de REquest
Método: POST
URL: http://localhost:8080/api/investment
Headers: Adicione um header Content-Type: application/json
Body: Adicione os dados do investimento em formato JSON.
Exemplo:
    {
        "name": "Nome do Investimento",
        "value": 1000,
        "created_at": "2022-01-09T12:00:00Z"
    }
Clique em "Send" para executar o request.
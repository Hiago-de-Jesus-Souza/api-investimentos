# Documentação Manual da API de Investimentos

## Visão Geral

Esta API gerencia informações sobre investimentos e permite realizar operações como criar, visualizar, listar e realizar saques em investimentos.

**Base URL: /api**

Cria um novo investimento.

### Parâmetros de Requisição
* `name` (obrigatório): Nome do investidor
* `value` (obrigatório): Valor inicial do investimento.
* `created_at`  Data de criação do investimento (opcional, padrão: há 1 ano).

### Exemplo de Requisição
```
{
  "name": "John Doe",
  "value": 1000
}
```
#### Resposta de Sucesso

```
{
  "success": true,
  "message": "Investimento criado com sucesso."
}
```

**`GET /investment/{investmentId}`**

Retorna os detalhes de um investimento específico.

**Parâmetros de Requisição**

**`investmentId`** (obrigatório): ID do investimento desejado.

#### Resposta de Sucesso
```
{
  "success": true,
  "message": "Saque do investimento realizado com sucesso",
  "withdrawal_amount": 1078.5
}
```

### Listagem de Investimentos

**`GET /investments/listInvestments`**

Retorna uma lista paginada de investimentos.

**Parâmetros de Requisição**

* `page`: Número da página desejada (opcional, padrão: 1).
* `perPage`: Quantidade de itens por página (opcional, padrão: 10).

### Resposta de Sucesso
```
{
  "investments": [
    {
      "id": 1,
      "value": 1000,
      "createdAt": "2023-01-10 15:30:00"
    },
    {
      "id": 2,
      "value": 1500,
      "createdAt": "2023-01-09 10:45:00"
    }
  ],
  "total": 15
}

```

### Considerações Finais

* Todos os valores monetários são em reais (BRL).
* As datas são retornadas no formato `Y-m-d H:i:s`.
* Certifique-se de incluir cabeçalhos apropriados para autenticação e segurança ao fazer solicitações para a API em um ambiente de produção.


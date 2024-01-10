# Back End Test Project <img src="https://www.moveissimonetti.com.br/arquivos/header-logo.png?v=636639862737800000" align="right" height="50px" />

O teste pede uma criação de uma API onde a principal linguagem seja PHP

## Escopo

Neste desafio você deverá construir uma API para uma aplicação que armazena e gerencia investimentos, ela deverá ter as seguintes funcionalidades:
1. __Criação__ de um investimento com proprietário, data de criação e valor.
    1. A data de criação de um investimento pode ser hoje ou uma data passada.
    2. Um investimento não deve ser ou tornar-se negativo.
2. __Visualização__ de um investimento com seu valor inicial e saldo esperado.
    1. O saldo esperado deve ser a soma do valor investido e dos ganhos.
    2. Se um investimento já foi retirado, o saldo deve refletir os ganhos desse investimento
3. __Retirada__ de um investimento.
    1. O saque será sempre a soma do valor inicial e seus ganhos, não sendo aceito saque parcial.
    2.As retiradas podem acontecer no passado ou hoje, mas não podem acontecer antes da criação do investimento ou no futuro.
    3. Os impostos precisam ser aplicados aos saques antes de mostrar o valor final.
4. __Lista__ dos investimentos de uma pessoa
    1. Esta lista deve ter paginação.

## Cálculo de ganho

O investimento pagará 0,52% todo mês no mesmo dia da criação do investimento.

Dado que o ganho é pago mensalmente, deve ser tratado como ganho composto , o que significa que a cada novo período (mês) o valor ganho passará a fazer parte do saldo do investimento para o próximo pagamento.

## Tributação

Quando o dinheiro é retirado, o imposto é acionado. Os impostos aplicam-se apenas à parte do lucro/ganho do dinheiro retirado. Por exemplo, se o investimento inicial foi de 1.000,00, o saldo atual é de 1.200,00, então os impostos serão aplicados sobre os 200,00.

* Se tiver menos de um ano o percentual será de 22,5% (imposto = 45,00).
* Se tiver entre um e dois anos, o percentual será de 18,5% (imposto = 37,00).
* Se tiver mais de dois anos, o percentual será de 15% (imposto = 30,00).

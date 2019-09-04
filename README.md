# test-PHPJunior
 
# Descrição
- Tal aplicação, através de pontos ja pré-definidos (A - B - C - D - E), realiza o calculo e apresenta o melhor caminho possível com a distancia, sendo calculado o custo logo após e apresentando um retorno com os pontos que formaram o melhor caminho e o custo total de tal caminho.

 
# Pré-Requisitos
- Composer (https://getcomposer.org/download/);
- Algum navegador WEB.

# Execução
- Com o composer instalado, utilizar o terminal (CMD) e ir para o local da pasta do projeto "/test-PHPJunior";
- Estando dentro da pasta do projeto, é necessário utilizar o comando: **php artisan serve** para que assim seja executado o projeto em localhost;
- Abrir o navegador e acessar: http://localhost:8000/api/calcularota/A/E/10/2.5 onde:A - origem, E - destino, 10 - autonomia do veículo e 2.5 - o valor do litro combustivel;
- Através de JSON será retornado o melhor rota com custo minimo e o custo em si.

![](/funcionando1.jpg)     ![](/funcionando2.jpg)


# Ferramentas utilizadas no desenvolvimento
- Sistema Operacional: Windows 10;
- Linguagem: PHP com Framework: Laravel;
- Visual Studio Code.

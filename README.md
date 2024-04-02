
# Validador de JWT

O projeto JWT Validator consiste em uma API construída com PHP 8.2 e Laravel 10, cujo o intuito é realizar a validação de tokens no formato JWT. O ciclo de vida do projeto se resume a receber por meio de um endpoint um token e retornar uma resposta que sinalize se o token tem um formato válido ou não de acordo com determinadas regras.
## Tecnologias

**BackEnd:** PHP 8.2, Laravel 10

**DevOps e CloudProvider:** Docker, Git, GitHub Actions, AWS EC2

**Arquitetura de Software**: Clean Architecture, Domain Driven Design

## Instruções básicas para a execução do projeto

Realize o clone do projeto.

```bash
  git clone https://github.com/PedroMeira01/api-jwt-validator/
```
    
Você poderá executar o projeto de duas maneiras, com Docker ou localmente.

1 - Docker

Abra seu terminal, navegue até a pasta raiz do projeto e execute o comando abaixo.

```bash
  docker-compose up --build
```
* É necessário ter o Docker instalado e configurado em seu computador.

2 - Local

Navegue até a pasta raiz do projeto e instale as dependências:
```bash
  composer install
```

Inicie o servidor embutido do Laravel:
```bash
  php artisan serve
```
Pronto, seu projeto estará em execução, acesse por localhost:8000.
## Documentação da API

A API está disponível no endereço: http://3.137.174.158. (Certifique-se de usar uma rota válida.)

**Validação de JWT**

Recebe um token JWT e retorna se o token é válido ou não.
```http
  POST /api/v1/token-validation/jwt
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `token`      | `string` | **Obrigatório**. O token a ser validado. |

RESPONSE 200 (application/json)

```json
{
    "isValid": true,
    "message": "Valid Token"
}
```
RESPONSE 422 (application/json)
```json
{
    "isValid": false,
    "message": "The token sent is incompatible with the JWT format."
}
```
## Rodando os testes

Para rodar os testes, execute o comando abaixo na raiz do projeto:

```bash
  ./vendor/bin/phpunit
```


## Descrição da arquitetura e implementação do projeto

**1 - Ciclo de vida da requisição**:

O ciclo de vida da aplicação se inicia no arquivo de rotas de API:

- routes/api.php

O caminho da rota definida neste arquivo para a validação do token JWT é: "/api/v1/token-validation/jwt". Esta rota está envolvida por um Middleware que realiza o log dos dados de entrada fornecidos pelo Client e posteriormente, na saída da requisição realiza o log do resultado do processamento. Após esta etapa, a requisição passa pela classe "TokenValidatorRequest", esta classe é responsável por aplicar regras de validação nos dados recebidos pela request.

Caso a requisição atenda os critérios definidos no Form Request, os dados de entrada chegam ao controlador "TokenValidatorController". A partir do controlador a requisição deixará a camada de Infraestrutura provida pelo Laravel e entrará na camada de aplicação.

- Request -> Middleware -> FormRequest -> Controller

**2 - Clean Architecture e Domain Driven Design (DDD)**

O projeto utiliza Clean Architecture e DDD, de forma que a camada de infraestrutura passa a ser a estrutura de pastas e arquivos fornecidas pelo framework, a camada de aplicação fica contida em "src/Core/UseCase" e a camada de regra de negócio fica em "src/Core/Domain". O uso dessas duas metodologias consequentemente implicam na utilização do SOLID (SRP).

**2.1 - Camada de Aplicação**

Após a requisição ser processada pelo controlador, a classe "ValidateJWTUseCase" é acionada. O objetivo de um UseCase na Clean Arch é orquestrar a intenção do usuário para que os recursos necessários para a funcionalidade sejam devidamente acessados, recursos estes que no contexto deste projeto estão contidos na camada de regra de negócio.

**2.2 - Camada de Regra de Negócio**

A camada de regra de negócio, é responsável por definir o que de fato é o "Core" do projeto, de forma que não dependa do uso de frameworks, bibliotecas ou recursos externos. O objetivo de utilizar esta camada é promover o mínimo de acoplamento possível além de oferecer possibilidades de abstrações, estabelecer uma alta coesão de código e permitir a extensibilidade do código.

No contexto deste projeto, nesta camada encontraremos as classes de entidades "JWT" e "Claims" em "src/Domain/Entity" e são essas classes que executam os critérios de validações definidos para o formato do token e para o formato das claims. Essas classes são auto-validativas, em conformidade com o DDD.

**2.3 - Abstração de validações**

As classes "JWT" e "Claims" utilizam de validações que são recorrentes em projetos de software, como validação de tamanho de caracteres, formato da string e etc. Para isso, foi criado uma abstração através da classe "DomainValidations" em "src/Core/Domain/Validations" que contém implementações de métodos estáticos que podem ser acionados por quaisquer entidades do sistema para validações recorrentes.

**2.4 - O benefício da utilização dessas metodologias**

Através do uso destas metodologias, a qualquer momento posso transferir minhas pasta "src/Core" para qualquer outro framework que interprete PHP como CakePHP, Zend, Symphony e etc. Bastará apenas acoplar a camada de infraestrutura referente ao framework no "Core" do projeto.

**3 - Saída da requisição**

Após o processamento realizado na camada de regra de negócios, a resposta é encaminhada de volta a camada de aplicação, no caso de uso, que por sua vez, retorna a resposta ao controller. O controller utiliza-se da classe: "TokenValidatorResource" que atua como o recurso de apresentação do framework. Através desta classe o retorno é formatado e é enviado um JSON como resposta para a requisição.
## Critérios que o projeto visa aplicar

- **Testes de unidade/integração** ✅: Este projeto contém testes automatizados. (E2E, Integração e Unidade), para executar os testes basta entrar dentro do container, caso use Docker, e executar ./vendor/bin/phpunit na raiz do projeto. Caso rode local basta executar o mesmo comando citado anteriormente na raiz do projeto.

- **Abstração, acoplamento, extensibilidade e coesão** ✅: Através do uso das metodologias Clean Architecture e Domain Driven Design os critérios de ter abstração, baixo acoplamento, extensibilidade e alta coesão foram atingidos.

- **Design de API** ✅: A utilização dos recursos provisionados pelo Laravel como Middlewares, FormRequests, Controllers, Resources e aliados com as metodologias de design de software supracitadas garantiram uma API adequada aos padrões de mercados.

- **SOLID** ✅: No contexto do projeto foi possibilitada a utilização de um dos principios do SOLID (Single Responsabilty Principle) contido em praticamente todas as classes do projeto.

- **Documentação da solução no README** ✅: Presente neste arquivo.

- **Commits realizados durante a construção** ✅: O repositório no GitHub registra todo o histórico de commits.

- **Observability (Logging/Tracing/Monitoring)** ☑️: Parcialmente aplicado - A aplicação registra logs de entradas, exceções e saída. (/storage/logs)

- **Containerização da aplicação** ✅: O projeto fornece um Dockerfile e um docker-compose.yml com um Web Server Apache integrado que emula o ambiente de produção para a execução do projeto em ambiente de desenvolvimento.

- **Helm Chart em um cluster de Kubernetes/ECS/FARGATE** ❌: Não foi aplicado.

- **Repositório no GitHub.** ✅: Repositório disponível em "https://github.com/PedroMeira01/api-jwt-validator/"

- **Deploy Automatizado para Infra-Estrutura AWS** ✅: O projeto possui deploy automatizado para a instância EC2 onde se encontra hospedado. Todo novo commit na branch "master" inicia o deploy automático para produção.

- **Scripts CI/CD** ✅: Script disponível em "./github/workflow/deploy.yml", esse script realiza instações de dependências, executa os testes e caso todas as etapas sejam bem sucedidas, realiza o deploy automático.

- **Coleções do Insomnia ou ferramentas para execução** ✅: 

- **Provisione uma infraestrutura na AWS com OpenTerraform** ❌: Não foi aplicado.

- **Expor a api em algum provedor de cloud (aws, azure...)** ✅: O endpoint está disponível em http://3.137.174.158/api/v1/token-validation/jwt

- **Uso de Engenharia de Prompt** ❌: Não foi aplicado.
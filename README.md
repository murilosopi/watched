# Watched
Projeto de sistema para avaliação de séries e filmes, criação de comunidade e interação, proposto como Trabalho de Conclusão de Curso do curso técnico em Desenvolvimento de Sistemas na Etec de Carapicuíba.


## Requisitos:
- **PHP 8.0^** *(versão utilizada: 8.0.30)*
- **NodeJS** *(versão utilizada: 18.17.1)*
- **MariaDB**  *(versão utilizada: 10.6.12)*


## Setup do Projeto:
Para rodar o projeto em produção são necessários:

### Criação do banco de dados
Toda a estrutura necessária para rodar o projeto está contida no script <code>database.sql</code>

### Instalação das dependências:
```
npm install
```

### Execução em Desenvolvimento:
```
npm run serve
```

### API
No diretório raiz do projeto, execute:
```
php -S localhost:80 -t ./api/
```
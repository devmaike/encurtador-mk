# Encurtador MK (Encurta URL)

Esta ferramenta permite criar aliases curtos e fáceis de compartilhar para URLs longas. Além disso, ela oferece uma API para acesso.

## Recursos
Interface Intuitiva: Interface web amigável para criar e gerenciar URLs encurtadas.
Aliases Personalizados: Defina aliases personalizados para suas URLs encurtadas.
Data de Expiração: Configure uma data de expiração para controlar a validade das URLs.
Acesso à API: Acesso programático ao serviço de encurtamento de URL por meio de uma API simples.

## Instalação

Clone o repositório

```bash
git clone https://github.com/devmaike/encurtador-mk
```

## Instale as dependências

```bash
cd encurtador-mk
composer install
```

## Configure o ambiente

```bash
cp .env.example .env
```

## Execute as migrações

```bash
php artisan migrate
```

## Gere a chave da aplicação

```bash
php artisan key:generate
```

## Inicie a aplicação

```bash
php artisan serve
```

## Docs da API
Em /docs/api

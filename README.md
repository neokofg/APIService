# Это небольшой APIService.

## Установка компонентов
    composer install
    cp .env.example .env
## Запуск проекта:
Есть 2 варианта запуска проекта, через docker, и через php artisan serve

### Через docker:
    docker compose build
    docker compose up -d

### Через php artisan serve:
Вам нужна будет запущенная база данных mysql,
и в .env файле надо вставить перменные DB

    php artisan serve

### Миграция:
    php artisan migrate:fresh --seed

### Документация REST API:
Можно получить доступ по ссылке: http://{{Адрес}}/docs после ввода этой команды:

    php artisan scribe:generate --force

### GraphQL: 
Можно пользоваться через graphiql но надо будет все писать вручную:

        http://{{Адрес}}/graphiql

Я рекомендую через ApolloSandbox:

	    https://studio.apollographql.com/sandbox/explorer
Слева сверху надо вставить адрес

        http://{{Адрес}}/graphql

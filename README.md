## Installation

- Настройка окружения
    ```
    cp .env.example .env
    ```
- Установка зависимостей
    ```
    docker run --rm \
      -u "$(id -u):$(id -g)" \
      -v "$(pwd):/var/www/html" \
      -w /var/www/html \
      laravelsail/php81-composer:latest \
      composer install --ignore-platform-reqs
    ```
- Настройка alias
    ```
    alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
    ```
- Запукс Docker
    ```
    sail up
    ```
- Установка пакетов
    ```
    sail yarn install
    ```
- Установка магазина
    ```
    sail artisan shop:install
    ```

## Develop

- Запуск сборщика шаблона
    ```
    sail yarn run dev
    ```
- Обновление базы магазина
    ```
    sail artisan shop:refresh `Refresh project`
    ```
- Создание домена DDD
    ```
    sail artisan shop:domain `Make new domain`
    ```

## Deploy

- Билд шаблона
    ```
    sail yarn run build
    ```

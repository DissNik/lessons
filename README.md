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
- Установка проекта
    ```
    sail artisan shop:install
    ```

## Develop

- Запуск сборщика шаблона
    ```
    sail yarn run dev
    ```
- Обновление проекта
    ```
    sail artisan shop:refresh
    ```
- Создание домена DDD
    ```
    sail artisan shop:domain
    ```

## Deploy

- Билд шаблона
    ```
    sail yarn run build
    ```

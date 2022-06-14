# Развертывание проекта
`docker-compose -f docker-compose.yml -f docker-compose.override.yml up --build -d` (локально)

`docker-compose -f docker-compose.yml -f docker-compose.dev.yml up --build -d` (дев)

`docker-compose -f docker-compose.yml -f docker-compose.prod.yml up --build -d` (прод)

`docker-compose exec php bash`

`composer install`

`php bin/console doctrine:migrations:migrate`

`php bin/console app:create:user:admin`

`yarn install`

`yarn encore dev`

локальные доспуты 
- http://localhost:8780 - основной сайт
- http://localhost:8780/_profiler - профайлер
- http://localhost:8025 - mailhog
## Тесты (не реализованы)
Запускать тесты нужно командой в терминале контейнера
`vendor/bin/phpunit`

или - тогда подготовит отчет в html виде, доступный по адресу http://localhost:8080/report/index.html
`vendor/bin/phpunit --coverage-html public/report`
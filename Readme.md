# Развертывание проекта
`docker-compose up --build -d`

`docker-compose exec php bash`

`composer install`

`php bin/console doctrine:migrations:migrate`

`php bin/console create:user:admin`

`yarn install`

`yarn encore dev`

локальные доспуты 
- http://localhost:8780 - основной сайт
- http://localhost:8025 - mailhog
## Тесты
Запускать тесты нужно командой в терминале контейнера
`vendor/bin/phpunit`

или - тогда подготовит отчет в html виде, доступный по адресу http://localhost:8080/report/index.html
`vendor/bin/phpunit --coverage-html public/report`
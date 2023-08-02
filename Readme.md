### To start the project with test data you need to run these commands:

`composer install`

`docker-compose up -d`

`symfony server:start -d`

`symfony console doctrine:migration:migrate`

`symfony console doctrine:fixtures:load`

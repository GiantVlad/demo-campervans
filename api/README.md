docker-compose exec php bin/phpunit

docker-compose exec php bin/console doctrine:database:create --env=test

docker-compose exec php bin/console doctrine:migrations:migrate -n --env=test

docker-compose exec php ./vendor/bin/psalm

console doctrine:fixtures:load

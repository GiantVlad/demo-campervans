docker-compose exec php bin/phpunit

docker-compose exec php bin/console doctrine:database:create --env=test

console doctrine:migrations:migrate -n --env=test
<!--        <server name="DATABASE_URL" value="postgresql://api-platform:!ChangeMe!@database_test:5434/api_test?serverVersion=13" />-->

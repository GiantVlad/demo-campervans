DEMO Campervans API
=====
#### Based on the [API-Platform](https://api-platform.com) and Symfony

 - copy .env to .env.local

 - run docker-compose up -d to start docker containers

You'll need to add a security exception in your browser to accept the self-signed TLS certificate that has been generated for this container when installing the framework.

Go to https://localhost/docs/:

```
docker-compose exec php bin/phpunit

docker-compose exec php bin/console doctrine:database:create --env=test

docker-compose exec php bin/console doctrine:migrations:migrate -n --env=test

docker-compose exec php ./vendor/bin/psalm

docker-compose exec console doctrine:fixtures:load
```
{
"order": "orders/11",
"itemType": "item_types/15",
"dateFrom": "2022-09-18",
"dateTo": "2022-09-18",
"inStation": "stations/89",
"outStation": "stations/82"
}

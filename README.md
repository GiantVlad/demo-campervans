DEMO Campervans API
=====
#### Based on the [API-Platform](https://api-platform.com) and Symfony

 - copy api/.env to api/.env.local
 - copy api/phpunit.xml.dist to api/phpunit.xml
 - run docker-compose up -d to start docker containers


Go to https://localhost/docs/, you will see Swagger API.
You'll need to add a security exception in your browser to accept the self-signed TLS certificate that has been generated for this container when installing the framework.

There are two main endpoints to get Items availability and booked Items.
<img src="https://i.ibb.co/xq8pJ0k/Screenshot-from-2022-07-31-16-44-23.png" alt="Main Items availability API endpoints">

```bash
docker-compose exec php bin/phpunit

docker-compose exec php bin/console doctrine:database:create --env=test

docker-compose exec php bin/console doctrine:migrations:migrate -n --env=test

docker-compose exec php ./vendor/bin/psalm

docker-compose exec console doctrine:fixtures:load
```

An example of request body to create a new OrderItem: 
```json
{
    "order": "orders/11",
    "itemType": "item_types/15",
    "dateFrom": "2022-09-18",
    "dateTo": "2022-09-18",
    "outStation": "stations/82", 
    "inStation": "stations/89"
}
```

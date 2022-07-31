DEMO Campervans API
=====
#### Based on the [API-Platform](https://api-platform.com) and Symfony

 - copy api/.env to api/.env.local
 - copy api/phpunit.xml.dist to api/phpunit.xml
 - run docker-compose up -d to start docker containers

To populate the DB with fake data run:
```bash
docker-compose exec php bin/console hautelook:fixtures:load -n
```

Go to https://localhost/docs/, you will see Swagger API.
You'll need to add a security exception in your browser to accept the self-signed TLS certificate that has been generated for this container when installing the framework.

There are two main endpoints to get Items availability and booked Items.
<img src="https://i.ibb.co/xq8pJ0k/Screenshot-from-2022-07-31-16-44-23.png" alt="Main Items availability API endpoints">

Find ID of Munich station.
<img src="https://i.ibb.co/j8NX3zQ/Screenshot-from-2022-07-31-17-48-27.png" alt="Stations">

Then you can fetch amount available items per day in the date range by station_id.
<img src="https://i.ibb.co/4pJrYFx/Screenshot-from-2022-07-31-17-54-05.png" alt="Items availability">

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
Create DB for tests once:
```bash
docker-compose exec php bin/console doctrine:database:create --env=test

docker-compose exec php bin/console doctrine:migrations:migrate -n --env=test
```

Then you can run autotests:
```bash
docker-compose exec php bin/phpunit
```

It uses Psalm Level=3 as code quality checker:
```bash
docker-compose exec php ./vendor/bin/psalm
```
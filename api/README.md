docker-compose exec php bin/phpunit

docker-compose exec php bin/console doctrine:database:create --env=test

docker-compose exec php bin/console doctrine:migrations:migrate -n --env=test

docker-compose exec php ./vendor/bin/psalm

docker-compose exec console doctrine:fixtures:load

{
    "order": "orders/11",
    "itemType": "item_types/15",
    "dateFrom": "2022-09-18",
    "dateTo": "2022-09-18",
    "inStation": "stations/89",
    "outStation": "stations/82"
}

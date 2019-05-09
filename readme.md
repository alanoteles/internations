## Internations API Test

After cloning, supposing Docker and docker-compose are installed, you can :

1 - If needed, change the owner of the folder : ```chown -R www-data:www-data internations/```\
2 - ```cd internations```\
3 - Run composer :  ```docker run --rm -v $(pwd):/app composer install```\
4 - Run containers : ```docker-compose up -d```\
5 - Run migrations/seeds : ```docker exec -it phpfpm-internations php artisan migrate --seed```

The available endpoints are described on this [document](api/endpoints.md).

The database diagram can be viewed  [here](database_model.png).

The domain model can be viewed [here](api/domain_model.png).



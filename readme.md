## Internations API Test

After cloning, supposing Docker and docker-compose are instaled, you can :

1 - If needed, change the owner of the folder : ```chown -R www-data:www-data internations/```\
2 - Run composer :  ```docker run --rm -v $(pwd):/app composer install```\
3 - Run containers : ```docker-compose up -d```\
4 - Run migrations/seeds : ```docker exec -it phpfpm-internations php artisan migrate —seed```

The availble endpoints are described on this [document](endpoints.pdf).

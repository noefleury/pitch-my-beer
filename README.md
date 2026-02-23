# Pitch my beer!

TODO

## Running on your dev environment

```bash
# setup app through composer script
docker run -v ${PWD}/pitch-my-beer:/app composer:2.9.5 setup

# run migrations through php artisan
docker exec pitch-my-beer_web /var/www/html/artisan migrate

# run app
docker-compose up -d

# or to run in debug mode
docker-compose -f docker-compose.yml -f docker-compose.debug.yml up
```

## Run tests

```bash
docker exec pitch-my-beer_web /var/www/html/artisan test
```

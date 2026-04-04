# Pitch my beer!

---

⚠️ Work in progress 👨‍💻

---

![php](https://img.shields.io/badge/php-8.5-blue)
![laravel](https://img.shields.io/badge/laravel-13-blue)

[![codecov](https://codecov.io/gh/noefleury/pitch-my-beer/graph/badge.svg)](https://codecov.io/gh/noefleury/pitch-my-beer)

---

This project is a website which aim to track beer things 🍻

In brief :

- follow your batch productions
- follow beer consumptions
- check what's currently on tap

---

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

You can run seeders to populate the database with some demonstration data :

```bash
docker exec pitch-my-beer_web /var/www/html/artisan db:seed
```

## Run tests

```bash
docker exec pitch-my-beer_web /var/www/html/artisan test
```

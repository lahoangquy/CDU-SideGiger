## Docker setup

```
cp .env.example .env

docker-compose up -d

#linux
docker exec -it {app-name}-php bash

#window
winpty docker exec -it {app-name}-php bash
```

## Laravel install and build app

```
root@123456789abcde:/var/www/html#composer install
root@123456789abcde:/var/www/html#php artisan key:generate
root@123456789abcde:/var/www/html#php artisan migrate --seed
root@123456789abcde:/var/www/html#npm i
root@123456789abcde:/var/www/html#npm run dev
```

## make migration: 

```
root@123456789abcde:/var/www/html#php artisan migrate

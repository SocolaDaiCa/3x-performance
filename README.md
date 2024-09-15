```shell
cp .env.example .env
composer install
php artisan migrate --seed
#php artisan migrate:fresh --seed
php artisan serve
# go to http://localhost/3x-performance
```

open routes/web.php

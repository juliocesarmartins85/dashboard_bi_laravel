
### Passo a passo
Clone Repositório
```sh
git clone https://github.com/juliocesarmartins85/dashboard_bi_laravel.git
```

Clone os Arquivos do Laravel
```sh
git clone https://github.com/laravel/laravel.git app-laravel
```


Copie os arquivos docker-compose.yml, Dockerfile e o diretório docker/ para o seu projeto
```sh
cp -rf setup-docker-laravel/* app-laravel/
```
```sh
cd app-laravel/
```


Crie o Arquivo .env
```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env
```ini
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:6r0+SEauoUgPVxLUe88ix21EwuKHf/hrozoQYh7edsg=
APP_DEBUG=false
https://onobus.onotecnologia.com.br/

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

# PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
#DB_CONNECTION=pgsql
#DB_HOST=banco.satlight.com.br
#DB_PORT=5432
#DB_DATABASE=websites
#DB_USERNAME=websites
#DB_PASSWORD=E4P4Ii7jZ5S9qq
```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acessar o container
```sh
docker-compose exec app bash
```


Instalar as dependências do projeto
```sh
composer install
```

Limpar Conatiners
```sh
docker stop $(docker ps -aq)
docker rm $(docker ps -aq)
docker rmi $(docker images -q) --force
docker volume rm $(docker volume ls -q)
docker network prune -f
docker builder prune -a -f
```
Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Gerar Migration,Controllers e Models
```sh
php artisan make:model Api -mcrsf
php artisan make:model Driver -mcrsf
php artisan make:model DriverAssignments -mcrsf
php artisan make:model File -mcrsf
php artisan make:model Log -mcrsf
php artisan make:model Neighborhood -mcrsf
php artisan make:model Product -mcrsf
php artisan make:model Role -mcrsf
php artisan make:model Route -mcrsf
php artisan make:model RouteStreet -mcrsf
php artisan make:model SideBar -mcrsf
php artisan make:model Stop -mcrsf
php artisan make:model StopTimes -mcrsf
php artisan make:model Street -mcrsf
php artisan make:model Trip -mcrsf
php artisan make:model User -mcrsf
php artisan make:model Vehicle -mcrsf
```

Acessar o projeto
[http://192.168.0.253:8989](http://192.168.0.253:8989)

```sh



php artisan make:model User -mcrsf
php artisan make:seeder PermissionTableSeeder
php artisan db:seed --class=PermissionTableSeeder
php artisan make:seeder CreateAdminUserSeeder
php artisan db:seed --class=CreateAdminUserSeeder
php artisan make:controller PostHomeController --resource

php artisan db:wipe
php artisan migrate --seed
php artisan db:seed --class=CreateAdminUserSeeder


php artisan install:api
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
npm install bootstrap-icons --save-dev
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
```

resources\sass\app.scss
```php
/* Fonts */
@import url('https://fonts.bunny.net/css?family=Nunito');

/* Variables */
@import 'variables';

/* Bootstrap */
@import 'bootstrap/scss/bootstrap';
@import 'bootstrap-icons/font/bootstrap-icons.css';
```

routes/api.php
```php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
   
Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
         
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('products', ProductController::class);
});
```

bootstrap/app.php

```php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```
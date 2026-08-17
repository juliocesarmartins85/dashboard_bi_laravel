# Dashboard BI

Painel administrativo em Laravel 12 para gestão de produtos, sites/multi-tenant,
usuários, perfis (portal cativo por MAC address) e controle de acesso baseado em
roles/permissions. Inclui integração com a API de rastreamento veicular Moovsec,
notificações via Telegram e consulta de fabricante por MAC address.

| Item                | Valor                                                                  |
| ------------------- | ---------------------------------------------------------------------- |
| PHP                 | `^8.2` (imagem Docker: `php:8.2.9-fpm`)                                |
| Framework           | Laravel `^12.0`                                                        |
| Permissões          | `spatie/laravel-permission` `^6.20`                                    |
| Scaffolding de auth | `laravel/ui` `^4.6` (login/registro/recuperação de senha)              |
| API tokens          | `laravel/sanctum` `^4.1`                                               |
| Front-end           | Vite + Bootstrap 5 + Sass (Tailwind 4 instalado, não é o principal)    |
| Banco               | SQLite por padrão (`DB_CONNECTION=sqlite`, `database/database.sqlite`) |

---

## Instalação

```bash
cp .env.example .env
composer install
php artisan key:generate
npm install
```

Não há script `composer setup`. Depois do `key:generate`, rode as migrations
(seção [Banco de dados](#banco-de-dados)) e o build do front-end:

```bash
npm run build   # ou: npm run dev
```

---

## Ambiente de desenvolvimento

### Local

Sobe servidor, worker de fila, logs (`pail`) e Vite em paralelo:

```bash
composer dev
```

### Docker

O `docker-compose.yml` define: **app** (PHP-FPM, build do `Dockerfile`), **nginx**
(porta **8989**), **db** (MySQL 8.0, porta **3388**) e **redis**. O serviço
**phpmyadmin** existe no arquivo mas está comentado.

> A aplicação usa **SQLite por padrão** (`.env`: `DB_CONNECTION=sqlite`), mesmo
> rodando em Docker — o container `db` (MySQL) fica disponível mas não é a
> conexão ativa a menos que `DB_CONNECTION`/`DB_*` sejam trocados no `.env`.

```bash
docker-compose up -d
docker-compose exec app bash
```

Aplicação disponível em <http://localhost:8989>.

---

## Banco de dados

```bash
php artisan migrate --seed
```

Para recriar do zero:

```bash
php artisan db:wipe
php artisan migrate --seed
```

O `DatabaseSeeder` executa, nesta ordem: `PermissionSeeder`, `SideBarSeeder`,
`SiteSeeder` e `UserAdminSeeder`.

> ⚠️ Antes de rodar `migrate:fresh`/`db:wipe` num banco com dados reais,
> confira se as migrations em `database/migrations/` realmente batem com o
> schema atual — já houve caso de uma migration ser reescrita depois de já
> ter sido aplicada, o que a deixa fora de sincronia com bancos existentes
> sem gerar nenhum erro visível.

---

## Rotas principais

Recursos CRUD completos (`Route::resource`), todos atrás do middleware `auth`
e de permissões do `spatie/laravel-permission` (`{recurso}-listar|criar|editar|deletar`):

`logs`, `users`, `file`, `roles`, `sites`, `profileusers`, `products`

Rotas utilitárias: `config_user` / `update_user` (perfil do usuário logado),
`clear_cache`, além de `db` e `mcrsf` (ambas com o corpo comentado —
scaffolding de manutenção nunca finalizado).

API (Sanctum, `routes/api.php`): `POST /api/login` (público), `GET /api/user`
e `POST /api/logout` (ambas atrás de `auth:sanctum`).

---

## Testes

```bash
composer test
```

> A suíte hoje só contém os testes de exemplo gerados pelo skeleton do
> Laravel (`tests/Unit/ExampleTest.php`, `tests/Feature/ExampleTest.php`) —
> não há cobertura real das regras de negócio ainda.

---

## Histórico de scaffolding

Comandos usados para gerar os models do projeto. A flag `-mcrsf` cria, para cada model: **m**igration, **c**ontroller, **r**esource controller, **s**eeder e **f**actory.

<details>
<summary>Ver comandos</summary>

```bash
# Painel
php artisan make:model Model -mcrsf
```

</details>

Limpar cache

````sh
php artisan clear-compiled
composer dump-autoload
php artisan optimize

---

## Manutenção do Docker

Limpeza total de containers, imagens, volumes, redes e cache de build.
**Destrutivo — afeta todos os projetos Docker da máquina, não só este.**

```bash
docker stop $(docker ps -aq)
docker rm $(docker ps -aq)
docker rmi $(docker images -q) --force
docker volume rm $(docker volume ls -q)
docker network prune -f
docker builder prune -a -f
````

---

## Pendências conhecidas

- **`App\Models\Role` órfão.** Existe um model `App\Models\Role` sem migration
  própria e não usado em lugar nenhum do código — o app inteiro usa
  `Spatie\Permission\Models\Role`.
- **`/block_mac` sem controller.** A rota `Route::post('/block_mac', ...)`
  aponta para `HomeController::block_mac`, método que não existe — chamar essa
  rota resulta em erro.
- **`UserController::update_user()` ignora o `{id}` da rota.** A rota é
  `/update_user/{id}`, mas o método sempre atualiza `Auth::user()->id`,
  independente do parâmetro.
- **`ApiController::register()` sem rota.** O método existe e monta um
  cadastro completo com token Sanctum, mas `routes/api.php` não registra
  nenhuma rota apontando pra ele — hoje é inalcançável via HTTP.
- **Referência a `App\Models\Perguntas`** em `crud/index.blade.php` e
  `crud/show.blade.php` — model que não existe. Só quebraria se algum campo
  de listagem/detalhe guardasse um array JSON como texto, o que nenhum
  campo faz hoje.
- **Casos de formulário mortos.** Os blocos `radio`/`date`/`select`/
  `multipleselect`/`editor` em `crud/create.blade.php` e `crud/edit.blade.php`,
  e as views em `admin/components/routerboard/`, `configs.blade.php`,
  `dataTableHome.blade.php` e `log_page.blade.php` referenciam um recurso de
  gestão de roteadores/blacklist que não tem controller nem rota registrada.

---

## Segurança

> ⚠️ Este README chegou a conter uma chave de acesso hardcoded (removida
> nesta revisão). Se ela ainda estiver ativa em algum serviço, revogue/rotacione
> assim que possível — segredos não devem ficar versionados; use o `.env`.

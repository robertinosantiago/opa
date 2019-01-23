# Software OPA

## Requirements

- HTTP Server. For example: Apache. Having mod_rewrite is preferred, but by no means required.
- PHP 5.6.0 or greater (including PHP 7.2).
- PostgreSQL Server
- mbstring PHP extension
- intl PHP extension
- simplexml PHP extension
- pg-sql PHP extension

```bash
git clone https://github.com/robertinosantiago/opa.git
```

```bash
cd opa
```

```bash
composer install
```

Configure database in file: **config/app.php**
```php
//others values - before
'Datasources' => [
  'default' => [
    'driver' => 'Cake\Database\Driver\Postgres',
    'host' => 'your-server-postgres',
    'username' => 'your-user-postgres',
    'password' => 'your-password-postgres',
    'database' => 'your-database-postgres',
    //anothers values

  ],
//anothers values - after
```

```bash
bin/cake migrations migrate -p ADmad/SocialAuth
```

```bash
bin/cake migrations migrate
```
Copy config/.env.default to config/.env and customizing the values

```php
export FACEBOOK_APP_ID = ""
export FACEBOOK_APP_SECRET = ""
export GOOGLE_APP_ID = ""
export GOOGLE_APP_SECRET = ""
```

```bash
bin/cake server
```

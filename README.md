#基于数据的RBAC

适用于前后端分离项目的权限管理


树形菜单
角色管理
用户管理
API管理

### Install
Require this package with composer using the following command:

```bash
composer require lwj/laravel-rbac
```

After updating composer, add the service provider to the `providers` array in `config/app.php`

```php
Lwj\Rbac\ServiceProvider::class,
```
**Laravel 5.5** uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Config

You can also publish the config file to change implementations (ie. interface to specific class) or set defaults for `--helpers` or `--sublime`.

```bash
php artisan vendor:publish --provider="Lwj\Rbac\ServiceProvider" --tag=config
```

### Migration

You can also migrate tables and base data:

```bash
php artisan migrate
```

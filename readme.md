**Installation**

`composer require neuser/cmsify "dev-master"`

**Add ServiceProvider to config/app.php**

`Cmsify\CmsifyServiceProvider::class`

**Run Artisan Command**

```
php artisan vendor:publish neuser/cmsify
php artisan migrate
```

Make sure your are logged in or auth/login is working and than try:

`http://local.app/cmsify`

See config where you can change,for example, routing stuff like middleware and prefixing:
 
`config/cmsify.php`
 
**Package Updates**

If you just want to update the javascript code run 

´php artisan --force vendor:publish --tag=public´

instead of overwriting everythink like configuration file and the view template

´php artisan --force vendor:publish´
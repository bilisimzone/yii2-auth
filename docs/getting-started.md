# Getting started with yii2-auth

yii2-auth is designed to work out of the box. It means that installation requires
minimal steps. Only one configuration step should be taken and you are ready to
have user management on your Yii2 website.

> If you're using Yii2 advanced template, you should read [this article](usage-with-advanced-template.md) firstly.

### 1. Download

yii2-auth can be installed using composer. Run following command to download and
install yii2-auth:

```bash
composer require coreb2c/yii2-auth
```

### 2. Configure

> **NOTE:** Make sure that you don't have `user` component configuration in your config files.

Add following lines to your main configuration file:

```php
'modules' => [
    'user' => [
        'class' => 'coreb2c\auth\Module',
    ],
],
```

### 3. Update database schema

The last thing you need to do is updating your database schema by applying the
migrations. Make sure that you have properly configured `db` application component
and run the following command:

```bash
$ php yii migrate/up --migrationPath=@vendor/coreb2c/yii2-auth/migrations
```

## Where do I go now?

You have yii2-auth installed. Now you can check out the [list of articles](README.md)
for more information.

## Troubleshooting

If you're having troubles with yii2-auth, make sure to check out the 
[troubleshooting guide](troubleshooting.md).

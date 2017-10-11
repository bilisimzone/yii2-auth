# Overriding models

When you are creating application with yii2-auth you can find that you need to override models or forms. This guide
describes how you can override any model used by yii2-auth. Moreover you can attach any behavior or event handler to any
model. This is possible because yii2-auth uses [Dependency Injection container](https://github.com/yiisoft/yii2/blob/master/docs/guide/concept-di-container.md).

Assume you decided to override user class and change registration process. Let’s create new user class under `@app/models`.

```php
namespace app\models;

use coreb2c\auth\models\User as BaseUser;

class User extends BaseUser
{
    public function register()
    {
        // do your magic
    }
}
```

In order to make yii2-auth use your class you need to configure module as follows:

```php
...
'user' => [
    'class' => 'coreb2c\auth\Module',
    'modelMap' => [
        'User' => 'app\models\User',
    ],
],
...
```

## Attaching behaviors and event handlers

yii2-auth allows you to attach behavior or event handler to any model. To do this you can set model map like so:

```php
[
    ...
    'user' => [
        'class' => 'coreb2c\auth\Module',
        'modelMap' => [
            'User' => [
                'class' => 'app\models\User',
                'on user_create_init' => function () {
                    // do you magic
                },
                'as foo' => [
                    'class' => 'Foo',
                ],
            ],
        ],
    ],
    ...
]
```

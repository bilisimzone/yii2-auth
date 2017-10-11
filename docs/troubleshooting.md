# Troubleshooting

This page provides a list of common problems and the ways of solving them.

### After logging in I'm redirected back without any sign of being logged in

You probably haven't removed `user` from component section of your application.

If you need to have custom `user` component, then you should configure it to use
yii2-auth identity class:

```php
'user' => [
    'class' => 'app\components\User',
    'identityClass' => 'coreb2c\auth\models\User',
],
```

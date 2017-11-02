# List of available actions

yii2-auth includes a lot of actions, which you can access by creating URLs for them. Here is the table of available
actions which contains route and short description of each action. You can create URLs for them using special Yii
helper `\yii\helpers\Url::to()`.

- **/auth/registration/register** Displays registration form
- **/auth/registration/resend**   Displays resend form
- **/auth/registration/confirm**  Confirms a user (requires *id* and *token* query params)
- **/auth/login/login**        Displays login form
- **/auth/logout/logout**       Logs the user out (available only via POST method)
- **/auth/recovery/request**      Displays recovery request form
- **/auth/recovery/reset**        Displays password reset form (requires *id* and *token* query params)
- **/auth/settings/profile**      Displays profile settings form
- **/auth/settings/account**      Displays account settings form (email, username, password)
- **/auth/settings/networks**     Displays social network accounts settings page
- **/auth/profile/show**          Displays user's profile (requires *id* query param)
- **/auth/admin/index**           Displays user management interface

## Example of menu

You can add links to registration, login and logout as follows:

```php
Yii::$app->user->isGuest ?
    ['label' => 'Sign in', 'url' => ['/auth/security/login']] :
    ['label' => 'Sign out (' . Yii::$app->user->identity->username . ')',
        'url' => ['/auth/security/logout'],
        'linkOptions' => ['data-method' => 'post']],
['label' => 'Register', 'url' => ['/auth/registration/register'], 'visible' => Yii::$app->user->isGuest]
```

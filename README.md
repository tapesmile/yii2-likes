Like module for Yii2
====================
Модуль лайков с использованием Redis, для АВТОРИЗИРОВАННЫХ пользователей

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tapesmile/yii2-likes "*"
```

or add

```
"tapesmile/yii2-likes": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Для работы модуля необходимо установить [redis server](https://redis.io/).

Чтобы получить доступ к модулю, вам необходимо добавить следующий код в конфигурацию вашего приложения:
```php
'modules' => [
     'likes' => [
         'class' => 'tapesmile\likes\Module',
    ],
],
```
А также необходимо сконфигурировать установленный redis-server
```php
    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
],
```
После вышеуказанных настроек просто вставьте этот код в вашем view:
```php
<?= \tapesmile\likes\widget\Likes::widget(['model' => $model]); ?>
```
Где ```'model'```=>```$model``` которую хотите "лайкнуть".

Также, вы можете переопределить стандартный view модуля, передав в виджет параметр view
```php
<?= \tapesmile\likes\Like::widget([
	'model' => '$model',
	'view' => '@alias/path/to/you/view'
		]); ?>
```
>**NOTE:** Учтите, что для корректной работы Вашего view, необходимо использование методов класса \tapesmile\likes\models\RedisModel, а также иннициализаци javascript переменных  ```var likeUri``` и ```var unlikeUri```  для корректной работы роутов.

Label button можно изменить, передав в виджет следующие параметры:
```php
<?= \tapesmile\likes\Like::widget([
	'model' => '$model',
    	'label' => [
        	'like' => 'Like',
        	'unlike' => 'Unlike'
	]); ?>
```
Если вы хотите изменить route, то просто добавьте следующий код в секцию rules в вашем UrlManager:
```php
	//UrlManager
            'rules' => [
		//Another rules
                'likeRequest' => 'likes/likes/like',
                'unlikeRequest' => 'likes/likes/unlike'
		//Another rules
            ],
	//UrlManager
```

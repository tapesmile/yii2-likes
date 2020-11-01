Like module for Yii2
====================

Likes module using Redis, for AUTHORIZED users

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

Before using,  need to instal [redis server](https://redis.io/).

To access the module, you need to add the following code to your application configuration:
```php
'modules' => [
     'likes' => [
         'class' => 'tapesmile\likes\Module',
    ],
],
```
Also, you need to configure the installed redis server
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
After settings, add the following code to your view
```php
<?= \tapesmile\likes\widget\Likes::widget(['model' => $model]); ?>
```
When ```'model'```=>```$model``` Model, you want to "like"

Change label button:
```php
<?= \tapesmile\likes\widget\Likes::widget([
	'model' => '$model',
    	'label' => [
        	'like' => 'Like',
        	'unlike' => 'Unlike'
	]); ?>
```
If you want to change the route, just add the following code to the rule section in your UrlManager:
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

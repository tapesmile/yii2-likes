<?php

namespace tapesmile\likes;

/**
 * Class Module
 *
 * @package tapesmile\likes
 */
class Module extends \yii\base\Module
{
    /**
     * @var string the class name of the redis model object
     */
    public $redisModelClass = 'tapesmile\likes\models\RedisModel';
    
    /**
     * @var string the namespace that controller classes are in
     */
    public $controllerNamespace = 'tapesmile\likes\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
    
}

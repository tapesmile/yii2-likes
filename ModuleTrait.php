<?php

namespace tapesmile\likes;

use Yii;

/**
 * Class ModuleTrait
 *
 * @package tapesmile\likes
 */
trait ModuleTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('likes');
    }
}

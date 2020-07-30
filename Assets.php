<?php

namespace tapesmile\likes;

use yii\web\AssetBundle;

/**
 * Class Assets
 *
 * @package tapesmile\likes
 */
class Assets extends AssetBundle
{
    
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/tapesmile/yii2-likes/assets';
    
    /**
     * @inheritdoc
     */
    public $css = [
        'css/font-awesome.css',
    ];
    
    /**
     * @inheritdoc
     */
    public $js = [
        'js/likes.js',
    ];
    
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];
}

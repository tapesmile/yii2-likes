<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model \tapesmile\likes\models\RedisModel */
?>
<div class="likes">
        <i class="fa fa-lg fa-heart-o"></i>
        <span class="likes-count"><?= $model->countLike(); ?></span>
        &nbsp;&nbsp;&nbsp;
        <a class="btn btn-default button-unlike" style="<?= ($model->isLiked($model->getId())) ? "" : "display:none"; ?>" data-id="<?= $model->getId(); ?>">
            <?= Html::encode($label['unlike']); ?>&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
        </a>
        <a class="btn btn-default button-like" style="<?= ($model->isLiked($model->getId())) ? "display:none" : ""; ?>" data-id="<?= $model->getId(); ?>">
            <?= Html::encode($label['like']); ?>&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
        </a>
</div>
<?php

 /* set javascript variable for change route in yii\web\UrlManager */
$likeUri = 'var likeUri = "' . Url::toRoute(['/likes/likes/like']) . '";'; 
$unlikeUri = 'var unlikeUri = "' . Url::toRoute(['/likes/likes/unlike']) . '";'; 

$this->registerJs($likeUri, \yii\web\View::POS_HEAD);
$this->registerJs($unlikeUri, \yii\web\View::POS_HEAD);

<?php

namespace tapesmile\likes\widget;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use tapesmile\likes\Assets;
use tapesmile\likes\ModuleTrait;

/**
 * Class Comment
 *
 * @package tapesmile\likes\widget
 */
class Likes extends Widget
{
    use ModuleTrait;
    
    /**
     * @var \yii\db\ActiveRecord Widget model
     */
    public $model;
    
    /**
     * @var string the view file that will render the likes form
     */
    public $view = '@vendor/tapesmile/yii2-likes/widget/views/index';
    
    /**
     * @var array buttons label
     */
    public $label = [
        'like' => 'Нравится',
        'unlike' => 'Не нравится'
    ];
    
    /**
     * @var string namespace $this->model entity
     */
    protected $entityId;
    
    /**
     * @var string encrypt namespace $this->model entity
     */
    protected $encryptEntity;
    
    /**
     * Initializes the widget params.
     */
    public function init()
    {
        parent::init();
        
        if (!isset(Yii::$app->components['redis'])){
            throw new InvalidConfigException("Component 'yii2-redis' must be set on app config");
        }
        
        if (empty($this->model)) {
            throw new InvalidConfigException('The "model" property must be set.');
        }
        
        $this->entityId = get_class($this->model);
        $this->encryptEntity = $this->getEncryptedEntity();
        $this->setEntityInSession();
        $this->registerAssets();
    }
    
    /**
        * Executes the widget. 
        *
        * @return string the result of widget execution to be outputted
        */
    public function run(): string
    {
        $redisClass = $this->getModule()->redisModelClass;
        $redisModel = Yii::createObject([
            'class' => $redisClass,
            ],[$this->model, Yii::$app->user->identity]);
        
        return $this->render($this->view, [
            'model' => $redisModel,
            'label' => $this->label
        ]);
    }
    
    /**
     * Register assets.
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        Assets::register($view);
    }
    
    /**
     * Get encrypted entity
     *
     * @return string
     */
    protected function getEncryptedEntity()
    {
        return utf8_encode(Yii::$app->getSecurity()->encryptByKey($this->entityId, $this->getModule()->id));
    }
    
    /**
     * Adds in session namespace encrypt entity
     */
    protected function setEntityInSession()
    {
        return Yii::$app->session->set('entity', $this->encryptEntity);
    }
}

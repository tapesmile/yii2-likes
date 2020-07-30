<?php

namespace tapesmile\likes\models;

use Yii;
use yii\helpers\StringHelper;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * Class RedisModel
 * 
 * @package tapesmile\likes
 */
class RedisModel
{
    /**
     * @var \yii\db\ActiveRecord user model 
     */
    protected $userModel;
    
    /**
     * @var \yii\web\IdentityInterface current user model 
     */
    protected $currentUser;
    
    /**
     * @param ActiveRecord $userModel
     * @param IdentityInterface $user
     */
    public function __construct(ActiveRecord $userModel, IdentityInterface $user)
    {
        $this->userModel = $userModel;
        $this->currentUser = $user;
    }
    
    /**
     * Returns id attribute if exist
     * 
     * @return int
     * @throws \yii\base\Exception
     */
    public function getId()
    {
        if (!isset($this->userModel->id)) {
            throw new \yii\base\Exception("Model '". get_class($this->userModel) ."' must have attribute 'id'");
        }
        return $this->userModel->id;
    }
    
    /**
     * Like user model
     */
    public function like()
    {
        $redis = Yii::$app->redis;
        
        $redis->sadd("{$this->getClassName()}:{$this->getId()}:likes", $this->getCurrentUser()->getId());
        $redis->sadd("user:{$this->getCurrentUser()->getId()}:likes", $this->getId());
    }
    
    /**
     * Unlike user model
     */
    public function unlike()
    {
        $redis = Yii::$app->redis;
        
        $redis->srem("{$this->getClassName()}:{$this->getId()}:likes", $this->getCurrentUser()->getId());
        $redis->srem("user:{$this->getCurrentUser()->getId()}:likes", $this->getId());
    }
    
    /**
     * Checks by which user of the link is the entry
     * 
     * @param int $id
     * @return bool
     */
    public function isLiked(int $id)
    {
        $redis = Yii::$app->redis;
        return (bool) $redis->sismember("user:{$this->getCurrentUser()->getId()}:likes", $id);
    }
    
    /**
     * counts the number of likes
     * 
     * @return int
     */
    public function countLike()
    {
        $redis = Yii::$app->redis;
        return $redis->scard("{$this->getClassName()}:{$this->getId()}:likes");
 
    }
    
    /**
     * Return class name user model
     * 
     * @return string
     */
    protected function getClassName()
    {
        return strtolower(StringHelper::basename(get_class($this->userModel)));
    }
    
    /**
     * @return object
     */
    protected function getCurrentUser()
    {
        return $this->currentUser;
    }
}

<?php

namespace tapesmile\likes\controllers;

use Yii;
use yii\web\Controller;
use tapesmile\likes\ModuleTrait;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Class LikesController
 * 
 * @package tapesmile\likes\controllers
 */
class LikesController extends Controller
{
    use ModuleTrait;
    
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'like' => ['post'],
                    'unlike' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * Add like for record
     * 
     * @return array
     */
    public function actionLike()
    {
        $userModel = $this->findModel(Yii::$app->request->post('id'));
        $model = Yii::createObject(['class' => $this->getModule()->redisModelClass], [$userModel, Yii::$app->user->identity]);
        $model->like();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'likesCount' => $model->countLike(),
        ];
    }
    
    /**
     * Add unlike for record
     * 
     * @return array
     */
    public function actionUnlike()
    {
        $userModel = $this->findModel(Yii::$app->request->post('id'));
        $model = Yii::createObject(['class' => $this->getModule()->redisModelClass], [$userModel, Yii::$app->user->identity]);
        $model->unLike();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'likesCount' => $model->countLike(),
        ];
    }
    
    /**
     * Decrypt namespace entity
     * 
     * @return string
     */
    protected function getDecryptEntity()
    {
        return Yii::$app->getSecurity()->decryptByKey(utf8_decode($this->getEntity()), $this->getModule()->id);
    }
    
    /**
     * @return string
     */
    protected function getEntity()
    {
        return Yii::$app->session->get('entity');
    }
    
    /**
     * Find user model by entity id
     * 
     * @return object 
     * @throws \yii\web\NotFoundHttpException
     */  
    protected function findModel($id)
    {
        $entity = $this->getDecryptEntity();
        $model = $entity::findOne($id);
        
        if ($model != null) {
            return $model;
        }
        
        throw new \yii\web\NotFoundHttpException();
    }
}

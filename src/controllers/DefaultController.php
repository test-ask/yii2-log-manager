<?php

namespace testAsk\logManager\controllers;

use testAsk\logManager\models\search\StorageSearch;
use testAsk\logManager\models\UserCategoryModel;
use Yii;
use yii\web\Controller;

/**
 * Class LogController
 * @package app\modules\event\controllers
 */
class DefaultController extends Controller
{
    public $indexView = '@vendor/test-ask/yii2-log-manager/src/views/log/index';
    public $searchClass = StorageSearch::class;

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $searchModel = $this->getSearchModel();
        $searchModel->load(Yii::$app->request->queryParams);

        $params = [];
        if ($searchModel->validate()) {
            $params = $searchModel->attributes;
        }

        $categories = $this->getUserCategories();

        $storage = \Yii::$app->logger->getDispatcher()->getStorage();
        $dataProvider = $storage->getMessageList($categories, $params);

        return $this->render($this->indexView, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'userSearch' => \Yii::$container->get('userSearchModel')
        ]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionResolve(int $id)
    {
        $storage = \Yii::$app->logger->getDispatcher()->getStorage();
        $userId = $this->getUserIdentity()->getId();
        if ($storage->resolve($id, $userId)) {
            return $this->redirect(['index']);
        }
    }

    /**
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    protected function getSearchModel()
    {
        return \Yii::createObject([
            'class' => $this->searchClass,
        ]);
    }

    /**
     * @return object
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    protected function getUserIdentity()
    {
        $userIdentity = \Yii::$container->get('userIdentity');
        if (!is_callable([$userIdentity, 'getId'])) {
            throw new \Exception('userIdentity must have getId public method');
        }
        return $userIdentity;
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    protected function getUserCategories()
    {
        $userId = $this->getUserIdentity()->getId();
        return UserCategoryModel::getCategoriesByUserId($userId);
    }
}

<?php

namespace testAsk\logManager\controllers;

use testAsk\logManager\models\form\TargetForm;
use testAsk\logManager\models\form\UserCategoryForm;
use testAsk\logManager\models\search\TargetSettingsSearch;
use testAsk\logManager\models\search\UserSearch;
use testAsk\logManager\models\search\UserSearchInterface;
use testAsk\logManager\models\TargetCategoriesModel;
use testAsk\logManager\models\TargetSettingsModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class EventController
 * @package app\modules\event\controllers
 */
class SettingsController extends Controller
{
    public $userCategoriesView = '@vendor/test-ask/yii2-log-manager/src/views/settings/user-categories';
    public $targetSettingsView = '@vendor/test-ask/yii2-log-manager/src/views/settings/targets';
    public $targetCreateView = '@vendor/test-ask/yii2-log-manager/src/views/settings/target-create';

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionUserCategories()
    {
        $searchModel = $this->getUserSearchModel();
        $dataProvider = $searchModel->getUserList(Yii::$app->request->queryParams);

        return $this->render($this->userCategoriesView, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => \Yii::$app->logger->categories,
        ]);
    }

    /**
     * @return array
     */
    public function actionUserCategoriesUpdate()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $userCategoryForm = new UserCategoryForm();
        if ($userCategoryForm->load(Yii::$app->request->post(), '') && $userCategoryForm->saveCategories()) {
            return ['status' => 'ok'];
        }

        return ['status' => 'error', 'errors' => $userCategoryForm->getErrors()];
    }

    /**
     * @return UserSearch
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    protected function getUserSearchModel(): UserSearchInterface
    {
        return \Yii::$container->get('userSearchModel');
    }

    public function actionTargets()
    {
        $targets = \Yii::$app->logger->getDispatcher()->targets;
        $targetClasses = array_column($targets, 'class');

        $searchModel = new TargetSettingsSearch();
        $settings = $searchModel->getTargetSettings($targetClasses)->getModels();

        $settings = ArrayHelper::index($settings, null, 'class');

        $result = [];
        foreach ($targetClasses as $targetClass) {
            $result[$targetClass] = $settings[$targetClass] ?? [];
        }

        return $this->render($this->targetSettingsView, [
            'targetSettings' => $result,
        ]);
    }

    public function actionTargetCreate(string $class)
    {
        $model = new TargetForm();
        $model->setEntity(new TargetSettingsModel());
        $model->class = $class;

        $target = '';
        foreach (\Yii::$app->logger->getDispatcher()->targets as $conf) {
            if ($class == $conf['class']) {
                $target = $conf;
                break;
            }
        }

        $model->params = $target['params'] ?? [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['settings/targets']);
        }

        return $this->render($this->targetCreateView, [
            'model' => $model,
            'categories' => \Yii::$app->logger->categories,
        ]);
    }

    public function actionTargetUpdate(int $id)
    {
        $item = TargetSettingsModel::findOne($id);
        $model = new TargetForm();
        $model->setEntity($item);
        $model->categories = TargetCategoriesModel::getCategories($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['settings/targets']);
        }

        return $this->render($this->targetCreateView, [
            'model' => $model,
            'categories' => \Yii::$app->logger->categories,
        ]);
    }

}

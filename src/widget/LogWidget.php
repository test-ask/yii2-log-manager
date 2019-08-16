<?php

namespace testAsk\logManager\widget;

use testAsk\logManager\models\UserCategoryModel;
use yii\base\Widget;

/**
 * Class LogWidget
 * @package app\widgets\emojiarea
 */
class LogWidget extends Widget
{
    public $limit = 5;

    /**
     * @return string
     * @throws \Exception
     */
    public function run()
    {
        $categories = $this->getUserCategories();
        $storage = \Yii::$app->logger->getDispatcher()->getStorage();
        $dataProvider = $storage->getMessageList($categories, ['is_resolved' => 0, 'limit' => $this->limit]);
        return $this->render('_log', [
            'logs' => $dataProvider->getModels()
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
     * @throws \Exception
     */
    protected function getUserCategories()
    {
        $userId = $this->getUserIdentity()->getId();
        return UserCategoryModel::getCategoriesByUserId($userId);
    }
}

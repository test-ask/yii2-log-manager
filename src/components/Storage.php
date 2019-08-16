<?php

namespace testAsk\logManager\components;

use yii\base\Component;
use yii\data\BaseDataProvider;

abstract class Storage extends Component
{
    abstract public function save($message, $level, $category);

    abstract public function getMessageList(array $categories, $params): BaseDataProvider;

    abstract public function resolve($logId, $userId);
}

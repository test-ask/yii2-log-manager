<?php

namespace testAsk\logManager\models\search;

use yii\data\BaseDataProvider;

interface UserSearchInterface
{
    /**
     * @param array $params
     * @return BaseDataProvider
     */
    public function getUserList(array $params): BaseDataProvider;

    /**
     * @param int $id
     * @return mixed
     */
    public function getUserById(int $id): array;
}

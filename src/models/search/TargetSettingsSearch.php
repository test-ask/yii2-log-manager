<?php

namespace testAsk\logManager\models\search;


use testAsk\logManager\models\TargetSettingsModel;
use yii\data\SqlDataProvider;

/**
 * Class EventMessagesSearch
 * @package app\modules\event\models\search
 */
class TargetSettingsSearch extends TargetSettingsModel
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['class'], 'string']
        ];
    }

    public function getTargetSettings(array $targetClass)
    {
        $query = self::find()
            ->where([
                'class' => $targetClass
            ])
            ->orderBy('class ASC');

        return new SqlDataProvider([
            'sql' => $query->createCommand()->getRawSql(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);
    }
}

<?php

namespace testAsk\logManager\models;

use yii\db\ActiveRecord;

/**
 * Class EventTargetModel
 * @package app\modules\event\models
 */
class TargetSettingsModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%ms_target_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['class', 'name'], 'required'],
            [['name', 'class'], 'string', 'max' => 255],
            [['enabled'], 'integer'],
            [['params'], 'string'],
        ];
    }

    public static function getEnabledTargetSettings($class, $categories)
    {
        return self::find()
            ->alias('t')
            ->where([
                't.enabled' => 1,
                't.class' => $class,
            ])
            ->andFilterWhere([
                'c.category' => $categories
            ])
            ->leftJoin(['c' => TargetCategoriesModel::tableName()], 'c.target_id = t.id')
            ->all();
    }
}

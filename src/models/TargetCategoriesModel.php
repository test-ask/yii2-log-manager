<?php

namespace testAsk\logManager\models;

use yii\db\ActiveRecord;

/**
 * Class EventTargetModel
 * @package app\modules\event\models
 */
class TargetCategoriesModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%ms_target_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['target_id', 'category'], 'required'],
            [['category'], 'string', 'max' => 255],
            [['target_id'], 'integer'],
        ];
    }

    public static function getCategories($targetId)
    {
        return self::find()
            ->select('category')
            ->where([
                'target_id' => $targetId
            ])
            ->asArray()
            ->column();
    }
}

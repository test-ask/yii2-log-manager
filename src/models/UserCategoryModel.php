<?php

namespace testAsk\logManager\models;

use yii\db\ActiveRecord;

class UserCategoryModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%ms_user_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['category', 'user_id'], 'required'],
            [['user_id'], 'string', 'max' => 64],
            [['category'], 'string', 'max' => 100],
        ];
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function getCategoriesByUserId(int $userId)
    {
        return self::find()
            ->select(['category'])->where(['user_id' => $userId])->asArray()->column();
    }
}

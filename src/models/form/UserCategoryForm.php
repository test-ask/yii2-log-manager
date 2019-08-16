<?php

namespace testAsk\logManager\models\form;

use app\modules\user\models\User;
use testAsk\logManager\models\UserCategoryModel;

/**
 * Class AccountForm
 *
 * @property User $entity
 * @package app\modules\user\models\form
 */
class UserCategoryForm extends UserCategoryModel
{
    public $userId;
    public $categories;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['userId', 'required'],
            ['categories', 'each', 'rule' => ['string']],
        ];
    }

    /**
     * @return bool
     */
    public function saveCategories(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        UserCategoryModel::deleteAll([
            'user_id' => $this->userId
        ]);

        if ($this->categories) {
            foreach ($this->categories as $category) {
                (new UserCategoryModel([
                    'user_id' => $this->userId,
                    'category' => $category,
                ]))->save();
            }
        }

        return true;
    }
}

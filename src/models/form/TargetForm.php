<?php

namespace testAsk\logManager\models\form;

use app\models\form\BaseFormModel;
use app\modules\user\models\User;
use testAsk\logManager\models\TargetCategoriesModel;
use yii\db\ActiveRecord;

/**
 * Class AccountForm
 *
 * @property User $entity
 * @package app\modules\user\models\form
 */
class TargetForm extends BaseFormModel
{
    public $name;
    public $class;
    public $categories;
    public $enabled;
    public $params;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['class', 'name'], 'required'],
            [['name', 'class'], 'string', 'max' => 255],
            [['enabled'], 'integer'],
            [['categories', 'params'], 'each', 'rule' => ['string']],
        ];
    }

    /**
     * @param ActiveRecord $entity
     */
    public function setEntity(ActiveRecord $entity)
    {
        $this->entity = $entity;
        $attributes = $entity->getAttributes();
        $attributes['params'] = json_decode($attributes['params'], true);
        $this->setAttributes($attributes);
    }

    /**
     * @return bool|mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $attributes = $this->getAttributes();
        $attributes['params'] = json_encode($attributes['params']);
        $this->entity->setAttributes($attributes);

        if (!$this->entity->save()) {
            $this->addErrors($this->entity->getErrors());
            return false;
        }

        if ($attributes['categories']) {
            TargetCategoriesModel::deleteAll([
                'target_id' => $this->entity->id
            ]);
            foreach ($attributes['categories'] as $category) {
                $targetCategory = new TargetCategoriesModel();
                $targetCategory->category = $category;
                $targetCategory->target_id = $this->entity->id;
                $targetCategory->save();
            }
        }

        return true;
    }
}

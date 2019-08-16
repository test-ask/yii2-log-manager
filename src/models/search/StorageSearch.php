<?php

namespace testAsk\logManager\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * Class EventMessagesSearch
 * @package app\modules\event\models\search
 */
class StorageSearch extends Model
{
    public $level;
    public $created_at;
    public $updated_at;
    public $message;
    public $count;
    public $is_resolved;
    public $resolve_user_id;
    public $resolve_date;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['level', 'is_resolved', 'count'], 'integer'],
            [['created_at', 'updated_at', 'message', 'resolve_date', 'resolve_user_id'], 'string'],
        ];
    }
}

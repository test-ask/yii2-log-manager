<?php

namespace testAsk\logManager\models\search;

use yii\base\Model;
use yii\data\BaseDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Query;

class UserSearch extends Model implements UserSearchInterface
{
    public $tableName;
    public $userId;
    public $userName;

    public $id;
    public $name;

    public function rules()
    {
        return [
            ['id', 'integer'],
            ['name', 'string'],
        ];
    }

    /**
     * @param array $params
     * @return BaseDataProvider
     */
    public function getUserList(array $params): BaseDataProvider
    {
        $query = (new Query())
            ->select([
                'id' => $this->userId,
                'name' => $this->userName
            ])
            ->from($this->tableName);

        if ($this->validate()) {
            $this->load($params);

            $query->andFilterWhere([
                $this->userId => $this->id,
                $this->userName => $this->name,
            ]);
        }

        return new SqlDataProvider([
            'sql' => $query->createCommand()->getRawSql(),
            'totalCount' => $query->count(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    public function getUserById(int $id): array
    {
        $db = \Yii::$app->db;
        $tableName = $db->quoteTableName($this->tableName);
        $sql = 'SELECT ' . $this->userName . ' name 
        FROM ' . $tableName . ' WHERE ' . $this->userId . ' = :id';
        return \Yii::$app->db->createCommand($sql)
            ->bindValues([
                ':id' => $id
            ])->queryOne();
    }
}

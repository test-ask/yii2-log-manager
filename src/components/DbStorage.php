<?php

namespace testAsk\logManager\components;

use yii\data\BaseDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;

/**
 * Class EventDbTarget
 * @package app\modules\event\components\targets
 */
class DbStorage extends Storage
{
    public $db;
    public $table;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::class);
    }

    /**
     * @return Connection
     */
    public function getDb(): Connection
    {
        return $this->db;
    }

    /**
     * @param $message
     * @param $level
     * @param $category
     */
    public function save($message, $level, $category)
    {
        $tableName = $this->db->quoteTableName($this->table);

        $sql = "INSERT INTO $tableName ([[level]], [[category]], [[created_at]], [[updated_at]], [[unique_key]], [[message]], [[count]], [[is_resolved]])
                VALUES (:level, :category, :created_at, :updated_at, :unique_key, :message, :count, :is_resolved) 
                ON DUPLICATE KEY UPDATE count = count + 1, updated_at = :updated_at, is_resolved = :is_resolved";
        $command = $this->db->createCommand($sql);

        $dateTime = date('Y-m-d H:i:s');
        $command->bindValues([
            ':level' => $level,
            ':category' => $category,
            ':created_at' => $dateTime,
            ':updated_at' => $dateTime,
            ':unique_key' => $this->getUniqueKey($message, $level, $category),
            ':message' => $message,
            ':count' => 1,
            ':is_resolved' => 0,
        ])->execute();
    }

    public function getMessageList(array $categories, $params): BaseDataProvider
    {
        $query = (new Query())
            ->from($this->table)
        ->where([
            'category' => $categories
        ]);

        $query->andFilterWhere([
            'level' => $params['level'],
            'created_at' => $params['created_at'],
            'updated_at'=> $params['updated_at'],
            'message' => $params['message'],
            'count' => $params['count'],
            'is_resolved' => $params['is_resolved'],
            'resolve_user_id' => $params['resolve_user_id'],
            'resolve_date' => $params['resolve_date'],
        ])
        ->orderBy('is_resolved ASC, id DESC');

        return new SqlDataProvider([
            'sql' => $query->createCommand()->getRawSql(),
            'totalCount' => $query->count(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    /**
     * @param $message
     * @param $level
     * @param $category
     * @return string
     */
    protected function getUniqueKey($message, $level, $category)
    {
        return md5($message . $level . $category);
    }

    /**
     * @param $logId
     * @param $userId
     * @return mixed
     */
    public function resolve($logId, $userId)
    {
        $tableName = $this->db->quoteTableName($this->table);

        $sql = "UPDATE $tableName SET is_resolved = 1, resolve_user_id = :resolve_user_id, resolve_date = :resolve_date 
                WHERE id = :id";

        return $this->db->createCommand($sql)
            ->bindValues([
            ':resolve_user_id' => $userId,
            ':resolve_date' => date('Y-m-d H:i:s'),
            ':id' => $logId,
        ])->execute();
    }
}

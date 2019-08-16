<?php

use yii\db\Migration;
use testAsk\logManager\components\DbStorage;

class m190724_185632_storage_init extends Migration
{
    protected function getDbStorage()
    {
        $log = Yii::$app->logger;

        $storage = $log->getDispatcher()->getStorage();

        if ($storage instanceof DbStorage) {
            return [
                'db' => $storage->getDb(),
                'table' => $storage->table,
            ];
        }

        return true;
    }

    public function up()
    {
        $storage = $this->getDbStorage();
        $this->db = $storage['db'];

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($storage['table'], [
            'id' => $this->bigPrimaryKey(),
            'level' => $this->integer(),
            'category' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'unique_key' => $this->char(32),
            'message' => $this->text(),
            'count' => $this->integer(),
            'is_resolved' => $this->tinyInteger(),
            'resolve_user_id' => $this->char(64),
            'resolve_date' => $this->dateTime(),
        ], $tableOptions);

        $this->createIndex('idx_log_level', $storage['table'], 'level');
        $this->createIndex('idx_log_category', $storage['table'], 'category');
        $this->createIndex('idx_unique_key', $storage['table'], 'unique_key', true);
    }

    public function down()
    {
        $storage = $this->getDbStorage();
        $this->db = $storage['db'];

        $this->dropTable($storage['table']);
        return true;
    }
}

<?php

use ys\migration\db\Migration;

class m190726_163410_target_categories_init extends Migration
{
    public function up()
    {
        $this->db->createCommand('
         CREATE TABLE IF NOT EXISTS `ms_target_categories` (
            `target_id` int NOT NULL,
            `category` varchar(255) not null,
            PRIMARY KEY (`target_id`, `category`)
          )
          ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        ')->execute();

    }

    public function down()
    {
        $this->db->createCommand('DROP TABLE IF EXISTS `ms_target_categories`')->execute();
    }
}

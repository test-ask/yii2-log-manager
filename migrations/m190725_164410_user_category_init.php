<?php

use ys\migration\db\Migration;

class m190725_164410_user_category_init extends Migration
{
    public function up()
    {
        $this->db->createCommand('
         CREATE TABLE IF NOT EXISTS `ms_user_category` (
            `user_id` varchar(64) not null,
            `category` varchar(100) not null,
            PRIMARY KEY (`user_id`, `category`)
          )
          ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        ')->execute();

        return true;
    }

    public function down()
    {
        $this->db->createCommand('DROP TABLE IF EXISTS `ms_user_category`')->execute();

        return true;
    }
}

<?php

use ys\migration\db\Migration;

class m190726_163410_target_settings_init extends Migration
{
    public function up()
    {
        $this->db->createCommand('
         CREATE TABLE IF NOT EXISTS `ms_target_settings` (
            `id` int NOT NULL AUTO_INCREMENT,
            `class` varchar(255) not null,
            `name` varchar(255) not null,
            `enabled` tinyint default 1,
            `params` text default "",
            PRIMARY KEY (`id`)
          )
          ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        ')->execute();

    }

    public function down()
    {
        $this->db->createCommand('DROP TABLE IF EXISTS `ms_target_settings`')->execute();
    }
}

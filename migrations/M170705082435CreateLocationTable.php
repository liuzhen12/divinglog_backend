<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170705082435CreateLocationTable extends BaseMigration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('location', [
            'id' => $this->primaryKey(),
            'source' => $this->smallInteger()->notNull()->defaultValue(0)->comment('1:diver 2:coach 3:divestore'),
            'country' => $this->string(2)->notNull()->defaultValue(''),
            'province' => $this->string(45)->notNull()->defaultValue(''),
            'city' => $this->string(45)->notNull()->defaultValue(''),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('location',"id","bigint auto_increment");
        $this->createIndex('uniq_i',"location",['source','country','province','city']);
    }

    public function safeDown()
    {
        $this->dropTable("location");
    }

}

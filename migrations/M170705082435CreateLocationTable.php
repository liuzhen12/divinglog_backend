<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170705082435CreateLocationTable extends BaseMigration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
//        $this->createTable('location', [
//            'id' => $this->primaryKey(),
//            'source' => $this->smallInteger()->notNull()->defaultValue(0)->comment('1:diver 2:coach 3:divestore'),
//            'country' => $this->string(2)->notNull()->defaultValue(''),
//            'province' => $this->string(45)->notNull()->defaultValue(''),
//            'city' => $this->string(45)->notNull()->defaultValue(''),
//            'people_count' => $this->bigInteger()->notNull()->defaultValue(0)->comment(''),
//            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
//            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
//        ]);
//        $this->createIndex('uniq_i',"location",['source','na','province','city'],true);
        $this->createTable('location', [
            'id' => $this->primaryKey(),
            'source' => $this->smallInteger()->notNull()->defaultValue(0)->comment('1:diver 2:coach 3:divestore'),
            'name' => $this->string(45)->notNull()->defaultValue('country, province或者city的名字'),
            'detail' => $this->string(150)->notNull()->defaultValue('city, province，country'),
            'in_count' => $this->bigInteger()->notNull()->defaultValue(0)->comment('地区里的注册人数或者潜店数'),
            'query_count' => $this->bigInteger()->notNull()->defaultValue(0)->comment('被检索次数'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('location',"id","bigint auto_increment");
        $this->createIndex('uniq_i',"location",['source','name'],true);
    }

    public function safeDown()
    {
        $this->dropTable("location");
    }

}

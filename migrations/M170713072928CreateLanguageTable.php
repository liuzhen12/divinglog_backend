<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170713072928CreateLanguageTable extends BaseMigration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('language', [
            'id' => $this->primaryKey(),
            'relation_id' => $this->bigInteger()->notNull()->defaultValue(0)->comment('关联id,关联user,divestore'),
            'source' => $this->smallInteger()->notNull()->defaultValue(0)->comment('1:diver 2:coach 3:divestore'),
            'language_id' => $this->bigInteger()->notNull()->defaultValue(0)->comment('语言id,关联language'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('language',"id","bigint auto_increment");
        $this->createIndex('language_i','language',['language_id']);
        $this->createIndex('relation_i','language',['relation_id']);
    }

    public function safeDown()
    {
        $this->dropTable('language');
    }
}

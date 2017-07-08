<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170702115840CreateLanguageTable extends BaseMigration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('language', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->defaultValue('')->comment('语言单词'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('user',"id","bigint auto_increment");
        $this->batchInsert("language",
            ['id','name','created_at','updated_at'],
            [[1,'Mandarin',time(),time()],[2,'English',time(),time()],[3,'Cantonese',time(),time()]]);
    }

    public function safeDown()
    {
        $this->dropTable("language");
    }

}

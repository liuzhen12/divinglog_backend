<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170713072928CreateUserLanguageTable extends BaseMigration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('user_language', [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger()->notNull()->defaultValue(0)->comment('用户id,关联user'),
            'language_id' => $this->bigInteger()->notNull()->defaultValue(0)->comment('语言id,关联language'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('user_language',"id","bigint auto_increment");
        $this->createIndex('language_i','user_language',['language_id']);
        $this->createIndex('user_i','user_language',['user_id']);
    }

    public function safeDown()
    {
        $this->dropTable('user_language');
    }
}

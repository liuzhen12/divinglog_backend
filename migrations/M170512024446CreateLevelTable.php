<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024446CreateLevelTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('level', [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联用户'),
            'organization' => $this->string(45)->notNull()->defaultValue('')->comment('组织 PADI'),
            'level' => $this->string(20)->notNull()->defaultValue('')->comment('等级 OW AOW'),
            'no' => $this->string(20)->notNull()->defaultValue('')->comment('编号'),
            'coach_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('认证的教练'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('level',"id","bigint auto_increment");
        $this->createIndex('sort_i',"level",['user_id','updated_at']);
    }

    public function safeDown()
    {
        $this->dropTable('level');
    }
}

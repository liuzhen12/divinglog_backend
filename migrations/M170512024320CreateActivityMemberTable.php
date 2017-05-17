<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024320CreateActivityMemberTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('activity_member', [
            'id' => $this->primaryKey(),
            'activity_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联活动'),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联用户(潜员,教练)'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('activity_member',"id","bigint auto_increment");
    }

    public function safeDown()
    {
        $this->dropTable('activity_member');
    }
}

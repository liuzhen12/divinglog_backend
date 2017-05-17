<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024359CreateCourseTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('course', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45)->notNull()->defaultValue('')->comment('课程名字'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('course',"id","bigint auto_increment");
    }

    public function safeDown()
    {
        $this->dropTable('course');
    }
}

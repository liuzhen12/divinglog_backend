<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024350CreateCoachCourseTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('coach_course', [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联教练'),
//            'course_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联课程'),
            'organization' => $this->string(100)->notNull()->defaultValue('')->comment('关联课程组织SSI,PADI,NUI,CMAS'),
            'category' => $this->string(100)->notNull()->defaultValue('')->comment('scuba,freediver,snorkeling'),
            'duty' => $this->string(100)->notNull()->defaultValue('')->comment('diver,instructor,specialty,technical'),
            'name' => $this->string(100)->notNull()->defaultValue('')->comment('关联课程名'),
            'sub_name' => $this->string(100)->notNull()->defaultValue('')->comment('子课程名'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('coach_course',"id","bigint auto_increment");
        $this->createIndex('user_i',"coach_course",['organization','category','duty','name']);
        $this->createIndex('uniq_i',"coach_course",['user_id']);
    }

    public function safeDown()
    {
        $this->dropTable('coach_course');
    }
}

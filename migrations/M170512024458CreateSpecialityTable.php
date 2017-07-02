<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024458CreateSpecialityTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('speciality', [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联用户'),
            'desc' => $this->string(45)->notNull()->defaultValue('')->comment('特长描述'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('speciality',"id","bigint auto_increment");
        $this->createIndex('sort_i',"speciality",['user_id','updated_at']);
    }

    public function safeDown()
    {
        $this->dropTable('speciality');
    }
}

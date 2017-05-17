<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024337CreateCertificationTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('certification', [
            'id' => $this->primaryKey(),
            'log_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('diving_log 表id'),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联潜水员的id, user表的id，role是潜水员'),
            'coach_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联潜水员的id, user表的id，role是教练'),
            'score' => $this->smallInteger()->notNull()->defaultValue(0)->comment('给教练打分0-5分'),
            'remarks' => $this->string(140)->notNull()->defaultValue('')->comment('对教练的评价'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('certification',"id","bigint auto_increment");
    }

    public function safeDown()
    {
        $this->dropTable('certification');
    }
}

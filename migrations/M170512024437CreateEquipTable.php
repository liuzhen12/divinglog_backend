<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024437CreateEquipTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('equip', [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联用户'),
            'brand' => $this->string(45)->notNull()->defaultValue('')->comment('品牌'),
            'model' => $this->string(45)->notNull()->defaultValue('')->comment('型号'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('equip',"id","bigint auto_increment");
    }

    public function safeDown()
    {
        $this->dropTable('equip');
    }
}

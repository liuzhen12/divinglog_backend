<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024108CreateUserTable extends BaseMigration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'open_id' => $this->string(45)->notNull()->defaultValue('')->comment('微信用户的唯一标识'),
            'avatar_url' => $this->string(100)->notNull()->defaultValue('')->comment('微信头像图片'),
            'nick_name' => $this->string(45)->notNull()->defaultValue('')->comment('微信昵称'),
            'gender' => $this->smallInteger()->notNull()->defaultValue(0)->comment('1:男 2:女'),
            'city' => $this->string(45)->notNull()->defaultValue(''),
            'province' => $this->string(45)->notNull()->defaultValue(''),
            'country' => $this->string(2)->notNull()->defaultValue(''),
            'language' => $this->string(45)->notNull()->defaultValue(''),
            'language_detail' => $this->smallInteger()->notNull()->defaultValue(1)->comment('1->中 2->英 3->粤'),
            'role' => $this->smallInteger()->notNull()->defaultValue(1)->comment('1->潜员 2->教练'),
            'log_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('潜员属性->日志数量'),
            'equip_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('潜员属性->装备数量'),
            'level_keywords' => $this->string(45)->notNull()->defaultValue('')->comment('潜员属性->最新的等级关键词 组织+等级'),
            'speciality_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('潜员属性->专长数量'),
            'title' => $this->string(45)->notNull()->defaultValue('')->comment('教练属性->职称'),
            'is_store_manager' => $this->smallInteger()->notNull()->defaultValue(2)->comment('教练属性->1->是店长 2->不是店长'),
            'evaluation_count' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('教练属性->评价人数'),
            'evaluation_score' => $this->decimal(3,2)->notNull()->defaultValue(0)->comment('教练属性->评价平均分'),
            'divestore_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('教练属性->管理的潜店'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('user',"id","bigint");
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }

}

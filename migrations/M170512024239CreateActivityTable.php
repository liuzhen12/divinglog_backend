<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024239CreateActivityTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('activity', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger()->notNull()->defaultValue(1)->comment('1: 約伴'),
            'title' => $this->string(30)->notNull()->defaultValue('')->comment('活动标题'),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('发起人'),
            'wechat_no' => $this->string(20)->notNull()->defaultValue('')->comment('微信号或者QQ号或者绑定的手机号，但手机号如果修改，需要重新维护该信息'),
            'start_date' => $this->date()->notNull()->defaultValue('1000-01-01')->comment('活动开始日期'),
            'end_date' => $this->date()->notNull()->defaultValue('1000-01-01')->comment('活动结束日期'),
            'location_longitude' => $this->decimal(10,6)->notNull()->defaultValue(0)->comment('微信定位-经度'),
            'location_latitude' => $this->decimal(10,6)->notNull()->defaultValue(0)->comment('微信定位-纬度'),
            'location_name' => $this->string(45)->notNull()->defaultValue('')->comment('微信定位-位置名称'),
            'location_address' => $this->string(200)->notNull()->defaultValue('')->comment('微信定位-详细地址'),
            'dive_point' => $this->string(45)->notNull()->defaultValue('')->comment('潜点名字'),
            'max_member' => $this->smallInteger()->notNull()->defaultValue(0)->comment('活动人数设定上限'),
            'accommodation' => $this->smallInteger()->notNull()->defaultValue(0)->comment('住宿: 1 酒店 2 船潜'),
            'participants_count' => $this->smallInteger()->notNull()->defaultValue(0)->comment('已报名人数'),
            'description' => $this->string(150)->notNull()->defaultValue('')->comment('描述'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('activity',"id","bigint auto_increment");
    }

    public function safeDown()
    {
        $this->dropTable('activity');
    }
}

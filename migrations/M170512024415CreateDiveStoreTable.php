<?php

namespace app\migrations;

use app\components\base\BaseMigration;;

class M170512024415CreateDiveStoreTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('divestore', [
            'id' => $this->primaryKey(),
            'no' => $this->string(20)->notNull()->defaultValue('')->comment('潜店编号'),
            'name' => $this->string(45)->notNull()->defaultValue('')->comment('潜店名字'),
            'telephone' => $this->string(20)->notNull()->defaultValue('')->comment('潜店电话'),
            'wechat_id' => $this->string(45)->notNull()->defaultValue('')->comment('微信号或者qq号码或者手机号码，反正是可以直接加好友的ID'),
            'evaluation_count' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('评价次数'),
            'evaluation_score' => $this->decimal(3,2)->notNull()->defaultValue(0)->comment('评价平均分'),
            'coach_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('教练人数'),
            'avatar_url' => $this->string(200)->notNull()->defaultValue('')->comment('店铺門面图片'),
            'assets' => $this->string(200)->notNull()->defaultValue('')->comment('潜店照片链接'),
            'language_detail' => $this->string(20)->notNull()->defaultValue('')->comment('1->中 2->英 3->粤'),
            'city' => $this->string(45)->notNull()->defaultValue(''),
            'province' => $this->string(45)->notNull()->defaultValue(''),
            'country' => $this->string(45)->notNull()->defaultValue(''),
            'location_longitude' => $this->decimal(10,6)->notNull()->defaultValue(0)->comment('微信定位-经度'),
            'location_latitude' => $this->decimal(10,6)->notNull()->defaultValue(0)->comment('微信定位-纬度'),
            'location_name' => $this->string(45)->notNull()->defaultValue('')->comment('微信定位-位置名称'),
            'location_address' => $this->string(200)->notNull()->defaultValue('')->comment('微信定位-详细地址'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('divestore',"id","bigint auto_increment");
        $this->createIndex('no','divestore','no',true);
    }

    public function safeDown()
    {
        $this->dropTable('divestore');
    }
}

<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024425CreateDivingLogTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('diving_log', [
            'id' => $this->primaryKey(),
            'no' => $this->integer(11)->notNull()->defaultValue(1)->comment('潜水日志，对每个user,连续递增。即使有删除的情况发生，也要保持连续性。'),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联潜水员'),
            'day' => $this->date()->notNull()->defaultValue('1000-01-01')->comment('潜水日期'),
            'time_in' => $this->time()->notNull()->defaultValue('00:00:00')->comment('入水时间'),
            'time_out' => $this->time()->notNull()->defaultValue('00:00:00')->comment('出水时间'),
            'location_longitude' => $this->decimal(10,6)->notNull()->defaultValue(0)->comment('微信定位-经度'),
            'location_latitue' => $this->decimal(10,6)->notNull()->defaultValue(0)->comment('微信定位-纬度'),
            'location_name' => $this->string(45)->notNull()->defaultValue('')->comment('微信定位-位置名称'),
            'location_address' => $this->string(200)->notNull()->defaultValue('')->comment('微信定位-详细地址'),
            'dive_point' => $this->string(45)->notNull()->defaultValue('')->comment('潜点'),
            'depth1' => $this->smallInteger()->notNull()->defaultValue(0)->comment('潜水深度'),
            'time1' => $this->smallInteger()->notNull()->defaultValue(0)->comment('水下时间'),
            'depth2' => $this->smallInteger()->notNull()->defaultValue(0)->comment('潜水深度'),
            'time2' => $this->smallInteger()->notNull()->defaultValue(0)->comment('水下时间'),
            'depth3' => $this->smallInteger()->notNull()->defaultValue(0)->comment('潜水深度'),
            'time3' => $this->smallInteger()->notNull()->defaultValue(0)->comment('水下时间'),
            'gas' => $this->smallInteger()->notNull()->defaultValue(0)->comment('潜水气体 0:air other:高氧 纯氧含量(32代表32%的纯氧)'),
            'barometer_start' => $this->smallInteger()->notNull()->defaultValue(220)->comment('初始压力表数值'),
            'barometer_end' => $this->smallInteger()->notNull()->defaultValue(50)->comment('潜水结束时压力表数值'),
            'weight' => $this->smallInteger()->notNull()->defaultValue(4)->comment('配重'),
            'comments' => $this->string(140)->notNull()->defaultValue('')->comment('潜水的感受和评价'),
            'assets' => $this->string(250)->notNull()->defaultValue('')->comment('潜水照片链接'),
            'stamp' => $this->smallInteger()->notNull()->defaultValue(0)->comment('认证人数和被拷贝的日志数量之和'),
            'link_id' => $this->bigInteger()->notNull()->defaultValue(0)->comment('一次潜水buddies的日志可以通过copy来减少输入量，那么copy出来的日志和被copy的日志维护相同的link_id'),
            'divestore_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('关联潜店ID'),
            'divestore_score' => $this->smallInteger()->notNull()->defaultValue(0)->comment('给潜店打分'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('diving_log',"id","bigint auto_increment");
        $this->createIndex('user_id_i',"diving_log",'user_id');
        $this->createIndex('link_id_i',"diving_log",'link_id');
    }

    public function safeDown()
    {
        $this->dropTable('diving_log');
    }
}

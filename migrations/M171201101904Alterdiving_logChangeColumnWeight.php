<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M171201101904Alterdiving_logChangeColumnWeight extends BaseMigration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this -> alterColumn('diving_log', 'weight', $this->smallInteger()->notNull()->defaultValue(0)->comment('配重'));
    }

    public function safeDown()
    {
        $this -> alterColumn('diving_log', 'weight', $this->smallInteger()->notNull()->defaultValue(4)->comment('配重'));
    }

}

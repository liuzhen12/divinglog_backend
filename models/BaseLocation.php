<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\Link;

/**
 * This is the model class for table "base_location".
 *
 * @property integer $id
 * @property string $name
 * @property string $chinese_name
 * @property integer $p_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class BaseLocation extends \app\components\base\BaseModel
{
    const SCENARIO_INDEX = 'index';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'chinese_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'chinese_name' => Yii::t('app', 'Chinese Name'),
            'p_id' => Yii::t('app', '父级id，因为country有对应的province。同理procince又有对应的city'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_INDEX] = ['id','name','chinese_name'];
        return $scenarios;
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['base-location/view', 'id' => $this->id], true),
            'children' => Url::to(["@web/base-locations?p_id={$this->id}"], true)
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['p_id']);
        $fields['_links'] = [$this,'getLinks'];
        return $fields;
    }
}

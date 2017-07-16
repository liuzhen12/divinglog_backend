<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\Link;

/**
 * This is the model class for table "course".
 *
 * @property integer $id
 * @property string $name
 * @property string $chinese_name
 * @property integer $p_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Course extends \app\components\base\BaseModel
{
    const SCENARIO_INDEX = 'index';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'chinese_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '课程组织或名字'),
            'chinese_name' => Yii::t('app', '对应name字段的中文名字'),
            'p_id' => Yii::t('app', '父级id'),
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
            Link::REL_SELF => Url::to(['course/view', 'id' => $this->id], true),
            'children' => Url::to(["@web/courses?p_id={$this->id}"], true)
        ];
    }
}

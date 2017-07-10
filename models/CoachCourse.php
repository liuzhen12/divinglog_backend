<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\Link;

/**
 * This is the model class for table "coach_course".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $course_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class CoachCourse extends \app\components\base\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coach_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'course_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', '关联教练'),
            'course_id' => Yii::t('app', '关联课程'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['coach-course/view', 'id' => $this->id], true),
            'edit' => Url::to(['coach-course/view', 'id' => $this->id], true),
            'delete' => Url::to(['coach-course/view', 'id' => $this->id], true),
            'index' => Url::to(['@web/coach-courses'], true),
            'create' => Url::to(['@web/coach-courses'], true),
            'detail' => Url::to(["@web/courses/{$this->course_id}"], true),
        ];
    }
}

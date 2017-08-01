<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_language".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $language_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Language extends \app\components\base\BaseModel
{
    const SOURCE_DIVER = 1;
    const SOURCE_COACH = 2;
    const SOURCE_DIVESTORE = 3;
    public $language_detail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relation_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'relation_id' => Yii::t('app', '关联id,关联user,divestore'),
            'source' => Yii::t('app', '关联id,关联user,divestore'),
            'language_id' => Yii::t('app', '语言id,关联language'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    /**
     * Name: batchSave
     * Desc: 批量添加语言的对应关系 user或者潜店对应的语言关系
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170708
     * Modifier:
     * ModifiedDate:
     * @return bool
     */
    public function batchSave()
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            Language::deleteAll(['relation_id' => $this->relation_id,'source' => $this->source]);
            if(!empty($this->language_detail)){
                $languageArr = explode(',', $this->language_detail);
                foreach ($languageArr as $v) {
                    $userLanguage = new Language();
                    $userLanguage->relation_id = $this->relation_id;
                    $userLanguage->source = $this->source;
                    $userLanguage->language_id = $v;
                    $userLanguage->save();
                }
            }
            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();
        }
        return false;
    }
}

<?php

namespace frontend\models;

use Yii;
use Yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%migration}}".
 *
 * @property string $version
 * @property integer $apply_time
 */
class Migration extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%migration}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version'], 'required'],
            [['apply_time'], 'integer'],
            [['version'], 'string', 'max' => 180]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'version' => 'Version',
            'apply_time' => 'Apply Time',
        ];
    }
}

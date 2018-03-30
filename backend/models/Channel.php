<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%channel}}".
 *
 * @property integer $id
 * @property string $channel_name
 * @property string $channel_keyword
 * @property string $channel_description
 */
class Channel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%channel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_name'], 'required'],
            [['channel_name'], 'string', 'max' => 30],
            [['channel_keyword'], 'string', 'max' => 100],
            [['channel_description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品渠道',
            'channel_name' => '渠道名称',
            'channel_keyword' => '关键词 ',
            'channel_description' => '渠道简介',
        ];
    }
    /**
     * @param $id
     * @param string $goods
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * 删除商品渠道
     */
    public function fmodel($id,$goods='')
    {
        if(!$goods)
        {
            $this->findOne($id)->delete();
            Yii::$app->session->setFlash('success','删除成功!');
        }
        else
        {
            Yii::$app->session->setFlash('success','渠道下可能存在商品不可删除!');
        }
    }

    /**
     * @param $id
     * @return null|static
     */
    public function edmodel($id)
    {
        $res = $this->findOne($id);
        if($res)
        {
            return $res;
        }
    }
}

<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%contact}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $content
 */
class Contact extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'content'], 'required'],
            [['addtime'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 36],
            ['email', 'email'],
            [['content'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'email' => '邮箱',
            'content' => '留言内容',
            'addtime' => '添加时间',
        ];
    }
    public function addmes()
    {
        if(!$this->validate())
        {
            return null;
        }
        $this->addtime = time();
        $res = $this->save();
        if($res)
        {
            Yii::$app->session->setFlash('error','留言成功！'); //页面提示信息
        }
        else
        {
            Yii::$app->session->setFlash('success','留言失败！'); //页面提示信息
        }
    }
}

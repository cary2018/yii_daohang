<?php
/**
 *
 * 文章信息数据模
 * author Cary
 * contact QQ : 373889161($S$-memory)
 *
 */
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
class Article extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%article}}';
    }

    public function rules()
    {
        return [
            [['pid', 'is_show'], 'integer'],
            [['title','pid'], 'required'],
            [['content'], 'string'],
            [['uptime', 'addtime'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['keywords'], 'string', 'max' => 120],
            [['description'], 'string', 'max' => 150]        ];
    }

    public function addmeg()
    {
        $this->uptime = time();
        $this->addtime = time();
        return $this->save();
    }

    public function attributeLabels()
    {
        return [
            'id'=>'id',
            'pid'=>'所属分类',
            'title'=>'标题',
            'keywords'=>'关键字',
            'description'=>'简介',
            'content'=>'内容',
            'is_show'=>'是否发布',

        ];
    }
    public function getSort()
    {
        return $this->hasMany(Sort::className(),['id'=>'pid'])->select('id,sort_name');
    }

}
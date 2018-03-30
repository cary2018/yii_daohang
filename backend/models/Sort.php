<?php
/**
 *
 * 文章分类数据模
 * author Cary($S$-memory)
 * contact QQ : 373889161
 *
 */
namespace backend\models;

use yii\db\ActiveRecord;

class Sort extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%sort}}';
    }

    public function rules()
    {
        return [
            [['sort_name'],'required'],
            [['pid', 'order'], 'integer'],
            [['sort_name', 'keywords', 'description', 'is_nav', 'is_show'], 'string', 'max' => 255]
        ];
    }

    public function addmeg()
    {
        return $this->save();
    }

    public function attributeLabels()
    {
        return [
            'id'=>'id',
            'pid'=>'上级分类',
            'sort_name'=>'分类名',
            'keywords'=>'关键字',
            'description'=>'描述',
            'order'=>'排序',
            'is_nav'=>'导航菜单',
            'is_show'=>'是否显示',
        ];
    }

}
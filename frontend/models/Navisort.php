<?php
/**
 * 导航分类数据模
 * author Cary
 * contact QQ : 373889161($S$-memory)
 *
 */
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Navisort extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%nav_sort}}';
    }

    public function rules()
    {
        return [
            [['pid'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['keywords', 'description'], 'string', 'max' => 150]
        ];
    }

    // 获取关联表的数据
    public function getNavigation()
    {
        // 第一个参数为要关联的子表模型类名，
        // 第二个参数指定 通过关联表的 id，关联主表的 nav_pid 字段
        //读取关系表字段格式  $navigation->navisort[0]['name']
        return $this->hasMany(Navigation::className(), ['nav_pid' => 'id'])
            ->where(['is_show'=>1])
            ->groupBy(['nav_pid']);
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '上级分类',
            'name' => '分类名',
            'keywords' => '关键字',
            'description' => '描述',
        ];
    }
}
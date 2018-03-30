<?php
/**
 * 导航分类数据模
 * author Cary
 * contact QQ : 373889161($S$-memory)
 *
 */
namespace backend\models;

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
        return $this->hasMany(Navigation::className(), ['id' => 'nav_pid'])->select(['id','name']);
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
    //更新所属栏目分类的显示数量
    public function upnumber($uid,$oval)
    {
        $val = Navisort::findOne($uid);
        if(!$val){
            return null;
        }
        $val->number = $oval;
        $res = $val->save();
        if($res)
        {
            $arr = ['result'=>'更新成功!'];
            echo json_encode($arr);
        }
        else
        {
            $arr = ['result'=>'更新失败!'];
            echo json_encode($arr);
        }
    }
    //更新分类导航排序
    public function upsort($uid,$oval)
    {
        $val = Navisort::findOne($uid);
        if(!$val){
            return null;
        }
        $val->sort_id = $oval;
        $res = $val->save();
        if($res)
        {
            $arr = ['result'=>'更新成功!'];
            echo json_encode($arr);
        }
        else
        {
            $arr = ['result'=>'更新失败!'];
            echo json_encode($arr);
        }
    }
    //更新导航分类状态是否显示
    public function upstatus($id,$val){
        $show = Navisort::findOne($id);
        if(!$show)
        {
            return null;
        }
        if(trim($val) == '有效')
        {
            $show->status = 0;
        }
        else
        {
            $show->status = 1;
        }
        $res = $show->update();
        if($res)
        {
            if($val == '有效')
            {
                $arr = ['val'=>'无效','result'=>'更新成功!'];
            }
            else
            {
                $arr = ['val'=>'有效','result'=>'更新成功!'];
            }
            echo json_encode($arr);
        }
        else
        {
            $arr = ['val'=>'无效','result'=>'更新失败!'];
            echo json_encode($arr);
        }
    }
}
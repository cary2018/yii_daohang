<?php
/**
 *
 * 导航列表数据模
 * author Cary
 * contact QQ : 373889161($S$-memory)
 *
 */
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%navigation}}".
 *
 * @property integer $nav_id
 * @property integer $nav_pid
 * @property string $nav_name
 * @property string $nav_url
 * @property string $sun_url
 * @property string $keywords
 * @property string $description
 * @property string $nav_addtime
 * @property string $nav_uptime
 */
class Navigation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%navigation}}';
    }
    public function rules()
    {
        return [
            [['nav_pid', 'ordery', 'is_target', 'is_show', 'nav_addtime', 'nav_uptime'], 'integer'],
            [['nav_name', 'nav_url','nav_pid' ], 'required'],
            [['nav_name', 'sun_name'], 'string', 'max' => 15],
            [['nav_url', 'sun_url', 'description'], 'string', 'max' => 200],
            [['keywords'], 'string', 'max' => 100],
        ];
    }

    // 获取关联表的数据
    public function getNavisort()
    {
        // 第一个参数为要关联的子表模型类名，
        // 第二个参数指定 通过关联表的 id，关联主表的 nav_pid 字段
        //读取关系表字段格式  $navigation->navisort[0]['name']
        return $this->hasMany(Navisort::className(), ['id' => 'nav_pid'])->select(['id','name']);
    }

    public function attributeLabels()
    {
        return [
            'nav_id' => 'Nav ID',
            'nav_pid' => '所属分类',
            'nav_name' => '站点名称',
            'nav_url' => '链接地址',
            'sun_name' => '子站名称',
            'sun_url' => '链接地址',
            'ordery'  => '排序',
            'keywords' => '关键字',
            'description' => '描述',
            'is_target' => '是否新窗口打开',
            'is_show' => '是否有效',
            'nav_addtime' => '添加时间',
            'nav_uptime' => '更新时间',
        ];
    }

    /**
     * @return bool|null
     * 添加导航信息
     */
    public function addmages()
    {
        if (!$this->validate()) {
            return null;
        }
        if(strpos($this->nav_url,'http://') === false && strpos($this->nav_url,'https://')===false && $this->nav_url !='' )
        {
            $url = 'http://'.trim($this->nav_url);
        }
        else
        {
            $url = trim($this->nav_url);
        }
        if(strpos($this->sun_url,'http://') === false && strpos($this->sun_url,'https://')===false && $this->sun_url !='' )
        {
            $surl = 'http://'.trim($this->sun_url);
        }
        else
        {
            $surl = trim($this->sun_url);
        }
        if($this->ordery){
            $this->ordery = $this->ordery;
        }else{
            $this->ordery = 100;
        }
        $this->nav_url = $url;
        $this->sun_url = $surl;
        $this->nav_addtime = time();
        $this->nav_uptime = time();
        return $this->save();
    }

    /**
     * @param $id
     * @return bool|null
     * 更新导航信息
     */
    public function updata($id)
    {
        if (!$this->validate()) {
            return null;
        }
        $nav = Navigation::findOne($id);
        if($nav != null){
            if(strpos($this->nav_url,'http://') === false && strpos($this->nav_url,'https://')===false && $this->nav_url !='' )
            {
                $url = 'http://'.trim($this->nav_url);
            }
            else
            {
                $url = trim($this->nav_url);
            }
            if(strpos($this->sun_url,'http://') === false && strpos($this->sun_url,'https://')===false && $this->sun_url !='' )
            {
                $surl = 'http://'.trim($this->sun_url);
            }
            else
            {
                $surl = trim($this->sun_url);
            }
            if($this->ordery){
                $nav->ordery = $this->ordery;
            }else{
                $nav->ordery = 100;
            }
            $nav->nav_name = $this->nav_name;
            $nav->nav_url = $this->nav_url;
            $nav->sun_name = $this->sun_name;
            $nav->sun_url = $this->sun_url;
            $nav->nav_pid = $this->nav_pid;
            $nav->keywords = $this->keywords;
            $nav->description = $this->description;
            $nav->is_target = $this->is_target;
            $nav->is_show = $this->is_show;
            $nav->nav_url = $url;
            $nav->sun_url = $surl;
            $nav->nav_uptime = time();
            return $nav->save();
        }
    }

    /**
     * @param $uid
     * @param $oval
     * @return bool|null
     * 异步更新导航排序
     */
    public function uporder($uid,$oval)
    {
        $val = Navigation::findOne($uid);
        if(!$val){
            return null;
        }
        $val->ordery = $oval;
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
    /**
     * @param $id
     * @param $val
     * @return null
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * 异步更新导航是否有效
     */
    public function upshow($id,$val){
        $show = Navigation::findOne($id);
        if(!$show)
        {
            return null;
        }
        if(trim($val) == '有效')
        {
            $show->is_show = 0;
        }
        else
        {
            $show->is_show = 1;
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

    /**
     * @param $sub    操作类型， 删除 或者 更新
     * @param $ch_id  要删除的id
     * @param $pid    分类id
     *
     */
    public function batch_del($sub,$ch_id,$pid)
    {
        $mode = new Navigation();
        if($sub)
        {
            if($ch_id && !$pid && $sub=='删除')
            {
                $value = implode(',',$ch_id);
                //批量删除数据
                $res = $mode->deleteAll('nav_id in('.$value.')');
                if($res)
                {
                    Yii::$app->session->setFlash('success','删除成功！'); //页面提示信息
                }
                else
                {
                    Yii::$app->session->setFlash('success','删除失败！'); //页面提示信息
                }
            }
            elseif($ch_id && $pid && $sub=='确定')
            {
                $value = implode(',',$ch_id);
                //批量更新数据
                $res = $mode->updateAll(['nav_pid'=>$pid],'nav_id in('.$value.')');
                if($res)
                {
                    Yii::$app->session->setFlash('success','更新成功！'); //页面提示信息
                }
                else
                {
                    Yii::$app->session->setFlash('success','更新失败！'); //页面提示信息
                }
            }
            else
            {
                Yii::$app->session->setFlash('success','操作失败！！'); //页面提示信息
            }
        }
        else
        {
            Yii::$app->session->setFlash('success','操作失败！'); //页面提示信息
            die('参数错误！');
        }
    }
}
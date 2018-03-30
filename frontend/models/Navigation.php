<?php
/**
 *
 * 导航列表数据模
 * author Cary
 * contact QQ : 373889161($S$-memory)
 *
 */
namespace frontend\models;

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
            [['nav_pid', 'is_target', 'is_show', 'nav_addtime', 'nav_uptime'], 'integer'],
            [['nav_name', 'nav_url','nav_pid' ], 'required'],
            [['nav_name', 'sun_name'], 'string', 'max' => 15],
            [['nav_url', 'sun_url', 'description'], 'string', 'max' => 150],
            [['keywords'], 'string', 'max' => 100],
        ];
    }
    public function attributeLabels()
    {
        return [
            'nav_id' => 'Nav ID',
            'nav_pid' => '所属分类',
            'nav_name' => '导航名称',
            'nav_url' => '导航地址',
            'sun_name' => '子级导航',
            'sun_url' => '子级地址',
            'keywords' => '关键字',
            'description' => '描述',
            'is_target' => '是否新窗口打开',
            'is_show' => '是否有效',
            'nav_addtime' => '添加时间',
            'nav_uptime' => '更新时间',
        ];
    }

    public function addmages()
    {
        if (!$this->validate()) {
            return null;
        }
        if(strpos($this->nav_url,'http://') === false && strpos($this->nav_url,'https://')===false )
        {
            $url = 'http://'.trim($this->nav_url);
        }
        else
        {
            $url = trim($this->nav_url);
        }
        if(strpos($this->sun_url,'http://') === false && strpos($this->sun_url,'https://')===false )
        {
            $surl = 'http://'.trim($this->sun_url);
        }
        else
        {
            $surl = trim($this->sun_url);
        }
        $this->nav_url = $url;
        $this->sun_url = $surl;
        $this->nav_addtime = time();
        $this->nav_uptime = time();
        return $this->save();
    }
    public function updata($id)
    {
        if (!$this->validate()) {
            return null;
        }
        $nav = Navigation::findOne($id);
        if($nav != null){
            if(strpos($this->nav_url,'http://') === false && strpos($this->nav_url,'https://')===false )
            {
                $url = 'http://'.trim($this->nav_url);
            }
            else
            {
                $url = trim($this->nav_url);
            }
            if(strpos($this->sun_url,'http://') === false && strpos($this->sun_url,'https://')===false )
            {
                $surl = 'http://'.trim($this->sun_url);
            }
            else
            {
                $surl = trim($this->sun_url);
            }
            $nav->nav_url = $url;
            $nav->sun_url = $surl;
            $nav->nav_uptime = time();
            return $nav->save();
        }
    }
}
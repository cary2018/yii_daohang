<?php
/**
 *
 * 产品分类数据模
 * author Cary($S$-memory)
 * contact QQ : 373889161
 *
 */
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%category}}".
 * @property string $cat_name
 * @property number $parent_id
 * @property string $keywords
 * @property string $cat_desc
 */
class Category extends ActiveRecord
{
    public $c_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['cat_name'], 'required','on'=>['create','edit']], //表示只对 create 场景作用
            [['cat_id','parent_id'],'number'],
            [['keywords','cat_desc'],'string'],
        ];
    }

    public function scenarios()
    {
        $parent = parent::scenarios(); // 默认场景(未指定场景时使用)
        $parent['create'] = ['cat_name','parent_id','keywords','cat_desc'];
        return $parent;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()   //返回显示数据
    {
        return [
            'cat_id' => '上级分类',
            'cat_name' => '用户名',
            'parent_id' => '上级分类',
            'keywords' => '关键字',
            'cat_desc' => '描述',
            'stro_order' => '排序',
            'is_show' => '显示',
            'cat_ico'=> '小图标',
        ];
    }

    /**
     * @return bool|null
     * @throws \yii\base\Exception
     * 添加新内容
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        if(empty($this->parent_id))
        {
            $pid = 0;
        }
        else
        {
            $pid = $this->parent_id;
        }
        $this->cat_name = $this->cat_name;
        $this->parent_id = $pid;
        $this->keywords = $this->keywords;
        $this->cat_desc = $this->cat_desc;
        return $this->save();
    }

    public function stuts($goods,$data,$id)
    {
        if(!$goods)
        {
            if(!$data)
            {
                $this->findOne($id)->delete();
                Yii::$app->session->setFlash('success','删除成功!');
            }
            else
            {
                Yii::$app->session->setFlash('success','删除错误!');
            }
        }
        else
        {
            Yii::$app->session->setFlash('success','删除数据错误!');
        }
    }

}

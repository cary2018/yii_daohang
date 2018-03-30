<?php
/**
 *
 * 产品列表数据模
 * author Cary($S$-memory)
 * contact QQ : 373889161
 */
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property integer $channel_id
 * @property integer $goods_id
 * @property string $goods_name
 * @property string $goods_img
 * @property string $goods_url
 * @property string $shop_name
 * @property string $goods_prices
 * @property string $goods_sales
 * @property string $income_ratio
 * @property string $shop_wan
 * @property string $short_links
 * @property string $taobao_links
 * @property integer $is_best
 * @property integer $is_new
 * @property integer $is_hot
 * @property integer $is_show
 * @property integer $view_num
 * @property integer $sort_order
 * @property integer $addtime
 * @property integer $uptime
 * @property integer $filename
 */
class Goods extends ActiveRecord
{
    public $filename;
    public $arr_result;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_name'],'required'],
            [['filename','cat_id'], 'required','on'=>['excel']],    // on 设置该场景只对
            [['cat_id','goods_id','goods_prices','goods_name','taobao_links'], 'required','on'=>['create']],    // on 设置该场景只对
            [['goods_prices','goods_id','channel_id'],'number'],
            ['filename', 'file', 'extensions' => 'jpg,jpeg,png','maxSize' => 1024*1024,'on'=>'create'],     // on 设置该场景只对
        ];
    }

    public function scenarios()     //设置多个验证场景
    {
        $parent = parent::scenarios();  //默认场景
        $parent['excel'] = ['cat_id','channel_id','filename'];  //excel 使用: $model->scenario='excel';
        $parent['create'] = ['cat_id','channel_id','goods_id','goods_name',
            'goods_img','goods_url','shop_name','goods_prices',
            'goods_sales','income_ratio','shop_wan','short_links','taobao_links',
            'is_best','is_new','is_hot','is_show','sort_order','addtime','uptime','filename'];  //设置单独场景
        return $parent;
    }

    public function upload()
    {
        if ($this->validate()) {
            $rootPath = "upload/";
            $ext = $this->filename->getExtension();
            $randName = time().rand(1000,9999).".".$ext;
            $path = abs(crc32($randName)%500);
            $rootPath = $rootPath . $path . "/";
            if(!file_exists($path)){
                mkdir($rootPath,true);
            }
            $this->filename->saveAs($rootPath.$randName);

            foreach ($this->filename as $file) {
                $file->saveAs('uploads/' . $file->baseName .$randName. '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * 批量导入数据
     */
    public function savexls()
    {
        // 查询记录是否存在(根据商品淘宝ID)
        $customer = Goods::findOne(['goods_id' => trim($this->arr_result[0])]);
        if($customer !== null ){    //记录存在执行更新操作
            $customer->cat_id = $this->cat_id;
            $customer->channel_id = $this->channel_id;
            $customer->goods_id = $this->arr_result[0];
            $customer->goods_name = $this->arr_result[1];
            $customer->goods_img = $this->arr_result[2];
            $customer->goods_url = $this->arr_result[3];
            $customer->shop_name = $this->arr_result[4];
            $customer->goods_prices = $this->arr_result[5];
            $customer->goods_sales = $this->arr_result[6];
            $customer->income_ratio = $this->arr_result[7];
            $customer->commission = $this->arr_result[8];
            $customer->shop_wan = $this->arr_result[9];
            $customer->short_links = $this->arr_result[10];
            $customer->taobao_links = $this->arr_result[11];
            $customer->amoyp = $this->arr_result[12];
            $customer->coupon_total = $this->arr_result[13];
            $customer->coupon_over = $this->arr_result[14];
            $customer->coupon_value = $this->arr_result[15];
            $customer->coupon_start = $this->arr_result[16];
            $customer->coupon_end = $this->arr_result[17];
            $customer->coupon_link = $this->arr_result[18];
            $customer->coupon_p = $this->arr_result[19];
            $customer->addtime = time();
            $customer->uptime = time();
            $customer->filename = $this->arr_result[0]; //注:此字段为保证 filename 能正常验证和插入数据用
            return $customer->update();
        }else{      //记录不存在执行插入操作
            $this->goods_id = $this->arr_result[0];
            $this->goods_name = $this->arr_result[1];
            $this->goods_img = $this->arr_result[2];
            $this->goods_url = $this->arr_result[3];
            $this->shop_name = $this->arr_result[4];
            $this->goods_prices = $this->arr_result[5];
            $this->goods_sales = $this->arr_result[6];
            $this->income_ratio = $this->arr_result[7];
            $this->commission = $this->arr_result[8];
            $this->shop_wan = $this->arr_result[9];
            $this->short_links = $this->arr_result[10];
            $this->taobao_links = $this->arr_result[11];
            $this->amoyp = $this->arr_result[12];
            $this->coupon_total = $this->arr_result[13];
            $this->coupon_over = $this->arr_result[14];
            $this->coupon_value = $this->arr_result[15];
            $this->coupon_start = $this->arr_result[16];
            $this->coupon_end = $this->arr_result[17];
            $this->coupon_link = $this->arr_result[18];
            $this->coupon_p = $this->arr_result[19]?$this->arr_result[19]:'';
            $this->addtime = time();
            $this->uptime = time();
            $this->filename = $this->arr_result[0]; //注:此字段为保证 filename 能正常验证和插入数据用
            return $this->save();
        }
    }

    public function addcreate(){

        //var_dump($this);
        $this->addtime = time();
        $this->uptime = time();
        return $this->save();
    }
    /**
     * @param $chid
     * 批量操作数据
     */
    public function batchde($chid)
    {
        if($chid)
        {
            $value = implode(',',$chid);
            //批量删除数据
            $res = $this->deleteAll('id in('.$value.')');
            if($res)
            {
                Yii::$app->session->setFlash('success','删除成功！'); //页面提示信息
            }
            else
            {
                Yii::$app->session->setFlash('success','删除失败！'); //页面提示信息
            }
        }
        else
        {
            Yii::$app->session->setFlash('success','参数错误！'); //页面提示信息
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => '商品分类',
            'channel_id' => '商品渠道',
            'goods_id' => '淘宝商品ID',
            'goods_name' => '商品名称',
            'goods_img' => '商品图片',
            'goods_url' => '商品详情页链接地址',
            'shop_name' => '店铺名称',
            'goods_prices' => '商品价格(单位：元)',
            'goods_sales' => '商品月销量',
            'income_ratio' => '收入比率',
            'shop_wan' => '卖家旺旺',
            'short_links' => '淘宝客短链接(300天内有效)',
            'taobao_links' => '淘宝客链接',
            'is_best' => '精品',
            'is_new' => '新品',
            'is_hot' => '热销',
            'is_show' => '是否显示（上架，下架）',
            'view_num' => '浏览次数',
            'sort_order' => '默认排序',
            'addtime' => '添加时间',
            'uptime' => '修改时间',
            'filename' => 'excel文件',
        ];
    }
}

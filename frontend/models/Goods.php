<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $id
 * @property integer $cat_id
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
 */
class Goods extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';    //字义表名
    }

    /**
     * @inheritdoc
     */
    public function rules()  //表单验证规则 (required)必填  (integer)整数 (number)数字
    {
        return [
            [['cat_id', 'goods_name', 'taobao_links', 'view_num', 'addtime', 'uptime'], 'required'],
            [['cat_id', 'goods_id', 'is_best', 'is_new', 'is_hot', 'is_show', 'view_num', 'sort_order', 'addtime', 'uptime'], 'integer'],
            [['goods_prices'], 'number'],
            [['goods_name'], 'string', 'max' => 100],
            [['goods_img', 'goods_url', 'shop_name', 'goods_sales', 'income_ratio', 'shop_wan', 'short_links', 'taobao_links'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()   //需要输出的字段
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'goods_id' => 'Goods ID',
            'goods_name' => 'Goods Name',
            'goods_img' => 'Goods Img',
            'goods_url' => 'Goods Url',
            'shop_name' => 'Shop Name',
            'goods_prices' => 'Goods Prices',
            'goods_sales' => 'Goods Sales',
            'income_ratio' => 'Income Ratio',
            'shop_wan' => 'Shop Wan',
            'short_links' => 'Short Links',
            'taobao_links' => 'Taobao Links',
            'is_best' => 'Is Best',
            'is_new' => 'Is New',
            'is_hot' => 'Is Hot',
            'is_show' => 'Is Show',
            'view_num' => 'View Num',
            'sort_order' => 'Sort Order',
            'addtime' => 'Addtime',
            'uptime' => 'Uptime',
        ];
    }
}

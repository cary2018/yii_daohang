<?php

namespace frontend\models;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $cat_id
 * @property integer $parent_id
 * @property string $cat_name
 * @property string $keywords
 * @property string $cat_desc
 * @property integer $stro_order
 * @property integer $is_show
 * @property integer $show_num
 * @property integer $index_show
 * @property string $cat_ico
 */
class Category extends \yii\db\ActiveRecord
{
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
            [['parent_id', 'stro_order', 'is_show', 'show_num', 'index_show'], 'integer'],
            [['cat_name', 'keywords', 'cat_desc', 'show_num', 'index_show', 'cat_ico'], 'required'],
            [['cat_name'], 'string', 'max' => 90],
            [['keywords', 'cat_desc', 'cat_ico'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => 'Cat ID',
            'parent_id' => 'Parent ID',
            'cat_name' => 'Cat Name',
            'keywords' => 'Keywords',
            'cat_desc' => 'Cat Desc',
            'stro_order' => 'Stro Order',
            'is_show' => 'Is Show',
            'show_num' => 'Show Num',
            'index_show' => 'Index Show',
            'cat_ico' => 'Cat Ico',
        ];
    }
}

<?php
/**
 * author Cary
 * contact QQ : 373889161($S$-memory)
 * 扩展自定义函数文件
 * auth_rule            //规则,规则类名
 * auth_item_child    //角色对应的权限,parent角色,child权限名
 * auth_item            //角色|权限表,type=1角色,type=2权限
 * auth_assignment    //角色与用户对应关系表
 *
 */
use backend\models\Admin;
class Helpers
{
    /**
     * @param $id   (传入id取得登录用户信息)
     * @param string $sename  (传入要保存的session名称)
     * @return null|string|static
     *
     */
    public static function yiisession($id,$sename="")
    {
        $session = Yii::$app->session;
        if($id)
        {
            $make = Admin::findOne(['id'=>$id]);
        }
        else
        {
            $make = '';
        }
        $session->setTimeout(5);
        //$session->setSavePath('/');
        //$make = Admin::findOne(['id'=>$id]);
        $me = $session["$sename"] = $make;
        return $me;
        // 关闭session
        $session->close();
    }

    /**
     * @param $session_id this session name (使用已保存的session名称)
     * @return mixed
     */
    public static function resession($session_id)
    {
        $session = Yii::$app->session;   //开户session
        $re = $session[$session_id];    //读取session
        return $re;
    }

    /**
     * @param $arr
     * @param int $id
     * @param int $lev
     * @return array
     * $pid = 上级ID
     * $cid = 分类ID
     * $canme = 分类名
     * 返回顶级分类
     */
    public function gettree($arr,$pid='parent_id',$cid = 'cat_id',$cname = 'cat_name',$lin = 0,$id=0,$snume = 0) {
        $subs = array(); // 子孙数组
        foreach($arr as $v) {
            if($v->$pid == $id) {
                $subs[] = array('name'=>$v->$cname,'id'=>$v->$cid,'pid'=>$v->$pid,'coun'=>$snume); //返回信息
                if($v->$cid){
                    if($this->get_tree($arr,$pid,$cid,$cname,$lin,$v->$cid)){  //返回数据不为空时 创建新数组
                        $subs[] = $this->get_tree($arr,$pid,$cid,$cname,$lin,$v->$cid,$snume+1);
                    }
                }
            }
        }
        return $subs;
    }

    /**
     * @param $arr
     * @param int $id   传入的分类ID
     * @param int $coun
     * @return array
     * $pid = 上级ID
     * $cid = 分类ID
     * $canme = 分类名
     * 返回指定分类ID下的所有子分类
     */
    public function get_tree($arr,$pid='parent_id',$cid = 'cat_id',$cname = 'cat_name',$lin=0,$id=0,$coun = 0){
        $tree = array();    // 子孙数组
        foreach($arr as $v){
            if($v->$pid == $id ){
                if($lin == 0){
                    $line = $this->line($coun);    //返回层级隔离线
                }else{
                    $line = '';
                }
                $tree[] = array('name'=> $line.$v->$cname,'id'=>$v->$cid,'pid'=>$v->$pid,'coun'=>$coun);
                if($v->$cid){
                    if($this->get_tree($arr,$pid,$cid,$cname,$lin,$v->$cid)){  //返回数组不为空创建新数组
                        $tree[] = $this->get_tree($arr,$pid,$cid,$cname,$lin,$v->$cid,$coun+1);
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * @param $id
     * @param int $show
     * @return array
     * 返回指定商品分类ID下的所有分类
     * 可以根据返回的数据判断是否可以执行删除操作
     */
    public function getarr($id,$show=0)
    {
        $arr = \backend\models\Category::find()->all();
        $data = array();
        foreach($arr as $key)
        {
            if($show > 0)
            {
                if($key->cat_id == $id)
                {
                    $data[] = $key->cat_id;
                }
            }
            if($key->parent_id == $id)
            {

                $data[] = $key->cat_id;
                if($key->cat_id)
                {
                    $data[] = $this->getarr($key->cat_id);
                }
            }
        }
        return array_filter($data);
    }

    /**
     * @param $id
     * @param int $show
     * @return array
     * 返回指定文章分类ID下的所有分类
     */
    public function getsort($id,$show=0)
    {
        $arr = \backend\models\Sort::find()->all();
        $data = array();
        foreach($arr as $key)
        {
            if($show > 0)
            {
                if($key->id == $id)
                {
                    $data[] = $key->id;
                }
            }
            if($key->pid == $id)
            {

                $data[] = $key->id;
                if($key->id)
                {
                    $data[] = $this->getarr($key->id);
                }
            }
        }
        return array_filter($data);
    }

    /**
     * @param $arr
     * @return string
     * 返回指定分类下的所有ID(包含自身)
     */
    public function returnid($arr)
    {
        static $reuid;
        foreach($arr as $key=>$val)
        {

            if(is_array($val))
            {
                $this->returnid($val);
            }
            else
            {
                $reuid .= $val.',';
            }
        }
        return substr($reuid,0,strlen($reuid)-1);
    }

    /**
     * @param $va
     * @return string
     * 层级隔离线
     */
    public function line($va){
        $af = '';
        for($i=0;$i<$va;$i++){
            $af .= '---';
        }
        return $af;
    }
    /**
     * @param $arr
     * @return int
     * 判断数组是否为一维数组
     */
    public function if_array($arr){
        if(!is_array($arr)){
            return 0;
        }else{
            $dimension = 0;
            foreach($arr as $item1)
            {
                $t1=$this->if_array($item1);
                if($t1>$dimension){$dimension = $t1;}
            }
            return $dimension+1;
        }
    }

    /**
     * @param $arr
     * @return array
     * 循环无限级菜单 并合并成二维数组
     */
    public function formenu($arr){
        static $call = array();
        foreach($arr as $key){
            $count = $this->if_array($key);
            if($count > 1){
                $this->formenu($key);
            }else
                $call[] = $key;
        }
        return $call;
    }

    /**
     * @param $array
     * @return array
     *
     * 将多维数组转换成一维数组
     */
    public function array_multi2single($array){
        static $result_array=array();
        foreach($array as $value){
            if(is_array($value)){
                $this->array_multi2single($value);
            }
            else
                $result_array[]=$value;
        }
        return $result_array;
    }

    /**
     * @param $string  传入的字符串
     * @param $length  要截取的长度（字数）
     * @param string $etc  超出部分以 默认以 ... 显示
     * @return string
     * 字符串截取
     */
    public static function sub_utf8_string($string, $length, $etc = '...')
    {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $str_len = strlen($string);
        for ($i = 0; (($i < $str_len) && ($length > 0)); $i++)
        {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
            {
                if ($length < 1.0)
                {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            }
            else
            {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $str_len)
        {
            $result .= $etc;
        }
        return $result;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}


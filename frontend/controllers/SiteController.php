<?php
namespace frontend\controllers;

use frontend\core\MY_Controller;

use Yii;
use frontend\models\Navisort;

/**
 * Site controllers
 */
class SiteController extends MY_Controller
{
    /**
     * Displays homepage.
     * 导航首页
     * @return mixed
     */
    public function actionIndex()
    {
        //获取缓存组件
        $cache = Yii::$app->cache;
        //类型,,top(头条，默认),shehui(社会),guonei(国内),guoji(国际),yule(娱乐),tiyu(体育)junshi(军事),keji(科技),caijing(财经),shishang(时尚)
        
        $news = $cache->get('cache_data_news');
        if($news === false)
        {
            $news = $this->juhe_news();
            $cache->set('cache_data_news',$this->juhe_news(),60*60);
        }
        $shehui = $cache->get('cache_data_shehui');
        if($shehui ===false)
        {
            $shehui = $this->juhe_news('shehui');
            $cache->set('cache_data_shehui',$this->juhe_news('shehui'),60*60);
        }
        $keji = $cache->get('cache_data_keji');
        if($keji === false )
        {
            $keji = $this->juhe_news('keji');
            $cache->set('cache_data_keji',$this->juhe_news('keji'),60*60);
        }
        $tiyu = $cache->get('cache_data_tiyu');
        if($tiyu === false)
        {
            $tiyu = $this->juhe_news('tiyu');
            $cache->set('cache_data_tiyu',$this->juhe_news('tiyu'),60*60);
        }
        $yule = $cache->get('cache_data_yule');
        if($yule === false)
        {
            $yule = $this->juhe_news('yule');
            $cache->set('cache_data_yule',$this->juhe_news('yule'),60*60);
        }

        $chetime = $cache->get('cache_data_session_date'); //取出缓存时间
        $oldtime = strtotime(date('Y-m-d',$chetime));  //缓存时间
        $now = strtotime(date('Y-m-d'));                //当前时间
        if($now > $oldtime)  //判断当前时间大于缓存时间则更新数据
        {
            //echo '更新缓存数据！';
            $today = $this->juhe_date(date('Y-n-j',time()));
            $cache->set('cache_data_today',$this->juhe_date(date('Y-n-j',time())),60*60*24);
            $cache->set('cache_data_session_date',time());
        }else{
            $today = $cache->get('cache_data_today');  //缓存数据
        }
        $data = $cache->get('cache_data_zset');
        $common = $cache->get('cache_data_common');
        $jobs = $cache->get('cache_data_jobs');
        if ($data === false) {
            $common = $this->shownav(1);  //常用地址
            $jobs = $this->shownav(5);    //招聘地址
            $query = Navisort::find()->joinWith('navigation');
            $result = $query->where(['status'=>1])->andWhere(['and',['>','number',0]])
                ->orderBy('sort_id desc')
                ->select(['id','name','number'])
                ->all();
            //循环取出要显示的导航分类
            foreach($result as $ky)
            {
                $zset[] = ['id'=>$ky->id,'name'=>$ky->name,'data'=>$this->shownav($ky->id)];
            }
            if(!isset($zset))
            {
                $zset = '';
            }
            $data = $zset;
            //这里我们可以操作数据库获取数据，然后通过$cache->set方法进行缓存
            $cacheData = $zset;
            //set方法的第一个参数是我们的数据对应的key值，方便我们获取到
            //第二个参数即是我们要缓存的数据
            //第三个参数是缓存时间，如果是0，意味着永久缓存。默认是0
            $cache->set('cache_data_zset', $cacheData,3600*24);
            $cache->set('cache_data_common', $common,3600*24);
            $cache->set('cache_data_jobs', $jobs,3600*24);
        }
        return $this->render('index',[
            'common' => $common,
            'jobs' => $jobs,
            'zset' => $data,
            'news' => $news,
            'shehui' => $shehui,
            'keji' => $keji,
            'tiyu' => $tiyu,
            'yule' => $yule,
            'today' => $today,
        ]);
    }
    public function actionForum()
    {
        return $this->render('forum');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}

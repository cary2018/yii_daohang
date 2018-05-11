<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
error_reporting(0); //抑制所有错误信息

$s_time = date("Y年m月d日 H:i:s")." &nbsp;星期" . mb_substr( "日一二三四五六",date("w"),1,"utf-8" );  //输入时间格式

//ajax调用实时刷新
if ($_GET['act'] == "rt")
{
    $arr=array('s_time'=>"$s_time");
    $j_arr=json_encode($arr);
    echo $_GET['callback'],'(',$j_arr,')';
    exit;
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::cssFile('@web/css/style.css?'.uniqid()); ?>
    <?=Html::jsFile('@web/js/jquery-1.9.1.min.js')?>
    <script type="text/javascript">
        <!--
        $(document).ready(function(){getJSONData();});
        function getJSONData()
        {
            setTimeout("getJSONData()", 1000);
            $.getJSON('?act=rt&callback=?', displayData);
        }
        function displayData(dataJSON)
        {
            $("#s_time").html(dataJSON.s_time);
        }
        -->
    </script>
</head>
<body>

<?=Html::jsFile('@web/js/public.js?'.uniqid()); ?>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '网站首页',
        'brandUrl' => '',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    ?>
    <div id="showtimes" class="cstime">
        <span id="s_time"><?php echo $s_time;?></span>
    </div>
    <?php
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
        ['label' => '社区', 'url' => ['/site/forum']],
        ['label' => '关于', 'url' => ['/site/about']],
        ['label' => '留言板', 'url' => ['/contact/index']],
        //['label' => '联系', 'url' => ['/site/contact']],
        ['label' => '购物', 'url' => ['/goods/index']],
    ];
    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
        //$menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '退出 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1260651519'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1260651519%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
    </div>
</footer>


<div id="J_sidebar" class="fl_right">
    <div class="fl_top"><a id="js_backtop" href="javascript:;" style="display:none;">回到顶部</a></div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

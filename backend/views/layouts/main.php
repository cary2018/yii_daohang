<?php
/**
 *
 * author Cary
 * contact QQ : 373889161($S$-memory)
 *
 */
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
$this->title='后台管理系统';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?=Html::cssFile('@web/css/site.css?'.uniqid())?>
    <!--[if lt IE 9]>
    <?=Html::jsFile('@web/js/html5.js')?>
    <![endif]-->
    <?=Html::jsFile('@web/js/jquery.js')?>
    <?=Html::jsFile('@web/js/jquery.mCustomScrollbar.concat.min.js')?>
    <script>
        (function($){
            $(window).load(function(){

                $("a[rel='load-content']").click(function(e){
                    e.preventDefault();
                    var url=$(this).attr("href");
                    $.get(url,function(data){
                        $(".content .mCSB_container").append(data); //load new content inside .mCSB_container
                        //scroll-to appended content
                        $(".content").mCustomScrollbar("scrollTo","h2:last");
                    });
                });

                $(".content").delegate("a[href='top']","click",function(e){
                    e.preventDefault();
                    $(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
                });

            });
        })(jQuery);
    </script>
    <?=Html::jsFile('@web/js/public.js');?>
</head>
<body>
<?php $this->beginBody() ?>
<!--header-->
<header>
    <h1><img src=""/></h1>
    <ul class="rt_nav">
        <li><a href="http://www.dev.com/site/flush" target="_blank" class="website_icon">清理缓存</a></li>
        <li><a href="http://www.dev.com" target="_blank" class="website_icon">站点首页</a></li>
        <li><a href="#" class="admin_icon">
                <?php
                if(\Helpers::resession('SESSION_NAME')){
                    echo \Helpers::resession('SESSION_NAME')->username;
                }
                ?>
            </a></li>
        <li><a href="#" class="set_icon">账号设置</a></li>
        <li><a href="/index/log_ut" class="quit_icon">安全退出</a></li>
    </ul>
</header>

<!--aside nav-->
<aside class="lt_aside_nav content mCustomScrollbar">
    <h2><a href="/">起始页</a></h2>
    <ul>
        <li>
            <dl>
                <dt>导航管理</dt>
                <!--当前链接则添加class:active-->
                <dd><a href="/navigation/index" class="active">导航列表</a></dd>
                <dd><a href="/navigation/sort">导航分类</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>文章管理</dt>
                <dd><a href="/article/index">文章列表</a></dd>
                <dd><a href="/sort/index">文章分类</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>管理员用户</dt>
                <dd><a href="/admin/index">管理员列表</a></dd>
                <dd><a href="/contact/index">留言板</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>商品管理</dt>
                <dd><a href="/goods/index">商品列表</a></dd>
                <dd><a href="/category/index">商品分类</a></dd>
                <dd><a href="/goods/channel">商品渠道</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>测试</dt>
                <dd><a href="/test/index">测试页面</a></dd>
                <dd><a href="/admin/login">管理员登录</a></dd>
                <dd><a href="/site/login">会员登录</a></dd>
                <dd><a href="/site/logout">会员退出</a></dd>
            </dl>
        </li>
        <li>
            <p class="btm_infor">©Cary 版权所有</p>
        </li>
    </ul>
</aside>

<section class="rt_wrap content mCustomScrollbar">
    <div class="rt_content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
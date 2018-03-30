<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '上网导航';
?>

<div class="w_ap">
    <!-----------------------搜索开始----------------------------------->
    <div class="head">
        <form onsubmit="return gowhere1(this)" target="_blank" name="search_form1" method="get" action="http://www.baidu.com/baidu">
            <table width="100%" height="80" cellspacing="0" cellpadding="0" border="0" style="font-family:宋体">
                <tbody>
                <tr>
                    <td>
                        <table width="100%" height="80" cellspacing="0" cellpadding="0" border="0">
                            <input type="hidden" value="0" name="myselectvalue">
                            <input type="hidden" value="utf-8" name="ie">
                            <input type="hidden" name="tn" value="SE_zzsearchcode_shhzc78w">
                            <input type="hidden" name="ct">
                            <input type="hidden" name="lm">
                            <input type="hidden" name="cl">
                            <input type="hidden" name="rn">
                            <tbody>
                            <tr>
                                <td width="8%" valign="bottom">
                                    <div align="center" class="sch_logo">
                                        <a href="https://www.baidu.com/"  target="_blank">
                                            <img border="0" align="bottom" alt="Baidu" src="https://www.baidu.com/img/baidu_jgylogo3.gif">
                                        </a>
                                    </div>
                                </td>
                                <td width="92%" valign="bottom">

                                    <label color="#0000cc"> <input type="radio" value="0" onclick="javascript:this.form.myselectvalue.value=4;" name="myselect">
                                        <font color="#0000cc">新闻</font></label>

                                    <label class="f12"><input type="radio" value="0" onclick="javascript:this.form.myselectvalue.value=0;" name="myselect" checked="">
                                        <font color="#0000cc">网页</font></label>

                                    <label class="f12"><input type="radio" value="1" onclick="javascript:this.form.myselectvalue.value=1;" name="myselect">
                                        <font color="#0000cc">音乐</font></label>

                                    <label color="#0000cc"><input type="radio" value="0" onclick="javascript:this.form.myselectvalue.value=6;" name="myselect">
                                        <font color="#0000cc">贴吧</font></label>

                                    <label color="#0000cc"><input type="radio" value="0" onclick="javascript:this.form.myselectvalue.value=5;" name="myselect">
                                        <font color="#0000cc">图片</font></label>

                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="right">
                                        <tbody>
                                        <tr>
                                            <td style="padding-top:10px;">
                                                <span class="sch_inbox" id="J_schInbox">
                                                    <input id="word" type="text" name="word" size="40" onfocus="checkHttps">
                                                </span>
                                                <input class="sch_btn" type="submit" value="百度一下">
                                            </td>
                                            <td><br></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="8%"></td>
                                <td width="92%"></td>
                            </tr>
                            <tr><td></td></tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        <script src="http://s1.bdstatic.com/r/www/cache/global/js/BaiduHttps_20150714_zhanzhang.js"></script>
    </div>
    <!-----------------------搜索结束----------------------------------->
    <div class="blank"></div>

    <div class="left f_l">
        <?php if($common){ ?>
            <div class="mode f_l bode padd">
                <ul class="dlist">
                    <?php foreach ($common as $nav): ?>
                        <li><a href="<?= $nav->nav_url ?>" <?php if($nav->is_target){ ?>target="_blank"<?php }?> ><?= $nav->nav_name ?></a>
                            <?php if($nav->sun_name){ ?>
                                &nbsp;•&nbsp;
                                <a href="<?= $nav->sun_url ?>" target="_blank" ><?= $nav->sun_name ?></a>
                            <?php }?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php } ?>
        <div class="blank f_l"></div>
        <?php if($jobs){ ?>
            <div class="mode f_l">
                <ul class="htitle f_l">
                    <?php foreach ($jobs as $nav): ?>
                        <li>
                            <a href="<?= $nav->nav_url ?>" <?php if($nav->is_target){ ?>target="_blank"<?php }?> ><?= $nav->nav_name ?></a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php } ?>
        <div class="blank f_l"></div>
        <?php if(!empty($zset)){?>
            <?php foreach ($zset as $navy): ?>
                <div><?= $navy['name'] ?></div>
                <div class="mode f_l padd">
                    <ul class="dlist f_l">
                        <?php foreach ($navy['data'] as $nav): ?>
                            <li><a href="<?= $nav['nav_url'] ?>" <?php if($nav['is_target']){ ?>target="_blank"<?php }?> ><?= $nav['nav_name'] ?></a>
                                <?php if($nav['sun_name']){ ?>
                                    &nbsp;•&nbsp;
                                    <a href="<?= $nav['sun_url'] ?>" target="_blank" ><?= $nav['sun_name'] ?></a>
                                <?php }?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="blank f_l"></div>
            <?php endforeach; ?>
        <?php }?>
    </div>
    <div class="right f_l">
        <?php
        if($today){
            if($today['error_code']=='0'){
                foreach($today['result'] as $ke=>$va)
                {
                    if(is_array($va))
                    { ?>
                        <div class="almanac-hd" id="info_all"><h3><?=date('Y',time())?>年 <?=date('m',time())?>月<?=date('d',time())?>日  <?=$va['weekday']?></h3></div>
                        <div class="alm_content nofestival">
                            <div class="today_icon"></div>
                            <div class="today_date"><?=date('d',time())?></div>
                            <p>农历<?=$va['lunar']?></p>
                            <p><?=$va['lunarYear']?></p>
                            <p>【<?=$va['animalsYear']?>年】</p>
                            <?php if(isset($va['holiday'])){?>
                                <div class="alm_lunar_date"></div>
                            <?php }?>
                            <div class="yj_box">
                                <div class="yi" title="<?=$va['suit']?>"><span style="font-size: 25px;"><b>宜 : </b></span><?=$va['suit']?></div>
                                <div class="ji" title="<?=$va['avoid']?>"><span style="font-size: 25px;"><b>忌 : </b></span><?=$va['avoid']?></div>
                            </div>
                        </div>
                    <?php }
                }
            }else{
                echo $today['error_code'].":".$today['reason'];
            }
        }else{
            echo "请求失败";
        }
        ?>
        <div class="title"><h1>新闻头条</h1></div>
        <ul class="rlist">
            <?php
            if($news){
                if($news['error_code']=='0'){
                    $i=1;
                    foreach($news['result']['data'] as $ke=>$va)
                    {
                        if($i <= 10)
                        {
                            if(is_array($va))
                            {
                                $i++;
                                ?>
                                <li><a tj="yxw_1_1" target="_blank" class="fred" href="<?= $va['url'] ?>"
                                       title="<?= $va['title'] ?>" name="2"><?= $va['title'] ?></a></li>
                                <?php
                            }
                        }
                    }
                }else{
                    echo $news['error_code'].":".$news['reason'];
                }
            }else{
                echo "请求失败";
            }
            ?>
        </ul>
        <div class="blank"></div>

        <div id="tabs">
            <ul>
                <li class="on">社会</li>
                <li>科技</li>
                <li>体育</li>
                <li>娱乐</li>
            </ul>
            <div>
                <?php
                if($shehui){
                    if($shehui['error_code']=='0'){
                        $i=1;
                        foreach($shehui['result']['data'] as $ke=>$va)
                        {
                            if($i <= 10)
                            {
                                if(is_array($va))
                                {
                                    $i++;
                                    ?>
                                    <li><a tj="yxw_1_1" target="_blank" class="fred" href="<?= $va['url'] ?>"
                                           title="<?= $va['title'] ?>" name="2"><?= $va['title'] ?></a></li>
                                    <?php
                                }
                            }
                        }
                    }else{
                        echo $shehui['error_code'].":".$shehui['reason'];
                    }
                }else{
                    echo "请求失败";
                }
                ?>
            </div>
            <div class="hide">
                <?php
                if($keji){
                    if($keji['error_code']=='0'){
                        $i=1;
                        foreach($keji['result']['data'] as $ke=>$va)
                        {
                            if($i <= 10)
                            {
                                if(is_array($va))
                                {
                                    $i++;
                                    ?>
                                    <li><a tj="yxw_1_1" target="_blank" class="fred" href="<?= $va['url'] ?>"
                                           title="<?= $va['title'] ?>" name="2"><?= $va['title'] ?></a></li>
                                    <?php
                                }
                            }
                        }
                    }else{
                        echo $keji['error_code'].":".$keji['reason'];
                    }
                }else{
                    echo "请求失败";
                }
                ?>
            </div>
            <div class="hide">
                <?php
                if($tiyu){
                    if($tiyu['error_code']=='0'){
                        $i=1;
                        foreach($tiyu['result']['data'] as $ke=>$va)
                        {
                            if($i <= 10)
                            {
                                if(is_array($va))
                                {
                                    $i++;
                                    ?>
                                    <li><a tj="yxw_1_1" target="_blank" class="fred" href="<?= $va['url'] ?>"
                                           title="<?= $va['title'] ?>" name="2"><?= $va['title'] ?></a></li>
                                    <?php
                                }
                            }
                        }
                    }else{
                        echo $tiyu['error_code'].":".$tiyu['reason'];
                    }
                }else{
                    echo "请求失败";
                }
                ?>
            </div>
            <div class="hide">
                <?php
                if($yule){
                    if($yule['error_code']=='0'){
                        $i=1;
                        foreach($yule['result']['data'] as $ke=>$va)
                        {
                            if($i <= 10)
                            {
                                if(is_array($va))
                                {
                                    $i++;
                                    ?>
                                    <li><a tj="yxw_1_1" target="_blank" class="fred" href="<?= $va['url'] ?>"
                                           title="<?= $va['title'] ?>" name="2"><?= $va['title'] ?></a></li>
                                    <?php
                                }
                            }
                        }
                    }else{
                        echo $yule['error_code'].":".$yule['reason'];
                    }
                }else{
                    echo "请求失败";
                }
                ?>
            </div>
        </div>

    </div>

</div>

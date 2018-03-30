<div class="goods_logo">
    <div class="headw">
        <a class="head-logo"><img src="../images/logo.png"></a>
        <form action="search" method="get">
            <div class="input-group clearfix" p-id="120">
                <div class="input-group-input" p-id="121">
                    <input type="text" autofocus="true" class="search-inp input" name="q" id="q" value="<?= isset($_GET['q']) ? $_GET['q']:'' ?>" placeholder="请输入您要搜索的商品名称" autocomplete="off" bx-name="app/exts/suggest/index" p-id="122">
                    <div class="suggest dropdown" style="display: none; top: 220px; left: 1414px;">
                        <ul class="dropdown-menu"></ul>
                    </div><!--deleted-124-->
                </div><!--deleted-125-->
                <div class="input-group-btn" p-id="126">
                    <button class="btn-brand search-btn" mx-click="search()" data-spm-click="gostr=/alimama.11;locaid=d74fa6fa1" p-id="127" data-spm-anchor-id="a219t.7900221/10.1998910419.d74fa6fa1">搜索</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="goods_menu">
    <ul>
        <li class="<?= $select == 1 ? 'sel_check':''?> first"><a href="shop">首页</a></li>
        <li class="<?= $select == 2 ? 'sel_check':''?>"><a href="">品牌折扣</a></li>
        <li class="<?= $select == 3 ? 'sel_check':''?>"><a href="">特卖精选</a></li>
        <li class="<?= $select == 4 ? 'sel_check':''?>"><a href="jiukj">9.9包邮</a></li>
        <li class="<?= $select == 5 ? 'sel_check':''?>"><a href="ershi">20元封顶</a></li>
        <li class="<?= $select == 6 ? 'sel_check':''?>"><a href="">特价好货</a></li>
    </ul>
</div>
<?php
/* @var $this \yii\web\View */

use backend\assets\ResultAsset;

ResultAsset::register($this);
?>
<script src="/search/js/jquery.js" type="text/javascript"></script>

<div id="container">
	<div id="hd" class="ue-clear">
    	<a href="/"><div class="logo"></div></a>
        <div class="inputArea">
        	<input type="text" class="searchInput" value="<?= $allHits['search_word'] ?>"/>
            <input type="button" class="searchButton" onclick="add_search()"/>
            <ul class="dataList">
            </ul>
        </div>
    </div>
    <div class="nav">
    	<ul class="searchList">
            <li class="searchItem current" data-type="job">职位</li>
        </ul>
    </div>
	<div id="bd" class="ue-clear">
        <div id="main">
        	<div class="sideBar">

                <div class="subfield">网站</div>
                <ul class="subfieldContext">
                    <li>
                    	<span class="name">拉勾网</span>
						<span class="unit">(<?= $lagou ?>)</span>
                    </li>
                    <li>
                    	<span class="name">中华英才网</span>
						<span class="unit">(<?= $yingcai ?>)</span>
                    </li>
                </ul>


                <div class="sideBarShowHide">
                	<a href="javascript:;" class="icon"></a>
                </div>
            </div>
            <div class="resultArea">
            	<p class="resultTotal">
                	<span class="info">找到约&nbsp;<span class="totalResult"> <?= $allHits['total']?></span>&nbsp;条结果(用时<span class="time"><?= $allHits['time']?></span>秒)，共约<span class="totalPage">10</span>页</span>
                </p>
                <div class="resultList">
                    <?php foreach ($allHits as $hit): ?>
                        <?php if(!is_array($hit)) continue;?>
                        <div class="resultItem">
                            <div class="itemHead">
                                <?php
                                ?>
                                <a href="<?= $hit['url'] ?>"  target="_blank" class="title"><?php echo $hit['title']?></a>
                                <span class="divsion">-</span>
                                <span class="fileType">
                                    <span class="value"><?= Yii::$app->getFormatter()->asRelativeTime($hit['release_time'])?></span>
                                </span>
                                <span class="divsion">-</span>
                                <span class="fileType">
                                    <span class="label">来源：</span>
                                    <span class="value"><?= $hit['website'] ?></span>
                                </span>
                                <span class="dependValue">
                                    <span class="label">得分：</span>
                                    <span class="value"><?= $hit['score'] ?></span>
                                </span>
                            </div>
                            <div class="itemBody">
                                <?= $hit['job_desc'] ?>
                            </div>
                            <div class="itemFoot">
                                <span class="info">
                                    <label>网站：</label>
                                    <span class="value"><?= $hit['website'] ?></span>
                                </span>
                                <span class="info">
                                    <label>发布时间：</label>
                                    <span class="value"><?= $hit['release_time']?></span>
                                </span>
                            </div>
                        </div>
                    <?php endforeach;?>

                </div>
                <!-- 分页 -->
                <div class="pagination ue-clear"></div>
                <!-- 相关搜索 -->



            </div>
            <div class="historyArea">
            	<div class="hotSearch">
                	<h6>热门搜索</h6>
                    <ul class="historyList">
                        <!--                        {% for search_word in topn_search %}-->

                        <?php foreach($top_search as $search):?>
                            <li><a href="/search/result?q=<?=$search?>"><?=$search?></a></li>
                        <?php endforeach;?>
<!--                        TODO-->
<!--                        {% endfor %}-->
                    </ul>
                </div>
                <div class="mySearch">
                	<h6>我的搜索</h6>
                    <ul class="historyList">

                    </ul>
                </div>
            </div>
        </div><!-- End of main -->
    </div><!--End of bd-->
</div>
<div id="foot">Copyright &copy;projectsedu.com 版权所有  E-mail:admin@projectsedu.com</div>

<script src="/search/js/global.js" type="text/javascript"></script>
<script src="/search/js/pagination.js" type="text/javascript"></script>
<script type="text/javascript">
    var search_url = "/search/result"
    var suggest_url = "/search/zhiwei"

    $('.searchList').on('click', '.searchItem', function(){
        $('.searchList .searchItem').removeClass('current');
        $(this).addClass('current');
    });

    $.each($('.subfieldContext'), function(i, item){
        $(this).find('li:gt(2)').hide().end().find('li:last').show();
    });

    function removeByValue(arr, val) {
        for(var i=0; i<arr.length; i++) {
            if(arr[i] == val) {
                arr.splice(i, 1);
                break;
            }
        }
    }
    $('.subfieldContext .more').click(function(e){
        var $more = $(this).parent('.subfieldContext').find('.more');
        if($more.hasClass('show')){

            if($(this).hasClass('define')){
                $(this).parent('.subfieldContext').find('.more').removeClass('show').find('.text').text('自定义');
            }else{
                $(this).parent('.subfieldContext').find('.more').removeClass('show').find('.text').text('更多');
            }
            $(this).parent('.subfieldContext').find('li:gt(2)').hide().end().find('li:last').show();
        }else{
            $(this).parent('.subfieldContext').find('.more').addClass('show').find('.text').text('收起');
            $(this).parent('.subfieldContext').find('li:gt(2)').show();
        }

    });

    $('.sideBarShowHide a').click(function(e) {
        if($('#main').hasClass('sideBarHide')){
            $('#main').removeClass('sideBarHide');
            $('#container').removeClass('sideBarHide');
        }else{
            $('#main').addClass('sideBarHide');
            $('#container').addClass('sideBarHide');
        }

    });
    var key_words = "<?= $allHits['search_word'] ?>"
    //分页
    $(".pagination").pagination(<?=$allHits['total']?>, {
        current_page :<?= $allHits['page']-1?>, //当前页码
        items_per_page :10,
            display_msg :true,
            callback :pageselectCallback
    });
    function pageselectCallback(page_id, jq) {
        window.location.href=search_url+'?q='+key_words+'&p='+(page_id+1)
    }

    setHeight();
    $(window).resize(function(){
        setHeight();
    });

    function setHeight(){
        if($('#container').outerHeight() < $(window).height()){
            $('#container').height($(window).height()-33);
        }
    }
    $('.searchList').on('click', '.searchItem', function(){
        $('.searchList .searchItem').removeClass('current');
        $(this).addClass('current');
    });

    // 联想下拉显示隐藏
    $('.searchInput').on('focus', function(){
        $('.dataList').show()
    });

    // 搜索建议
    $('.searchInput').bind(' input propertychange ',function(){
        var searchText = $(this).val();
        console.log(searchText)
        var tmpHtml = ""
        $.ajax({
            cache: false,
            type: 'get',
            dataType:'json',
            url:suggest_url+"?s="+searchText+"&s_type="+$(".searchItem.current").attr('data-type'),
            async: true,
            success: function(data) {
                if(data == null) {
                    console.log("返回值应为数组")
                    return;
                }
                for (var i=0;i<data.length;i++){
                    tmpHtml += '<li><a href="'+search_url+'?q='+data[i]+'">'+data[i]+'</a></li>'
                }
                $(".dataList").html("")
                $(".dataList").append(tmpHtml);
                if (data.length == 0){
                    $('.dataList').hide()
                }else {
                    $('.dataList').show()
                }
            }
        });
    } );

    // 联想下拉点击
    $('.dataList').on('click', 'li', function(){
        var text = $(this).text();
        $('.searchInput').val(text);
        $('.dataList').hide()
    });

    hideElement($('.dataList'), $('.searchInput'));
</script>
<script>
    var searchArr;
    //定义一个search的，判断浏览器有无数据存储（搜索历史）
    if(localStorage.search){
        //如果有，转换成 数组的形式存放到searchArr的数组里（localStorage以字符串的形式存储，所以要把它转换成数组的形式）
        searchArr= localStorage.search.split(",")
    }else{
        //如果没有，则定义searchArr为一个空的数组
        searchArr = [];
    }
    //把存储的数据显示出来作为搜索历史
    MapSearchArr();

    function add_search(){
        var val = $(".searchInput").val();
        if (val.length>=2){
            //点击搜索按钮时，去重
            KillRepeat(val);
            //去重后把数组存储到浏览器localStorage
            localStorage.search = searchArr;
            //然后再把搜索内容显示出来
            MapSearchArr();
        }

        window.location.href=search_url+'?q='+val+"&s_type="+$(".searchItem.current").attr('data-type')

    }

    function MapSearchArr(){
        var tmpHtml = "";
        var arrLen = 0
        if (searchArr.length > 6){
            arrLen = 6
        }else {
            arrLen = searchArr.length
        }
        for (var i=0;i<arrLen;i++){
            tmpHtml += '<li><a href="/search?q='+searchArr[i]+'">'+searchArr[i]+'</a></li>'
        }
        $(".mySearch .historyList").append(tmpHtml);
    }
    //去重
    function KillRepeat(val){
        var kill = 0;
        for (var i=0;i<searchArr.length;i++){
            if(val===searchArr[i]){
                kill ++;
            }
        }
        if(kill<1){
            searchArr.unshift(val);
        }else {
            removeByValue(searchArr, val)
            searchArr.unshift(val)
        }
    }
</script>
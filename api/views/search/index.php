<?php
/* @var $this \yii\web\View */
\backend\assets\SearchAsset::addStyle($this, '/search/css/index.css');
?>
<div id="container">
    <div id="bd">
        <div id="main">
            <h1 class="title">
                <div class="logo large"></div>
            </h1>
            <div class="nav ue-clear">
                <ul class="searchList">
                </ul>
            </div>
            <div class="inputArea">
                <input type="text" class="searchInput" />
                <input type="button" class="searchButton" onclick="add_search()" />
                <ul class="dataList">
                    <li>如何学好设计</li>
                    <li>界面设计</li>
                    <li>UI设计培训要多少钱</li>
                    <li>设计师学习</li>
                    <li>哪里有好的网站</li>
                </ul>
            </div>

            <div class="historyArea">
                <p class="history">
                    <label>热门搜索：</label>

                </p>
                <p class="history mysearch">
                    <label>我的搜索：</label>
                    <span class="all-search">
                        <a href="javascript:void(0);">专注界面设计网站</a>
                        <a href="javascript:void(0);">用户体验</a>
                        <a href="javascript:void(0);">互联网</a>
                        <a href="javascript:void(0);">资费套餐</a>
                    </span>

                </p>
            </div>
        </div><!-- End of main -->
    </div><!--End of bd-->

    <div class="foot">
        <div class="wrap">
            <div class="copyright">Copyright &copy;uimaker.com 版权所有  E-mail:admin@uimaker.com</div>
        </div>
    </div>
</div>
<?php $this->registerJs(<<<JS
// TODO
    var suggest_url = "search/zhiwei"
    var search_url = "search/result"


    $('.searchList').on('click', '.searchItem', function(){
        $('.searchList .searchItem').removeClass('current');
        $(this).addClass('current');
    });

    function removeByValue(arr, val) {
        for(var i=0; i<arr.length; i++) {
            if(arr[i] == val) {
                arr.splice(i, 1);
                break;
            }
        }
    }


    // 搜索建议
    $(function(){
        $('.searchInput').bind(' input propertychange ',function(){
            var searchText = $(this).val();
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
    })

    hideElement($('.dataList'), $('.searchInput'));
JS
);
?>

<script type="text/javascript">
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

    function MapSearchArr(){
        var tmpHtml = "";
        var arrLen = 0
        if (searchArr.length >= 5){
            arrLen = 5
        }else {
            arrLen = searchArr.length
        }
        for (var i=0;i<arrLen;i++){
            tmpHtml += '<a href="'+search_url+'?q='+searchArr[i]+'">'+searchArr[i]+'</a>'
        }
        $(".mysearch .all-search").html(tmpHtml);
    }
</script>

<?php $this->registerJs(<<<JS
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
        if (searchArr.length >= 5){
            arrLen = 5
        }else {
            arrLen = searchArr.length
        }
        for (var i=0;i<arrLen;i++){
            tmpHtml += '<a href="'+search_url+'?q='+searchArr[i]+'">'+searchArr[i]+'</a>'
        }
        $(".mysearch .all-search").html(tmpHtml);
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
JS
);
?>


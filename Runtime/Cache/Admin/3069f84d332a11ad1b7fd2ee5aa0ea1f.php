<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|OneThink管理平台</title>
    <link href="/yitu/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/yitu/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/yitu/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/yitu/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/yitu/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/yitu/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/yitu/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/yitu/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/yitu/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <?php $__base_menu__ = $__controller__->getMenus(); ?>
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__base_menu__["main"])): $i = 0; $__LIST__ = $__base_menu__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
    

        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
	<script type="text/javascript" src="/yitu/Public/static/uploadify/jquery.uploadify.min.js"></script>
	<div class="main-title cf">
        <h2><?php if(ACTION_NAME == 'add'): ?>新增车辆<?php else: ?>编辑车辆<?php endif; ?></h2>
	</div>
	<!-- 标签页导航 -->
<div class="tab-wrap">
	<div class="tab-content">
	<!-- 表单 -->
	<form id="form" action="<?php echo U('add');?>" method="post" class="form-horizontal">
		<!-- 基础文档模型 -->
        <div class="form-item cf">
            <label class="item-label">车辆图片</label>
            <div class="controls">
                <input type="file" id="upload_picture_cover_id">
                <input type="hidden" name="car_photo" id="cover_id_cover_id"/>
                <div class="upload-img-box">
                    <?php if(!empty($data[$field['name']])): ?><div class="upload-pre-item"><img src="<?php echo (get_cover($data[$field['name']],'path')); ?>"/></div><?php endif; ?>
                </div>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">车名<span class="check-tips">（卡罗拉）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="car_title" value="">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">车牌<span class="check-tips">（川A99999）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="car_licence" value="">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">归属</label>
            <div class="controls">
                <label class="radio">
                    <input type="radio" value="1" checked name="car_ownership">公司
                </label>
                <label class="radio">
                    <input type="radio" value="2" name="car_ownership">外调
                </label>
            </div>
        </div>
        <div class="form-item">
            <input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>">
            <button class="btn submit-btn" data-type="form-submit" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
	</form>
	</div>
</div>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.onethink.cn" target="_blank">OneThink</a>管理平台</div>
                <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "/yitu", //当前网站地址
            "APP"    : "/yitu/index.php?s=", //当前项目地址
            "PUBLIC" : "/yitu/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/yitu/Public/static/think.js"></script>
    <script type="text/javascript" src="/yitu/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(".html", "")
                .replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)/, "");
            $subnav.find("a[href^='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
    <script type="text/javascript">
        //导航高亮
        $('.side-sub-menu').find('a[href="<?php echo U('Car/index');?>"]').closest('li').addClass('current');

        var file=""
        $('#upload_picture_cover_id').change(function (e) {
            if(typeof (file)!='string'){
                $('.post-img').remove()
            }
            file=e.target.files[0];
            console.log(file)
            var _this = $(this);
            var reader = new FileReader();
            //读取File对象的数据
            reader.onload = function(evt){
                //data:img base64 编码数据显示
                var dom='<div class="post-img no-dash" style="position: relative;width: 15%">'
                    +'<div class="img-zoo img-box">'
                    +'<img src="'+evt.target.result+'"/>'
                    +'</div>'
                    +'<div class="del" style="color: red;width: 20px;position: absolute;top: 0;right: 0">'
                    +'✖'
                    +'</div>'
                    +'</div>'
                $('#upload_picture_cover_id').after(dom)


            }
            reader.readAsDataURL(file);
        })

        $('#submit').click(function () {
            var fd = new FormData();
            fd.append('file',file);
            fd.append('car_title',$("input[name='car_title']").val());
            fd.append('car_licence',$("input[name='car_licence']").val());
            fd.append('car_ownership',$("input[name='car_ownership']").val());
            $.ajax({
                url: $('#form').attr('action'),
                aysnc: true ,
                type: "POST" , // 默认使用POST方式
                dataType:'json',
                timeout:4000,
                data: fd,
                contentType : false,
                processData : false,
                cache : false,
                success: function(res, textStatus, jqXHR){

                    if (res.status==1) {
                        if (res.url) {
                            updateAlert(res.info + ' 页面即将自动跳转~','alert-success');
                        }else{
                            updateAlert(res.info ,'alert-success');
                        }
                        setTimeout(function(){
                            if (res.url) {
                                location.href=res.url;
                            }else if( $(that).hasClass('no-refresh')){
                                $('#top-alert').find('button').click();
                                $(that).removeClass('disabled').prop('disabled',false);
                            }else{
                                location.reload();
                            }
                        },1500);
                    }else{
                        updateAlert(res.info);
                        setTimeout(function(){
                            if (res.url) {
                                location.href=res.url;
                            }else{
                                $('#top-alert').find('button').click();
                                $(that).removeClass('disabled').prop('disabled',false);
                            }
                        },1500);
                    }
                }
            })
            return false;
        })
        $('body').on('click','.del',function(){
            $('.post-img').remove()
            $('#upload_picture_cover_id').val('');
            file = '';
        })
    </script>

</body>
</html>
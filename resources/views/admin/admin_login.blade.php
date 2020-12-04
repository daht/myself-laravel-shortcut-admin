<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>登录页面</title>
    <link rel="icon" href="favicon.ico" type="image/ico">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/statics/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/statics/admin/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/statics/admin/css/style.min.css" rel="stylesheet">
    <script>var _token = "{{ csrf_token() }}";</script>
    <style>
        body {
            display: -webkit-box;
            display: flex;
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            align-items: center;
            height: 100%;
        }
        .login-box {
            display: table;
            table-layout: fixed;
            overflow: hidden;
            max-width: 700px;
        }
        .login-left {
            display: table-cell;
            position: relative;
            margin-bottom: 0;
            border-width: 0;
            padding: 45px;
        }
        .login-left .form-group:last-child {
            margin-bottom: 0px;
        }
        .login-right {
            display: table-cell;
            position: relative;
            margin-bottom: 0;
            border-width: 0;
            padding: 45px;
            width: 50%;
            max-width: 50%;
            background: #67b26f!important;
            background: -moz-linear-gradient(45deg,#67b26f 0,#4ca2cd 100%)!important;
            background: -webkit-linear-gradient(45deg,#67b26f 0,#4ca2cd 100%)!important;
            background: linear-gradient(45deg,#67b26f 0,#4ca2cd 100%)!important;
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#67b26f', endColorstr='#4ca2cd', GradientType=1 )!important;
        }
        .login-box .has-feedback.feedback-left .form-control {
            padding-left: 38px;
            padding-right: 12px;
        }
        .login-box .has-feedback.feedback-left .form-control-feedback {
            left: 0;
            right: auto;
            width: 38px;
            height: 38px;
            line-height: 38px;
            z-index: 4;
            color: #dcdcdc;
        }
        .login-box .has-feedback.feedback-left.row .form-control-feedback {
            left: 15px;
        }
        @media (max-width: 576px) {
            .login-right {
                display: none;
            }
        }
    </style>
</head>

<body style="background-image: url(/statics/admin/images/login-bg-2.jpg); background-size: cover;">
<div class="bg-translucent p-10">
    <div class="login-box bg-white clearfix">
        <div class="login-left">
            <form action="#!" method="post">
                <div class="form-group has-feedback feedback-left">
                    <input type="text" placeholder="请输入您的手机号" class="form-control" name="mobile" id="mobile" />
                    <span class="mdi mdi-account form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback feedback-left">
                    <input type="password" placeholder="请输入密码" class="form-control" id="password" name="password" />
                    <span class="mdi mdi-lock form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback feedback-left row">
                    <div class="col-xs-7">
                        <input type="text" name="captcha_code"  id="captcha_code"  class="form-control" placeholder="验证码">
                        <span class="mdi mdi-check-all form-control-feedback" aria-hidden="true"></span>
                    </div>
                    <div class="col-xs-5">
                        <img src="{{captcha_src('flat')}}" class="pull-right" id="captcha" style="cursor: pointer;height: 38px;width: 100%" onclick="this.src='/captcha/flat?'+Math.random()" title="点击刷新" alt="captcha">
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="button" id="login">立即登录</button>
                </div>
            </form>
        </div>
        <div class="login-right">
            <p><img src="/statics/admin/images/logo.png" class="m-b-md m-t-xs" alt="logo"></p>
            <p class="text-white m-tb-15">Light Year Admin 是一个基于Bootstrap v3.3.7的后台管理系统的HTML模板。</p>
            <p class="text-white">Copyright © 2020 <a href="http://lyear.itshubao.com">IT书包</a>. All right reserved</p>
        </div>
    </div>
</div>
<script type="text/javascript" src="/statics/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/statics/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/statics/layui/layui.js"></script>
<script>
    layui.use('layer', function () {
        var layer = layui.layer;
    })
</script>
<script src="/statics/common/js/ajax_function.js?time={{time()}}"></script>
<script>
    $(document).keyup(function (event) {
        if (event.keyCode == 13) {
            $("#login").trigger("click");
        }
    });
    $('#login').on('click', function () {
        ajaxPost('/admin/login', {
            'mobile': $('#mobile').val(),
            'password': $('#password').val(),
            'captcha_code': $('#captcha_code').val(),
        }, function (param, res) {
            if (res.meta.status_code == 200) {
                location.href = '/';
            }
        })
    });
</script>
</body>
</html>
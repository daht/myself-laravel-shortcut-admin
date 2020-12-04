<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <title>@yield('title')</title>
    <link rel="icon" href="favicon.ico" type="image/ico">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/statics/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/statics/admin/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/statics/admin/css/style.min.css" rel="stylesheet">
    <script type="text/javascript" src="/statics/admin/js/jquery.min.js"></script>
    <script type="text/javascript" src="/statics/layui/layui.js"></script>
    <script>var _token = "{{ csrf_token() }}";</script>
    <script>var _source = "{{request()->server("HTTP_REFERER")}}";</script>
    <script>
        layui.use('layer', function () {
            var layer = layui.layer;
        })
    </script>
</head>

<body data-headerbg="color_6" data-logobg="color_6">
<div class="lyear-layout-web">
    <div class="lyear-layout-container">
        <!--左侧导航-->
        <aside class="lyear-layout-sidebar">
            <!-- logo -->
            <div id="logo" class="sidebar-header">
                <a href="javascript:void(0)"><img src="/statics/admin/images/logo-sidebar.png" title="LightYear"
                                                  alt="LightYear"/></a>
            </div>
            <div class="lyear-layout-sidebar-scroll">
                <nav class="sidebar-main">
                    <ul class="nav nav-drawer">
                        @foreach($admin_route_list as $item)
                            <li class="nav-item nav-item-has-subnav @if(isset($item['sons']) && $item['is_active']) active  open @endif">
                                <a href="@if($item['is_url'] == 0)javascript:void(0);@else{{$item['url']}}@endif"><i
                                            class="mdi mdi-palette"></i> {{$item['name']}}</a>
                                @if(isset($item['sons']))
                                    <ul class="nav nav-subnav">
                                        @foreach($item['sons'] as $sons)
                                            <li>
                                                <a href="@if($sons['is_url'] == 0)javascript:void(0);@else{{$sons['url']}}@endif">{{$sons['name']}}</a>
                                            </li>
                                            @if(isset($sons['sons']))
                                                <ul class="nav nav-subnav">
                                                    @foreach($sons['sons'] as $son)
                                                        <li>
                                                            <a href="@if($son['is_url'] == 0)javascript:void(0);@else{{$son['url']}}@endif">{{$son['name']}}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="sidebar-footer">
                    <p class="copyright">Copyright &copy; {{date('Y')}}. <a target="_blank" href="javascript:void(0);">当贝</a>
                        All rights
                        reserved.</p>
                </div>
            </div>

        </aside>
        <!--End 左侧导航-->

        <!--头部信息-->
        <header class="lyear-layout-header">

            <nav class="navbar navbar-default">
                <div class="topbar">

                    <div class="topbar-left">
                        <div class="lyear-aside-toggler">
                            <span class="lyear-toggler-bar"></span>
                            <span class="lyear-toggler-bar"></span>
                            <span class="lyear-toggler-bar"></span>
                        </div>
                        <span class="navbar-page-title">@yield('title')</span>
                    </div>

                    <ul class="topbar-right">
                        <li class="dropdown dropdown-profile">
                            <a href="javascript:void(0)" data-toggle="dropdown">
                                <span> {{auth()->user()->name}} <span class="caret"></span></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0)"><i class="mdi mdi-delete cache_clear"></i> 清空缓存</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="/admin/logout"><i class="mdi mdi-logout-variant"></i> 退出登录</a>
                                </li>
                            </ul>
                        </li>
                        <!--切换主题配色-->
                        <li class="dropdown dropdown-skin">
                            <span data-toggle="dropdown" class="icon-palette"></span>

                        </li>
                        <!--切换主题配色-->
                    </ul>

                </div>
            </nav>

        </header>
        <!--End 头部信息-->

        <!--页面主要内容-->
        <main class="lyear-layout-content">
            <div class="container-fluid">
                <div class="panel-header">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">主页</a>
                            @foreach($active_route_list as $item)
                            <li class="breadcrumb-item"><a href="@if($item['is_url'] == 0)javascript:void(0);@else{{$item['url']}}@endif">{{$item['name']}}</a></li>
                            @endforeach
                        </ol>
                    </nav>
                </div>
                @yield('content')
            </div>
        </main>
        <!--End 页面主要内容-->
    </div>
</div>


<script type="text/javascript" src="/statics/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/statics/admin/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="/statics/admin/js/main.min.js"></script>
<script type="text/javascript" src="/statics/common/js/ajax_function.js?v={{$cache_code}}"></script>

<!--图表插件-->
<script type="text/javascript" src="/statics/admin/js/Chart.js"></script>


<script>
    $('.cache_clear').on('click', function () {
        ajaxPost('/cache/clear', {}, function (param, res) {
            if (res.meta.status_code == 200) {
                layer.msg('刷新成功', {icon: 6, time: 2000}, function () {
                    location.reload();
                });
            }
        })
    });
</script>

</body>
</html>
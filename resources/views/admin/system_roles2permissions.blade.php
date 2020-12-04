@section('title', '角色权限管理')
@extends('admin.layout')
@section('content')
    <link rel="stylesheet" href="/statics/layui/css/layui.css">
    <link rel="stylesheet" href="/statics/layui_ext/dtree/dtree.css">
    <link rel="stylesheet" href="/statics/layui_ext/dtree/font/dtreefont.css">


    <div class="panel">

        <div class="panel-body">
            <div class="form-group row">
                <label class="col-sm-3 text-right form-group-label"></label>
                <div class="col-sm-8">
                    <input name="admin_id" type="hidden">
                    <a class="btn btn-primary role2permission_update" href="javascript:">更新</a>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-group-label text-right">角色名称：</label>
                <div class="col-sm-8">{{$role['name']}}</div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-group-label text-right">角色权限：</label>
                <div class="col-sm-8" id="tree" style="list-style-type:none;"></div>
            </div>
        </div>
    </div>

    <script>
        layui.extend({
            dtree: '/statics/layui_ext/dtree/dtree'   // {/}的意思即代表采用自有路径，即不跟随 base 路径
        }).use(['dtree', 'layer', 'jquery'], function () {
            var dtree = layui.dtree, layer = layui.layer, $ = layui.jquery;
            var response = {
                statusName: "code", //返回标识（必填）
                statusCode: 200, //返回码（必填）
                message: "message", //返回信息（必填）
                rootName: "data", //根节点名称（必填）
                treeId: "admin_route_id", //节点ID（必填）
                parentId: "parent_id", //父节点ID（必填）
                title: "name", //节点名称（必填）
                iconClass: "iconClass", //自定义图标class（非必填）
                childName: "sons", //子节点名称（默认数据格式必填）
                isLast: "is_last", //是否最后一级节点（true：是，false：否，布尔值，非必填）
                level: "level", //层级（v2.4.5_finally_beta版本之后，该属性移除）
                spread: "spread", //节点展开状态（v2.4.5_finally_beta版本新增。true：展开，false：不展开，布尔值，非必填）
                disabled: "disabled", //节点禁用状态（v2.5.0版本新增。true：禁用，false：不禁用，布尔值，非必填）
                isHide: "isHide", //节点隐藏状态（v2.5.0版本新增。true：隐藏，false：不隐藏，布尔值，非必填）
                checkArr: "checkArr", //复选框列表（开启复选框必填，默认是json数组。）
                isChecked: "isChecked", //是否选中（开启复选框，0-未选中，1-选中，2-半选。非必填）
                type: "type", //复选框标记（开启复选框，从0开始。非必填）
                basicData: "basicData" //表示用户自定义需要存储在树节点中的数据（非必填）
            };

            var DemoTree = dtree.render({
                response: response,
                elem: "#tree",
                checkbarType: "all",// 默认就是all，其他的值为： no-all  p-casc   self  only
                checkbarData: "choose", // 记录选中（默认）， "change"：记录变更， "all"：记录全部， "halfChoose"："记录选中和半选（V2.5.0新增）"
                checkbar: true,//多选开启
                icon: "-1",  // 隐藏二级图标
                data:{!! $result !!},
                // nodeIconArray:{"1":{"open":"dtree-icon-pulldown","close":"dtree-icon-pullup"}},
                type: "all",//加载方式，"load"为增量加载，"all"为全量加载。
                skin: "zdy",  // layui主题风格
                initLevel: "3",//默认显示几级
                // firstIconArray: {"1":{"open":"dtree-icon-xiangxia1","close":"dtree-icon-xiangyou"}},
                // ficon: "1", // 使用
                dot: false  // 隐藏小圆点
            });
            var role_id = "{{$request->input('id')}}";
            //权限更新
            /**
             * 更新
             */
            $(".role2permission_update").click(function () {
                var params = dtree.getCheckbarNodesParam("tree");
                console.log(params);
                ajaxPost('/system/roles2permissions/update',
                    {"role_id": role_id, "permission_json": JSON.stringify(params)},
                    function (param, res) {
                        if (res.meta.status_code == 200) {
                            $("#create_modal").modal('hide');
                            layer.msg('更新成功', {icon: 6, time: 2000}, function () {
                                location.reload();
                            });
                        }
                    })
            });
        });

    </script>
@endsection

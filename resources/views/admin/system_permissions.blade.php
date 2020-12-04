@section('title', '权限列表')
@extends('admin.layout')
@section('content')
    <script src="/statics/common/js/system_permissions.js?v={{$cache_code}}"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-toolbar clearfix">
                    <div class="toolbar-btn-action">
                        @can('/system/permissions/create')
                            <a href="#" data-toggle="modal" data-target="#create_modal" class="btn btn-sm btn-primary">添加模块</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover ">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>上级id</th>
                                <th>名称</th>
                                <th>权限</th>
                                <th>权限类型</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $item)
                                <tr>
                                    <td>{{$item['admin_route_id']}}</td>
                                    <td>{{$item['parent_id']}}</td>
                                    <td>{{$item['name']}}</td>
                                    <td>{{$item['url']}}</td>
                                    <td>{{$item->is_menu_format}}</td>
                                    <td>{{$item['created_at']}}</td>
                                    <td>
                                        @can('/system/permissions/update')
                                            <a href="#" class="btn  btn-sm  btn-info update"
                                               data-admin_route_id="{{$item['admin_route_id']}}"
                                               data-parent_id="{{$item['parent_id']}}"
                                               data-name="{{$item['name']}}"
                                               data-url="{{$item['url']}}"
                                               data-sort="{{$item['sort']}}"
                                               data-method="{{$item['method']}}"
                                               data-toggle="modal"
                                            >编辑</a>
                                        @endcan
                                        @can('/system/permissions/delete')
                                            <a href="#" class="btn  btn-sm  btn-danger delete"
                                               data-admin_route_id="{{$item['admin_route_id']}}">删除</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center center-block">
        {{$result->appends([])->links()}}
        <div class="text-muted">共{{$result->total()}}条数据</div>
    </div>

    <!--添加-->
    <div class="modal fade" id="create_modal" data-backdrop="static">
        <form id="create_form" class="form-horizontal">
            <div class="card modal-dialog " role="document" style="max-width: 700px">
                <div class="card-header">
                    <h4>添加权限</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group ">
                        <label class="col-md-3 control-label">上级权限：</label>
                        <div class="col-md-7">
                            @if($parentAdminRoute)
                                <input class="form-control" type="text" value="{{$parentAdminRoute->name}}"
                                       disabled>
                                <input type="hidden" name="parent_id"
                                       value="{{$parentAdminRoute['admin_route_id']}}">
                            @else
                                <input class="form-control" value="顶级" disabled>
                                <input type="hidden" name="parent_id" value="0">
                            @endif
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label">权限名称：</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="name" placeholder="请输入权限名称">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-md-3 control-label">权限路由：</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="url" placeholder="请输入权限路由">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label">请求类型：</label>
                        <div class="col-md-7">
                            <select name="method" class="form-control">
                                <option value="1">请求接口</option>
                                <option value="0">访问页面</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label">排序：</label>
                        <div class="col-md-7">
                            <input class="form-control" value="1" type="number" name="sort" placeholder="请输入排序">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <input type="hidden" name="is_menu" value="0">
                    <button type="button" class="btn btn-primary create_btn">提交</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                </div>
            </div>
        </form>
    </div>

    <!--编辑-->
    <div class="modal fade" id="update_modal" data-backdrop="static">
        <form id="update_form" class="form-horizontal">
            <div class="card modal-dialog " role="document" style="max-width: 700px">
                <div class="card-header">
                    <h4>编辑权限</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group ">
                        <label class="col-md-3 control-label">上级权限：</label>
                        <div class="col-md-7">
                            @if($parentAdminRoute)
                                <input class="form-control" type="text" value="{{$parentAdminRoute->name}}"
                                       disabled>
                                <input type="hidden" name="parent_id"
                                       value="{{$parentAdminRoute['admin_route_id']}}">
                            @else
                                <input class="form-control" value="顶级" disabled>
                                <input type="hidden" name="parent_id" value="0">
                            @endif
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label">权限名称：</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="name" placeholder="请输入权限名称">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-md-3 control-label">权限路由：</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="url" placeholder="请输入权限路由">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label">请求类型：</label>
                        <div class="col-md-7">
                            <select name="method" class="form-control">
                                <option value="1">请求接口</option>
                                <option value="0">访问页面</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">排序：</label>
                        <div class="col-md-7">
                            <input class="form-control" value="1" type="number" name="sort" placeholder="请输入排序">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <input type="hidden" name="is_menu" value="0">
                    <input type="hidden" name="admin_route_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary update_btn">提交</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('title', '权限列表')
@extends('admin.layout')
@section('content')
    <script src="/statics/common/js/system_menu.js?v={{$cache_code}}"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-toolbar clearfix">
                    <div class="toolbar-btn-action">
                        @can('/system/permissions/create')
                            <a href="#" data-toggle="modal" data-target="#create_modal" class="btn btn-primary m-r-5"><i
                                        class="mdi mdi-plus"></i>添加导航</a>
                        @endcan

                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover ">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>名称</th>
                                <th>权限</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($menu as $item)
                                <tr>
                                    <td>{{$item['admin_route_id']}}</td>
                                    <td>{{$item['name']}}</td>
                                    <td>{{$item['url']}}</td>
                                    <td>{{$item['created_at']}}</td>
                                    <td>
                                        @if(!isset($item['sons']))
                                            @can('/system/permissions')
                                                <a href="/system/permissions?admin_route_id={{$item['admin_route_id']}}"
                                                   class="btn  btn-sm  btn-primary">模块</a>
                                            @endcan
                                        @endif
                                        @can('/system/permissions/update')
                                            <a href="#" class="btn  btn-sm  btn-info update"
                                               data-admin_route_id="{{$item['admin_route_id']}}"
                                               data-parent_id="{{$item['parent_id']}}"
                                               data-name="{{$item['name']}}"
                                               data-url="{{$item['url']}}"
                                               data-sort="{{$item['sort']}}"
                                               data-toggle="modal"
                                            >编辑</a>
                                        @endcan
                                        @can('/system/permissions/delete')
                                            <a href="#" class="btn  btn-sm  btn-danger delete"
                                               data-admin_route_id="{{$item['admin_route_id']}}">删除</a>
                                        @endcan
                                    </td>
                                </tr>
                                @if(isset($item['sons']))
                                    @foreach($item['sons'] as $son)
                                        <tr>
                                            <td>{{$son['admin_route_id']}}</td>
                                            <td> |-- {{$son['name']}}</td>
                                            <td>{{$son['url']}}</td>
                                            <td>{{$son['created_at']}}</td>
                                            <td>
                                                @can('/system/permissions')
                                                    <a href="/system/permissions?admin_route_id={{$son['admin_route_id']}}"
                                                       class="btn  btn-sm  btn-primary">模块</a>
                                                @endcan
                                                @can('/system/permissions/update')
                                                    <a href="#" class="btn  btn-sm  btn-info update"
                                                       data-admin_route_id="{{$son['admin_route_id']}}"
                                                       data-parent_id="{{$son['parent_id']}}"
                                                       data-name="{{$son['name']}}"
                                                       data-url="{{$son['url']}}"
                                                       data-sort="{{$son['sort']}}"
                                                       data-toggle="modal"
                                                    >编辑</a>
                                                @endcan
                                                @can('/system/permissions/delete')
                                                    <a href="#" class="btn  btn-sm  btn-danger delete"
                                                       data-admin_route_id="{{$son['admin_route_id']}}">删除</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 添加 -->
    <div class="modal fade" id="create_modal" data-backdrop="static">
        <div class="card modal-dialog" style="max-width: 700px">
            <div class="card-header"><h4>添加权限</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="card-body">
                <form class="form-horizontal" id="create_form" onsubmit="return false;">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-hf-email">上级权限</label>
                        <div class="col-md-7">
                            <select class="form-control select2" name="parent_id">
                                <option value="0">顶级</option>
                                @foreach($result as $item)
                                    <option value="{{$item['admin_route_id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-hf-password">权限名称</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="name" placeholder="请输入权限名称..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-hf-password">权限路由</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="url" placeholder="请输入权限路由..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-hf-password">排序</label>
                        <div class="col-md-7">
                            <input class="form-control" value="1" type="number" name="sort" placeholder="请输入排序..">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <input type="hidden" name="is_menu" value="1">
                            <input type="hidden" name="method" value="0">
                            <button type="button" class="btn btn-primary create_btn">提交</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 编辑 -->
    <div class="modal fade" id="update_modal" data-backdrop="static">
        <div class="card modal-dialog" style="max-width: 700px">
            <div class="card-header"><h4>编辑导航</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="card-body">
                <form class="form-horizontal" id="update_form" onsubmit="return false;">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-hf-email">上级权限</label>
                        <div class="col-md-7">
                            <select class="form-control select2" name="parent_id">
                                <option value="0">顶级</option>
                                @foreach($result as $item)
                                    <option value="{{$item['admin_route_id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-hf-password">权限名称</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="name" placeholder="请输入权限名称..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-hf-password">权限路由</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="url" placeholder="请输入权限路由..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-hf-password">排序</label>
                        <div class="col-md-7">
                            <input class="form-control" value="1" type="number" name="sort" placeholder="请输入排序..">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <input type="hidden" name="is_menu" value="1">
                            <input type="hidden" name="method" value="0">
                            <input type="hidden" name="admin_route_id">
                            <button type="button" class="btn btn-primary update_btn">提交</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

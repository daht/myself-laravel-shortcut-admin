@section('title', '管理员列表')
@extends('admin.layout')
@section('content')
    <!-- Select2 -->
    <script src="/statics/common/js/system_admin.js?v={{$cache_code}}"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-toolbar clearfix">
                    <div class="toolbar-btn-action">
                        @can('/system/admin/create')
                            <a href="#" data-toggle="modal" data-target="#create_modal" class="btn btn-sm btn-primary">添加管理员</a>
                        @endcan
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive ">
                    <table class="table table-bordered table-hover ">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>昵称</th>
                            <th>手机</th>
                            <th>身份</th>
                            <th>添加时间</th>
                            <th>最后登陆时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $item)
                            <tr>
                                <td>{{$item['admin_id']}}</td>
                                <td>{{$item['name']}}</td>
                                <td>{{$item['mobile']}}</td>
                                <td>@if(count($item['roles']) == 0) 无 @else {{$item['roles'][0]['name']}} @endif</td>
                                <td>{{$item['created_at']}}</td>
                                <td>{{date('Y-m-d H:i:s',$item['last_login_at'])}}</td>
                                <td>
                                    @can('/system/admin/update')
                                        <a href="#" class="btn  btn-sm  btn-info  update"
                                           data-admin_id="{{$item['admin_id']}}"
                                           data-name="{{$item['name']}}"
                                           data-mobile="{{$item['mobile']}}"
                                           data-role_id="@if(count($item['roles']) == 0){{0}}@else{{$item['roles'][0]['id']}}@endif"
                                           data-toggle="modal"
                                        >编辑</a>
                                    @endcan
                                    @can('/system/admin/delete')
                                        <a href="#" class="btn  btn-sm  btn-danger delete"
                                           data-admin_id="{{$item['admin_id']}}">删除</a>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="text-center center-block">
                {{$result->appends([])->links()}}
                <div class="text-muted">共{{$result->total()}}条数据</div>
            </div>
        </div>
    </div>

    <!--添加-->
    <div class="modal fade" id="create_modal" data-backdrop="static">
        <form id="create_form" class="form-horizontal">
            <div class="card modal-dialog" role="document" style="max-width: 700px">
                <div class="card-header">
                    <h4>添加管理员</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 control-label">管理员名称：</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="name" placeholder="请输入管理员昵称">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-md-3 control-label">管理员手机：</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="mobile" placeholder="请输入管理员手机">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-md-3 control-label">身份：</label>
                        <div class="col-md-7">
                            <select class="form-control" name="role_id">
                                <option value="0">无</option>
                                @foreach($roles as $role)
                                    <option value="{{$role['id']}}">{{$role['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-md-3 control-label">密码：</label>
                        <div class="col-md-7">
                            <input class="form-control" type="password" name="password" placeholder="">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label">确认密码：</label>
                        <div class="col-md-7">
                            <input class="form-control" type="password" name="password_confirmation" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-primary create_btn">提交</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                </div>
            </div>
        </form>
    </div>

    <!--编辑-->
    <div class="modal fade" id="update_modal" data-backdrop="static">
        <form id="update_form" class="form-horizontal">
            <div class="modal-dialog card" role="document" style="max-width: 700px">
                    <div class="card-header">
                        <h4>编辑管理员</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group ">
                            <label class="col-md-3 control-label">管理员名称：</label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="name" placeholder="请输入管理员昵称">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-md-3 control-label">管理员手机：</label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="mobile" placeholder="请输入管理员手机">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-md-3 control-label">身份：</label>
                            <div class="col-md-7">
                                <select class="form-control" name="role_id">
                                    <option value="0">无</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-md-3 control-label">管理员密码：</label>
                            <div class="col-md-7">
                                <input class="form-control" type="password" name="original_password"
                                       placeholder="操作管理员密码">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-md-3 control-label">修改密码：</label>
                            <div class="col-md-7">
                                <input class="form-control" type="password" name="password" placeholder="不修改可以不填">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-md-3 control-label">确认修改密码：</label>
                            <div class="col-md-7">
                                <input class="form-control" type="password" name="password_confirmation"
                                       placeholder="不修改可以不填">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <input type="hidden" name="admin_id">

                        <button type="button" class="btn btn-primary update_btn">提交</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    </div>
            </div>
        </form>
    </div>
@endsection

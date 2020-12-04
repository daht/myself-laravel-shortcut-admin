@section('title', '身份管理列表')
@extends('admin.layout')
@section('content')
    <!-- Select2 -->
    <script src="/statics/common/js/system_roles.js?v={{$cache_code}}"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-toolbar clearfix">
                    <h3 class="toolbar-btn-action">
                        @can('/system/roles/create')
                            <a href="#" data-toggle="modal" data-target="#create_modal" class="btn btn-sm btn-primary">添加身份</a>
                        @endcan
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive ">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>身份</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $item)
                            <tr>
                                <td>{{$item['id']}}</td>
                                <td>{{$item['name']}}</td>
                                <td>{{$item['created_at']}}</td>
                                <td>
                                    @can('/system/roles/update')
                                        <a href="#" class="btn  btn-sm  btn-info  update"
                                           data-id="{{$item['id']}}"
                                           data-name="{{$item['name']}}"
                                           data-toggle="modal"
                                        >编辑</a>
                                    @endcan
                                    @can('/system/roles2permissions')
                                        <a href="/system/roles2permissions?id={{$item['id']}}"
                                           class="btn btn-sm btn-purple ">身份权限管理</a>
                                    @endcan
                                    @can('/system/roles/delete')
                                        <a href="#" class="btn  btn-sm  btn-danger delete"
                                           data-id="{{$item['id']}}">删除</a>
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
            <div class="modal-dialog card" role="document" style="max-width: 700px">

                    <div class="card-header">
                        <h4>添加身份</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">身份名称：</label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="name" placeholder="请输入身份名称">
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
                        <h4>身份</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">身份名称：</label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="name" placeholder="请输入身份名称">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <input type="hidden" name="id">
                        <button type="button" class="btn btn-primary update_btn">提交</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    </div>
                </div>
        </form>
    </div>
@endsection

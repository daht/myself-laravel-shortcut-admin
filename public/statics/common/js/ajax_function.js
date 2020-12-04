//ajax delete request 删除
function ajaxDelete(url, data) {
    layer.confirm('确认删除吗？', {
        btn: ['确认', '取消'] //按钮
    }, function () {
        ajaxPost(url, data, function (param, res) {
            if (res.meta.status_code == 200) {
                layer.msg('删除成功', {icon: 6, time: 1000}, function () {
                    location.reload();
                });
            }
        })
    }, function () {

    });
}

//ajax patch request 部分更新
function ajaxPatch(url, data, divCallback = null, param = null) {
    data._method = "PATCH";
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': _token
        },
        success: function (res) {
            if (res.meta.status_code == 200) {
                //正常走浮层
                if (divCallback != null)
                    divCallback(param)
                $.toast({
                    content: res.meta.message,
                    callback: function () {
                        location.reload();
                    }
                });
            }
            if (res.meta.status_code != 200) {
                console.log(res.meta.message);
                //错误走弹窗
                $.alert({
                    content: res.meta.message,
                });
            }
        },
        error: function (e) {
            if (typeof (e.responseJSON) == "object") {
                if (e.responseJSON.meta.status_code != 200) {
                    if (e.responseJSON.meta.hasOwnProperty("errors")) {
                        var obj = e.responseJSON.meta.errors;
                        Object.keys(obj).forEach(function (key) {
                            $.alert({
                                content: obj[key][0],
                            });
                            throw new Error("ending");
                        });
                    } else {
                        $.alert({
                            title: '<span class="text-danger">系统错误</span>',
                            content: e.responseJSON.meta.message,
                        });
                    }
                }
            } else {
                $.alert({
                    title: '<span class="text-danger">系统错误</span>',
                    content: e.responseText,
                });
            }
        }
    });
}

//ajax put request 全部更新
function ajaxPut(url, data) {
    data._method = "PUT";
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': _token
        },
        success: function (res) {
            if (res.meta.status_code == 200) {
                //正常走浮层
                $.toast({
                    content: res.meta.message,
                    callback: function () {
                        location.reload();
                    }
                });
            }
            if (res.meta.status_code != 200) {
                //错误走弹窗
                $.alert({
                    content: res.meta.message,
                });
            }
        },
        error: function (e) {
            if (typeof (e.responseJSON) == "object") {
                if (e.responseJSON.meta.status_code != 200) {
                    if (e.responseJSON.meta.hasOwnProperty("errors")) {
                        var obj = e.responseJSON.meta.errors;
                        Object.keys(obj).forEach(function (key) {
                            $.alert({
                                content: obj[key][0],
                            });
                            throw new Error("ending");
                        });
                    } else {
                        $.alert({
                            title: '<span class="text-danger">系统错误</span>',
                            content: e.responseJSON.meta.message,
                        });
                    }
                }
            } else {
                $.alert({
                    title: '<span class="text-danger">系统错误</span>',
                    content: e.responseText,
                });
            }
        }
    });
}

//ajax put request 添加
function ajaxPost(url, data, divCallback = null, param = null) {
    data._method = "POST";
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': _token
        },
        success: function (res) {
            if (divCallback != null)
                divCallback(param, res)
            if (res.meta.status_code != 200) {
                //错误走弹窗
                layer.msg(res.meta.message);
            }
        },
        error: function (e) {
            if (typeof (e.responseJSON) == "object") {
                if (e.responseJSON.meta.status_code != 200) {
                    if (e.responseJSON.meta.hasOwnProperty("errors")) {
                        var obj = e.responseJSON.meta.errors;
                        Object.keys(obj).forEach(function (key) {
                            layer.msg(obj[key][0]);
                            throw new Error("ending");
                        });
                    } else {
                        layer.msg(e.responseJSON.meta.message);
                    }
                }
            } else {
                layer.msg(e.responseText);
            }
        }
    });
}


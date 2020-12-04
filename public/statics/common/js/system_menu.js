$(function () {
    /**
     * 添加
     */
    $(".create_btn").click(function () {
        ajaxPost('/system/permissions/create', $("#create_form").serialize(), function (param, res) {
            if (res.meta.status_code == 200) {
                $("#create_modal").modal('hide');
                layer.msg('添加成功', {icon: 6, time: 2000}, function () {
                    location.reload();
                });
            }
        });
    });

    /**
     * 编辑弹窗
     */
    $(".update").click(function () {
        $("#update_modal input[name='admin_route_id']").val($(this).data('admin_route_id'));
        $("#update_modal select[name='parent_id']").val($(this).data('parent_id'));
        $("#update_modal input[name='name']").val($(this).data('name'));
        $("#update_modal input[name='url']").val($(this).data('url'));
        $("#update_modal").modal('show');
    });


    /**
     * 更新
     */
    $(".update_btn").click(function () {
        ajaxPost('/system/permissions/update', $("#update_form").serialize(), function (param, res) {
            if (res.meta.status_code == 200) {
                $("#create_modal").modal('hide');
                layer.msg('更新成功', {icon: 6, time: 2000}, function () {
                    location.reload();
                });
            }
        });
    });


    /**
     * 删除
     */
    $('.delete').click(function () {
        ajaxDelete('/system/permissions/delete', {'admin_route_id': $(this).data('admin_route_id')});
    })
});

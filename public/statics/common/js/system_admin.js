$(function () {

    /**
     * 编辑弹窗
     */
    $(".update").click(function () {
        $("#update_modal input[name='admin_id']").val($(this).data('admin_id'));
        $("#update_modal input[name='name']").val($(this).data('name'));
        $("#update_modal input[name='mobile']").val($(this).data('mobile'));
        $("#update_modal select[name='role_id']").val($(this).data('role_id'));
        $("#update_modal").modal('show');
    });


    /**
     * 添加
     */
    $(".create_btn").click(function () {
        ajaxPost('/system/admin/create', $("#create_form").serialize(), function (param, res) {
            if (res.meta.status_code == 200) {
                $("#create_modal").modal('hide');
                layer.msg('添加成功', {icon: 6, time: 2000}, function () {
                    location.reload();
                });
            }
        });
    });
    /**
     * 更新
     */
    $(".update_btn").click(function () {
        ajaxPost('/system/admin/update', $("#update_form").serialize(), function (param, res) {
            if (res.meta.status_code == 200) {
                $("#update_form").modal('hide');
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
        ajaxDelete('/system/admin/delete', {'admin_id': $(this).data('admin_id')});
    })
});

$(function () {

    /**
     * 编辑弹窗
     */
    $(".update").click(function () {
        $("#update_modal input[name='id']").val($(this).data('id'));
        $("#update_modal input[name='name']").val($(this).data('name'));
        $("#update_modal").modal('show');
    });


    /**
     * 添加
     */
    $(".create_btn").click(function () {
        ajaxPost('/system/roles/create', $("#create_form").serialize(), function (param, res) {
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
        ajaxPost('/system/roles/update', $("#update_form").serialize(), function (param, res) {
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
        ajaxDelete('/system/roles/delete', {'id': $(this).data('id')});
    })
});

$(document).on('click', '#btn-edit', function(){
    $('.modal-body #id-penggna').val($(this).data('id'));
    $('.modal-body #nama').val($(this).data('nama'));
    $('.modal-body #email').val($(this).data('email'));
    $('.modal-body #role_id').val($(this).data('role_id'));
    $('.modal-body #divisi_id').val($(this).data('divisi_id'));
})
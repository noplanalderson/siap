(function($) {
  'use strict';
  $(function() {
    $('.file-upload-browse').on('click', function() {
      var file = $(this).parent().parent().parent().find('.file-upload-default');
      file.trigger('click');
    });
    $('.file-upload-default').on('change', function() {
      $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
  });
})(jQuery);

$("#formSetting").on('submit', function(e) {
        
        e.preventDefault();
        $('#loadingIcon').removeClass('d-none');
        $('#saveIcon').addClass('d-none');
        $('#btnSave').prop('disabled', true);
        
        var formAction = $("#formSetting").attr('action');

        $.ajax({
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            timeout:80000,
            url: formAction,
            dataType: 'json',
            error: function(xhr, status, error) {
                var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    text: data,
                    showConfirmButton: false,
                    type: 'error'
                })
            },
            success: function(data) {
                
                $('.csrf-token').val(data.token);
                $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
                
                if (data.result == 1) {
                    Swal.fire('Berhasil!', data.msg, 'success');
                    setTimeout(location.reload.bind(location), 1000);
                } else {
                    Swal.fire('Gagal!', data.msg, 'error');
                }

                $('#loadingIcon').addClass('d-none');
                $('#saveIcon').removeClass('d-none');
                $('#btnSave').prop('disabled', false);
            }
        });
        return false;
    });
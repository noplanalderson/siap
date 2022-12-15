$('.btn-print').on('click', function(e) {
	e.preventDefault();
	let counter_id = $(this).data('id');

	$('.btn-print').prop('disabled', true);
	$('.btn-print').html('<div class="card-footer text-center"><strong><i class="fas fa-spinner fa-spin"></i> Mencetak nomor...</strong></div>');

	$.ajax({
        url: baseURI + 'atm',
        type: 'post',
        data: {
            counter_id: counter_id,
            siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        dataType:'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                operator: data,
                showConfirmButton: false,
                type: 'error'
            })
        },
        success: function (data) {
            
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('.csrf-token').val(data.token);

            if(data.result == 1) {
                var data = data.transaksi;
                $('#queue-'+counter_id).text(data);

                } else {
                
                Toast.fire({
                   type : 'error',
                   icon: 'error',
                   title: 'Terjadi Kesalahan',
                   operator: data.msg,
                });  
            }

        }
    });

    $('.btn-print').prop('disabled', false);
    $('.btn-print').html('<div class="card-footer text-center"><strong><i class="fas fa-print"></i> Cetak Nomor</strong></div>');

    setTimeout(function(){
		window.open(baseURI + "atm?id=" + counter_id, '_blank', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=400,height=400').print();
    }, 2000)
})
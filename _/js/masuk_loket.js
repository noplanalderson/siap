$('#close').on('click', function(e){
	e.preventDefault();

	let counter_id = $(this).data('id');
	window.top.close();
})

$('#call').on('click', function(e) {
	e.preventDefault();

	let counter_id = $(this).data('id');

	var audio = document.getElementById('audiobell').play();

	document.createElement('audio');
	$.ajax({
		url: baseURI + 'admin/masuk-loket/'+counter_id,
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
                $('#queue').text(data);

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
})
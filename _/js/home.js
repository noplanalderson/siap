$(document).ready(function(){

	setInterval(function(){
		$.ajax({
		  url: baseURI + 'home/stats',
		  type: 'get',
		  dataType: 'json',
		  success: function(data) {
		    $.each(data, function(index, val) {
		    	$('#count-'+val.counter_id).html(val.queue);
		    });
		  },
		  error: function(xhr, status, error) {
		  	var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
		    Toast.fire({
                   type : 'error',
                   icon: 'error',
                   title: 'Terjadi Kesalahan',
                   text: data,
                });
		  }
		});
		
		
	},5000);
})
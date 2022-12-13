$(".show-btn-password").click(function() {
  var showBtn = $('.show-btn-password');
  var formPassword = $('#user_password').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-password d-flex hide-btn');
      $('.password').attr('class', 'fa fa-eye-slash password');
      $('#user_password').attr('type', 'text');
    }else{
      $('.password').attr('class', 'fa fa-eye password');
      $('#user_password').attr('type', 'password');
      showBtn.attr('class', 'input-group-text show-btn-password d-flex');
    }
});

$(".show-btn-repeat").click(function() {
  var showBtn = $('.show-btn-repeat');
  var formPassword = $('#repeat_password').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex hide-btn');
      $('.repeat').attr('class', 'fa fa-eye-slash repeat');
      $('#repeat_password').attr('type', 'text');
    }else{
      $('#repeat_password').attr('type', 'password');
      $('.repeat').attr('class', 'fa fa-eye repeat');
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex');
    }
});

$("#formMasuk").on('submit', function(e) {
    e.preventDefault();
    
    var formAction = $("#formMasuk").attr('action');
    var dataLogin = {
        submit: $("#submit").attr('name'),
        user_name: $("#user_name").val(),
        user_password: $("#user_password").val(),
        siap_token: $('.csrf-token').val()
    };

    $.ajax({
        type: "POST",
        url: formAction,
        data: dataLogin,
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
            
            $("#alert").slideDown('fast');
            $("#alert").html('<small>' + data.msg + '</small>');

            if (data.result == 1) {
                $('#alert').attr('class', 'alert alert-success pt-1 pb-1');
                var userJsonString = JSON.stringify(data.menu);
                localStorage.setItem('menu', userJsonString);
                setTimeout(function () { window.location.href = baseURI + 'admin/' + data.url;}, 2000);
            } else {
                $('#alert').attr('class', 'alert alert-danger pt-1 pb-1');
                $("#alert").alert().delay(3000).slideUp('fast');
            }
        }
    });
    return false;
});
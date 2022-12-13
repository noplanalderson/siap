$(".show-btn-password").click(function() {
  var showBtn = $('.show-btn-password');
  var formPassword = $('#user_password_emp').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-password d-flex hide-btn');
      $('.password').attr('class', 'fa fa-eye-slash password');
      $('#user_password_emp').attr('type', 'text');
    }else{
      $('.password').attr('class', 'fa fa-eye password');
      $('#user_password_emp').attr('type', 'password');
      showBtn.attr('class', 'input-group-text show-btn-password d-flex');
    }
});

$(".show-btn-repeat").click(function() {
  var showBtn = $('.show-btn-repeat');
  var formPassword = $('#repeat_password_emp').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex hide-btn');
      $('.repeat').attr('class', 'fa fa-eye-slash repeat');
      $('#repeat_password_emp').attr('type', 'text');
    }else{
      $('#repeat_password_emp').attr('type', 'password');
      $('.repeat').attr('class', 'fa fa-eye repeat');
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex');
    }
});

let tableCfg = {
    responsive: true,
    processing: true,
    "language": {
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw text-dark"></i><span class="sr-only text-dark">Memuat...</span>',
        "emptyTable": "Tidak ada data",
        "lengthMenu": "_MENU_ &nbsp; data/halaman",
        "search": "Cari: ",
        "zeroRecords": "Tidak ditemukan data yang cocok.",
        "paginate": {
          "previous": "<i class='fas fa-chevron-left'></i>",
          "next": "<i class='fas fa-chevron-right'></i>",
        },
    },
    'columnDefs': [ 
        {
            'targets': [2,3],
            'orderable': false,
        },
    ],
    dom: '<"left"l><"right"fr>Btip',
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'admin/manajemen-user').load();
        }
    }],
    'ajax': {
        'url': baseURI + 'admin/manajemen-user',
        'method': 'get'
    },
    "columns":[
        { 
            "data": function (row, type, val, meta) { 
                return '<p class="font-weight-bold">'+row.employee_name+'</p><small class="text-primary">'+row.username+'</small>';
            },
            "defaultContent": "-"
        },
        { "data": "group_name", "name": "group_name", "title": "Grup" },
        { 
            "data": function (row, type, val, meta) { 
                let color = (row.status === 'active') ? 'badge-success' : 'badge-danger';
                return '<span class="badge badge-pill '+color+'">'+row.status+'</span>';
            },
            "defaultContent": "-"
        },
        { "data": function (row, type, val, meta) {
            let button = '';
            button += '<div class="dropdown">';
            button += '<button class="btn btn-primary dropdown-toggle" type="button" id="act-'+row.user_id+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>';
            button += '<div class="dropdown-menu" aria-labelledby="act-'+row.user_id+'"><h6 class="dropdown-header text-black-50">Aksi</h6>';
            button += '<div class="dropdown-divider"></div>';
            if(menu.includes('ubah-user')) {
                button += "<button class='dropdown-item text-black-50 ubah-user' data-toggle='modal' data-target='#userModal' data-id='"+row.user_id+"'><i class='fas fa-edit'></i> Ubah</button>";
            }
            if(menu.includes('hapus-user')) {
                button += "<button href='#' data-id='"+row.user_id+"' class='dropdown-item text-black-50 hapus-user'><i class='fas fa-trash-alt'></i> Hapus</button>";
            }
            button += "</div></div>";

            return button;
        }}
    ],
    initComplete: function() {
        $('#total').text( this.api().data().length )
    }
}

let tblUser = $('#tbl_user').DataTable(tableCfg);

$('.tambah-user').on('click', function (e){
    e.preventDefault();

    $('#userModal .modal-title').text('Tambah User');
    $('#form_user').attr('action', baseURI + 'admin/tambah-user');

    $('#user_id').val('');
    $('#id_grup').val('');
    $('#employee_name').val('');
    $('#username').val('');
    $('#user_password_emp').val('');
    $('#repeat_password_emp').val('');
    $('#status').prop('checked', false);
})

$('#tbl_user').on('click', '.ubah-user', function(e) {
    e.preventDefault();

    $('#userModal .modal-title').text('Ubah User');
    $('#form_user').attr('action', baseURI + 'admin/ubah-user');

    let user_id = $(this).data('id');
    let siap_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');

    $.ajax({
        url: baseURI + 'admin/manajemen-user',
        type: 'post',
        data: {
            user_id,
            siap_token
        },
        dataType:'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                text: data,
                showConfirmButton: false,
                type: 'error'
            })
        },
        success: function (data, xhr) {
            
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('.csrf-token').val(data.token);

            if(data.result == 1) {
                var data = data.user;

                $('#user_id').val(user_id);
                $('#group_id').val(data.group_id);
                $('#employee_name').val(data.employee_name);
                $('#username').val(data.username);
                $('#user_password_emp').val('');
                $('#repeat_password_emp').val('');
                $('#status').prop('checked', (data.status == 'active' ? true : false));
            } else {
                Toast.fire({
                   type : 'error',
                   icon: 'error',
                   title: 'Terjadi Kesalahan',
                   text: data.msg,
                });  
            }
        }
    });
})

$('#form_user').on('submit', function(e) {
    e.preventDefault();

    let action = $('#form_user').attr('action');

    $.ajax({
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        timeout:80000,
        url: action,
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
        success: function (data, xhr) {
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('.csrf-token').val(data.token);

            if(data.result == 1) {

                Swal.fire('Berhasil!', data.msg, 'success');
                $('#userModal').modal('hide');
                tblUser.ajax.reload(function(){
                    $('#total').text(tblUser.rows().count());
                }, false);
            } else {
                Swal.fire('Gagal!', data.msg, 'error'); 
            }   
        }
    });
})

$("#tbl_user").on('click', '.hapus-user', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin menghapus user?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

        if (result.value == true) {

            const user_id = $(this).data('id');
            $.ajax({
                url: baseURI + 'admin/hapus-user',
                data: {
                        user_id: user_id, 
                        siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                method: 'post',
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                    Toast.fire({type:'error', icon:'error', title: '', text: data});
                },
                success: function(data) {
                    $('.csrf-token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
                    
                    if (data.result == 1) {
                        Swal.fire('Berhasil!', data.msg, 'success');
                        tblUser.ajax.reload(function(){
                            $('#total').text(tblUser.rows().count());
                        }, false);
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                    
                }
            });
        }
    })
});
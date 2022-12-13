let tableCfg = {
    responsive: true,
    processing: true,
    "language": {
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw operator-dark"></i><span class="sr-only operator-dark">Memuat...</span>',
        "emptyTable": "Tidak ada data",
        "lengthMenu": "_MENU_ &nbsp; data/halaman",
        "search": "Cari: ",
        "zeroRecords": "Tidak ditemukan data yang cocok.",
        "paginate": {
          "previous": "<i class='fas fa-chevron-left'></i>",
          "next": "<i class='fas fa-chevron-right'></i>",
        },
    },
    'orderable':false,
    'columnDefs': [{
        "targets": [2],
        "class": 'wrapok',
        "width":"15%"
    }],
    dom: '<"left"l><"right"fr>Btip',
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'admin/operator').load();
        }
    }],
    'ajax': {
        'url': baseURI + 'admin/operator',
        'method': 'get'
    },
    "columns":[
        { "data": "employee_name", "name": "employee_name", "title": "Petugas" },
        { "data": "counter_name", "name": "counter_name", "title": "Nama Loket" },
        { "data": function (row, type, val, meta) {
            
            var button = '';
            if(menu.includes('ubah-operator')) {
                button = "<button href='#' data-id='"+row.operator_id+"' data-toggle='modal' data-target='#operatorModal' class='btn btn-md btn-warning py-2 ubah-operator mr-2'><i class='fas fa-edit'></i></button>";
            }
            if(menu.includes('hapus-operator')) {
                button += "<button href='#' data-id='"+row.operator_id+"' class='btn btn-md btn-danger py-2 hapus-operator'><i class='fas fa-trash-alt'></i></button>";
            }
            return button;
        }}
    ]
}

let tblOperator = $('#tbl_operator').DataTable(tableCfg);

$("#tbl_operator").on('click', '.hapus-operator', function(e){
    e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin menghapus operator?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {
        const operator_id = $(this).data('id');

        $.ajax({
            url: baseURI + 'admin/hapus-operator',
            data: { 
                operator_id: operator_id,
                siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            method: 'post',
            dataType: 'json',
            error: function(xhr, status, error) {
                var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    operator: data,
                    showConfirmButton: false,
                    type: 'error'
                })
            },
            success: function(data) {

                $('.csrf-token').val(data.token);
                $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

                if (data.result == 1) {
                  Swal.fire('Berhasil!', data.msg, 'success');
                  tblOperator.ajax.reload(null, false);
                } 
                else {
                  Swal.fire('Gagal!', data.msg, 'error');
                }
            }
        });
    }
    })
});

$('.tambah-operator').on('click', function(e) {
    e.preventDefault();

    $('.modal-title').text('Tambah Teks');
    $('#operatorForm').attr('action', baseURI + 'admin/tambah-operator');

    $('#operator_id').val('');
    $('#user_id').val('');
    $('#counter_id').val('');
});

$('#tbl_operator').on('click', '.ubah-operator', function(e) {
    e.preventDefault();

    $('#operatorModal .modal-title').text('Ubah Teks');
    $('#operatorForm').attr('action', baseURI + 'admin/ubah-operator');

    let operator_id = $(this).data('id');
    let siap_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');

    $.ajax({
        url: baseURI + 'admin/operator',
        type: 'post',
        data: {
            operator_id,
            siap_token
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
                var data = data.operator;

                $('#operator_id').val(data.operator_id);
                $('#user_id').val(data.user_id);
                $('#counter_id').val(data.counter_id);
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
});

$('#operatorForm').on('submit', function(e) {
    e.preventDefault();

    let action = $('#operatorForm').attr('action');

    $.ajax({
        type: "POST",
        data: {
            operator_id: $('#operator_id').val(),
            user_id: $('#user_id').val(),
            counter_id: $('#counter_id').val(),
            siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        url: action,
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                operator: data,
                showConfirmButton: false,
                type: 'error'
            })
        },
        success: function (data, xhr) {
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('.csrf-token').val(data.token);

            if(data.result == 1) {

                Swal.fire('Berhasil!', data.msg, 'success');
                $('#operatorModal').modal('hide');
                tblOperator.ajax.reload(null, false);
            } else {
                Swal.fire('Gagal!', data.msg, 'error'); 
            }   
        }
    });
})
let tableCfg = {
    responsive: true,
    processing: true,
    "language": {
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw loket-dark"></i><span class="sr-only loket-dark">Memuat...</span>',
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
    dom: '<"left"l><"right"fr>Btip',
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'admin/loket').load();
        }
    }],
    'ajax': {
        'url': baseURI + 'admin/loket',
        'method': 'get'
    },
    "columns":[
        { "data": "counter_name", "name": "counter_name", "title": "Nama Loket" },
        { "data": "date_created", "name": "date_created", "title": "Tgl. Dibuat" },
        { "data": "created_by", "name": "created_by", "title": "Dibuat oleh" },
        { 
            "data": function (row, type, val, meta) { 
                let color = (row.status === 'open') ? 'badge-success' : 'badge-danger';
                return '<span class="badge badge-pill '+color+'">'+(row.status === 'open' ? 'Buka' : 'Tutup')+'</span>';
            },
            "defaultContent": "-"
        },
        { "data": function (row, type, val, meta) {
            
            var button = '';
            if(menu.includes('ubah-loket')) {
                button = "<button href='#' data-id='"+row.counter_id+"' data-toggle='modal' data-target='#loketModal' class='btn btn-sm btn-warning py-1 ubah-loket mr-2'><i class='fas fa-edit'></i></button>";
            }
            if(menu.includes('hapus-loket')) {
                button += "<button href='#' data-id='"+row.counter_id+"' class='btn btn-sm btn-danger py-1 hapus-loket mr-2'><i class='fas fa-trash-alt'></i></button>";
            }
            if(menu.includes('masuk-loket')) {
                button += "<a data-id='"+row.counter_id+"' class='btn btn-sm btn-info py-1 buka-loket'><i class='fas fa-sign-in-alt'></i></a>";
            }
            return button;
        }}
    ]
}

let tblLoket = $('#tbl_loket').DataTable(tableCfg);

$("#tbl_loket").on('click', '.hapus-loket', function(e){
    e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin menghapus loket?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {
        const counter_id = $(this).data('id');

        $.ajax({
            url: baseURI + 'admin/hapus-loket',
            data: { 
                counter_id: counter_id,
                siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            method: 'post',
            dataType: 'json',
            error: function(xhr, status, error) {
                var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    loket: data,
                    showConfirmButton: false,
                    type: 'error'
                })
            },
            success: function(data) {

                $('.csrf-token').val(data.token);
                $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

                if (data.result == 1) {
                  Swal.fire('Berhasil!', data.msg, 'success');
                  tblLoket.ajax.reload(null, false);
                } 
                else {
                  Swal.fire('Gagal!', data.msg, 'error');
                }
            }
        });
    }
    })
});

$('.tambah-loket').on('click', function(e) {
    e.preventDefault();

    $('.modal-title').text('Tambah Teks');
    $('#loketForm').attr('action', baseURI + 'admin/tambah-loket');

    $('#counter_id').val('');
    $('#counter_name').val('');
    $('#status').prop('checked', false);
});

$('#tbl_loket').on('click', '.ubah-loket', function(e) {
    e.preventDefault();

    $('#loketModal .modal-title').text('Ubah Teks');
    $('#loketForm').attr('action', baseURI + 'admin/ubah-loket');

    let counter_id = $(this).data('id');
    let siap_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');

    $.ajax({
        url: baseURI + 'admin/loket',
        type: 'post',
        data: {
            counter_id,
            siap_token
        },
        dataType:'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                loket: data,
                showConfirmButton: false,
                type: 'error'
            })
        },
        success: function (data) {
            
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('.csrf-token').val(data.token);

            if(data.result == 1) {
                var data = data.loket;

                $('#counter_name').val(data.counter_name);
                $('#counter_id').val(data.counter_id);
                $('#status').prop('checked', (data.status === 'open' ? true : false));

            } else {
                Toast.fire({
                   type : 'error',
                   icon: 'error',
                   title: 'Terjadi Kesalahan',
                   loket: data.msg,
                });  
            }
        }
    });
});

$('#loketForm').on('submit', function(e) {
    e.preventDefault();

    let action = $('#loketForm').attr('action');

    $.ajax({
        type: "POST",
        data: {
            loket_id: $('#loket_id').val(),
            counter_name: $('#counter_name').val(),
            counter_id: $('#counter_id').val(),
            status: (($('#status').prop('checked') == true) ? 'open' : 'close'),
            siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        url: action,
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                loket: data,
                showConfirmButton: false,
                type: 'error'
            })
        },
        success: function (data, xhr) {
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('.csrf-token').val(data.token);

            if(data.result == 1) {

                Swal.fire('Berhasil!', data.msg, 'success');
                $('#loketModal').modal('hide');
                tblLoket.ajax.reload(null, false);
            } else {
                Swal.fire('Gagal!', data.msg, 'error'); 
            }   
        }
    });
})

$('#tbl_loket').on('click', '.buka-loket', function(e) {
    let counter_id = $(this).data('id');
    $.ajax({
        url: baseURI + 'admin/loket/status',
        type: 'post',
        data: {
            counter_id: counter_id,
            status: 'open',
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

            if(data.result !== 1) {
                
                Toast.fire({
                   type : 'error',
                   icon: 'error',
                   title: 'Terjadi Kesalahan',
                   operator: data.msg,
                });  
            }
            else
            {
                window.open(baseURI + "admin/masuk-loket/" + counter_id, '_blank').focus();
            }
        }
    });
})
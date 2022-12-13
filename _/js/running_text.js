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
            'targets': [0,3,4],
            'orderable': false,
        },
        {
            "class": "wrapok", 
            "targets": [0],
            "width": '30%'
        },
    ],
    dom: '<"left"l><"right"fr>Btip',
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'admin/running-text').load();
        }
    }],
    'ajax': {
        'url': baseURI + 'admin/running-text',
        'method': 'get'
    },
    "columns":[
        { "data": "text", "name": "text", "title": "Isi Teks" },
        { "data": "date_created", "name": "date_created", "title": "Tgl. Dibuat" },
        { "data": "created_by", "name": "created_by", "title": "Dibuat oleh" },
        { 
            "data": function (row, type, val, meta) { 
                let color = (row.status === 'show') ? 'badge-success' : 'badge-danger';
                return '<span class="badge badge-pill '+color+'">'+row.status+'</span>';
            },
            "defaultContent": "-"
        },
        { "data": function (row, type, val, meta) {
            
            var button = '';
            if(menu.includes('ubah-teks')) {
                button = "<button href='#' data-id='"+row.text_id+"' data-toggle='modal' data-target='#textModal' class='btn btn-md btn-warning py-2 ubah-teks mr-2'><i class='fas fa-edit'></i></button>";
            }
            if(menu.includes('hapus-teks')) {
                button += "<button href='#' data-id='"+row.text_id+"' class='btn btn-md btn-danger py-2 hapus-teks'><i class='fas fa-trash-alt'></i></button>";
            }
            return button;
        }}
    ]
}

let tblText = $('#tbl_text').DataTable(tableCfg);

$("#tbl_text").on('click', '.hapus-teks', function(e){
    e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin menghapus teks ini?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {
        const text_id = $(this).data('id');

        $.ajax({
            url: baseURI + 'admin/hapus-teks',
            data: { 
                text_id: text_id,
                siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            method: 'post',
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
                  tblText.ajax.reload(null, false);
                } 
                else {
                  Swal.fire('Gagal!', data.msg, 'error');
                }
            }
        });
    }
    })
});

$('.tambah-teks').on('click', function(e) {
    e.preventDefault();

    $('.modal-title').html('Tambah Teks');
    $('#textForm').attr('action', baseURI + 'admin/tambah-teks');

    $('#text_id').val('');
    $('#text').val('');
    $('#status').prop('checked', false);
});

$('#tbl_text').on('click', '.ubah-teks', function(e) {
    e.preventDefault();

    $('#textModal .modal-title').text('Ubah Teks');
    $('#textForm').attr('action', baseURI + 'admin/ubah-teks');

    let text_id = $(this).data('id');
    let siap_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');

    $.ajax({
        url: baseURI + 'admin/running-text',
        type: 'post',
        data: {
            text_id,
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
        success: function (data) {
            
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('.csrf-token').val(data.token);

            if(data.result == 1) {
                var data = data.text;

                $('#text_id').val(data.text_id);
                $('#text').val(data.text);
                $('#status').prop('checked', (data.status == 'show' ? true : false));
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
});

$('#textForm').on('submit', function(e) {
    e.preventDefault();

    let action = $('#textForm').attr('action');

    $.ajax({
        type: "POST",
        data: {
            text_id: $('#text_id').val(),
            text: $('#text').val(),
            status: (($('#status').prop('checked') == true) ? 'show' : 'hide'),
            siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
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
                $('#textModal').modal('hide');
                tblText.ajax.reload(null, false);
            } else {
                Swal.fire('Gagal!', data.msg, 'error'); 
            }   
        }
    });
})
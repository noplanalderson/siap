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
            'targets': [0,1,2,5],
            'orderable': false,
        },
        {
            "class": "wrapok", 
            "targets": [1,2],
            "width": '30%'
        },
    ],
    dom: '<"left"l><"right"fr>Btip',
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'admin/slide').load();
        }
    }],
    'ajax': {
        'url': baseURI + 'admin/slide',
        'method': 'get'
    },
    "columns":[
        { 
            "data": function (row, type, val, meta) {
                return '<img class="img-fluid w-75 h-75" src="'+baseURI + '_/uploads/slides/'+row.image+'">';
            }
        },
        { "data": "slide_title", "name": "slide_title", "title": "Judul" },
        { "data": "slide_description", "name": "slide_description", "title": "Deskripsi" },
        { "data": "upload_by", "name": "upload_by", "title": "Pengunggah" },
        { "data": "upload_date", "name": "upload_date", "title": "Tgl. Unggah" },
        { 
            "data": function (row, type, val, meta) { 
                let color = (row.status === 'show') ? 'badge-success' : 'badge-danger';
                return '<span class="badge badge-pill '+color+'">'+row.status+'</span>';
            },
            "defaultContent": "-"
        },
        { "data": function (row, type, val, meta) {
            
            if(menu.includes('ubah-gambar')) {
                var button = "<button href='#' data-id='"+row.slide_id+"' data-file='"+row.image+"' data-toggle='modal' data-target='#slideModal' class='btn btn-md btn-warning py-2 ubah-gambar mr-2'><i class='fas fa-edit'></i></button>";
            }
            if(menu.includes('hapus-gambar')) {
                button += "<button href='#' data-id='"+row.slide_id+"' data-file='"+row.image+"' class='btn btn-md btn-danger py-2 hapus-gambar'><i class='fas fa-trash-alt'></i></button>";
            }
            return button;
        }}
    ]
}

let tblSlide = $('#tbl_slide').DataTable(tableCfg);

$("#tbl_slide").on('click', '.hapus-gambar', function(e){
    e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin menghapus gambar ini?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {
        const slide_id = $(this).data('id');
        const file_slide = $(this).data('file');

        $.ajax({
            url: baseURI + 'admin/hapus-gambar',
            data: { 
                slide_id: slide_id,
                file: file_slide,
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
                  tblSlide.ajax.reload(null, false);
                } 
                else {
                  Swal.fire('Gagal!', data.msg, 'error');
                }
            }
        });
    }
    })
});

$('.tambah-gambar').on('click', function(e) {
    e.preventDefault();

    $('.modal-title').html('Tambah Gambar');
    $('#slideForm').attr('action', baseURI + 'admin/tambah-gambar');

    $('#slide_id').val('');
    $('#slide_title').val('');
    $('#slide_description').val('');
    $('#old_image').val('');
    $('#status').prop('checked', false);
});

$('#tbl_slide').on('click', '.ubah-gambar', function(e) {
    e.preventDefault();

    $('#slideModal .modal-title').text('Ubah Gambar');
    $('#slideForm').attr('action', baseURI + 'admin/ubah-gambar');

    let slide_id = $(this).data('id');
    let siap_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');

    $.ajax({
        url: baseURI + 'admin/slide',
        type: 'post',
        data: {
            slide_id,
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
                var data = data.slide;

                $('#slide_id').val(data.slide_id);
                $('#slide_title').val(data.slide_title);
                $('#slide_description').val(data.slide_description);
                $('#old_image').val(data.image);
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

$('#slideForm').on('submit', function(e) {
    e.preventDefault();

    let action = $('#slideForm').attr('action');

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
                $('#slideModal').modal('hide');
                tblSlide.ajax.reload(null, false);
            } else {
                Swal.fire('Gagal!', data.msg, 'error'); 
            }   
        }
    });
})
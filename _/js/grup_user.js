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
    "order": [[ 0, "asc" ]],
        'columnDefs': [ 
        {
            'targets': [1,2],
            'orderable': false,
        },
        {
            "class": "wrapok", 
            "targets": [1],
            "width": '50%'
        },
    ],
    dom: '<"left"l><"right"fr>Btip',
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'admin/grup-user').load();
        }
    }],
    'ajax': {
        'url': baseURI + 'admin/grup-user',
        'method': 'get'
    },
    "columns":[
        { 
            "data": function (row, type, val, meta) { 
                return row.group_name+' ('+row.mode+')';
            },
            "defaultContent": "-"
        },
        { 
            "data": function (row, type, val, meta) { 
                return row.fitur;
            },
            "defaultContent": "-"
        },
        { 
            "data": function (row, type, val, meta) { 
                return '<select name="index_menu" class="index_menu" data-id="'+row.group_id+'" required><option value="">Index Menu</option>'+row.index_menu+'</select>';
            },
            "defaultContent": "-"
        },
        { "data": function (row, type, val, meta) {
            let button = '';
            button += '<div class="dropdown">';
            button += '<button class="btn btn-primary dropdown-toggle" type="button" id="act-'+row.group_id+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>';
            button += '<div class="dropdown-menu" aria-labelledby="act-'+row.group_id+'"><h6 class="dropdown-header text-black-50">Aksi</h6>';
            button += '<div class="dropdown-divider"></div>';
            if(menu.includes('ubah-grup')) {
                button += "<button class='dropdown-item text-black-50 ubah-grup' data-toggle='modal' data-target='#grupModal' data-id='"+row.group_id+"'><i class='fas fa-edit'></i> Ubah</button>";
            }
            if(menu.includes('hapus-grup')) {
                button += "<button href='#' data-id='"+row.group_id+"' class='dropdown-item text-black-50 hapus-grup'><i class='fas fa-trash-alt'></i> Hapus</button>";
            }
            button += "</div></div>";

            return button;
        }}
    ],
    initComplete: function() {
        $('#total').text( this.api().data().length )
    }
}

let tblGrup = $('#tbl_grup').DataTable(tableCfg);

$(function () {
    var features = "";
    $.getJSON(baseURI + "admin/grup-user/menu", function(data) {

        $.each(data, function(index, item) {
            features += "<option value='" + item.grup_fitur + "_"+item.mode+"'>" + item.grup_fitur.toUpperCase() + " ("+item.mode+")</option>";
        });
        $("#fitur").html(features);
    });
})

function initSelect2(val = '') {
    $('#fitur').select2({
        width: '100%',
        dropdownParent:'#grupModal',
        placeholder: 'Pilih Fitur'
    }).val(val).trigger('change');
}

$('#mode').on('change', function(e) {
    e.preventDefault();
    // $('#fitur').select2('destroy');
    var features = "";
    $.getJSON(baseURI + "admin/grup-user/menu?mode="+$(this).val(), function(data) {

        $.each(data, function(index, item) {
            features += "<option value='" + item.grup_fitur + "_"+item.mode+"' selected>" + item.grup_fitur.toUpperCase() + " ("+item.mode+")</option>";
        });
        $("#fitur").html(features);
    });

    initSelect2();
})

$('.tambah-grup').on('click', function(e) {
    e.preventDefault();

    $('#grupModal .modal-title').text('Tambah Grup');
    $('#form_grup').attr('action', baseURI + 'admin/tambah-grup');
    $('#group_id').val('');
    $('#group_name').val('');
    $('#fitur').val('');
    $('#mode').val('').trigger('change');
    initSelect2();
})

$('#tbl_grup').on('click', '.ubah-grup', function(e) {
    e.preventDefault();

    $('#grupModal .modal-title').text('Ubah Grup');
    $('#form_grup').attr('action', baseURI + 'admin/ubah-grup');

    let group_id = $(this).data('id');
    let siap_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');

    $.ajax({
        url: baseURI + 'admin/grup-user',
        type: 'post',
        data: {
            group_id,
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
                var data = data.grup;
                $('#group_id').val(data.group_id);
                $('#group_name').val(data.group_name);
                $('#mode').val(data.mode).trigger('change');

                var features = data.features;

                if (features) {
                    var arrayFeatures = features.split(',');
                    initSelect2(arrayFeatures);
                }
                else
                {
                    initSelect2();
                }
            }
            else
            {
                Toast.fire({
                   type : 'error',
                   icon: 'error',
                   title: 'Terjadi Kesalahan',
                   text: data.msg,
                });
            }
        }
    })
})

$('#form_grup').on('submit', function(e) {
    e.preventDefault();

    let action = $(this).attr('action');

    let data = {
        group_id: $('#group_id').val(),
        group_name: $('#group_name').val(),
        mode: $('#mode').val(),
        fitur: $('#fitur').val(),
        siap_token: $('.csrf-token').val()
    };

    $.ajax({
        url: action,
        type: 'post',
        data: data,
        dataType:'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Toast.fire({
                type : 'error',
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: data,
            })
        },
        success: function (data, xhr) {
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('.csrf-token').val(data.token);

            if(data.result == 1) {

                Toast.fire({
                   type : 'success',
                   icon: 'success',
                   title: '',
                   text: data.msg,
                });
                $('#grupModal').modal('hide');
                tblGrup.ajax.reload(function(){
                    $('#total').text(tblGrup.rows().count());
                }, false);

                setTimeout(function () { window.location.href; }, 2000);
            } else {
                Swal.fire('Gagal!', data.msg, 'error'); 
            }   
        }
    });
})

$("#tbl_grup").on('click', '.hapus-grup', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Perhatian!',
        text: 'Anda yakin ingin menghapus grup?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

        if (result.value == true) {

            const group_id = $(this).data('id');
            let group_name = $(this).data('name');
            $.ajax({
                url: baseURI + 'admin/hapus-grup',
                data: {
                        group_id, 
                        group_name,
                        siap_token: $('.csrf-token').attr('value')
                    },
                method: 'post',
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                    Toast.fire({
                        type : 'error',
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: data,
                    })
                },
                success: function(data) {
                    $('.csrf-token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
                    
                    if (data.result == 1) {
                        Swal.fire('Berhasil!', data.msg, 'success');
                        tblGrup.ajax.reload();
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            });
        }
    })
});

$("#tbl_grup").on('change', '.index_menu', function(){
    
    const group_id = $(this).data('id');
    var index_menu = $('select[data-id="'+group_id+'"]').val();

    $.ajax({
        url: baseURI + 'admin/grup-user/update-index',
        data: { 
            group_id,
            index_menu,
            siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        method: 'post',
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Toast.fire({
                type : 'error',
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: data,
            })
        },
        success: function(data) {

            $('.csrf-token').val(data.token);
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

            if(data.result == 0) {
                $('.index_menu option').prop('selected', function() {
                    return this.defaultSelected;
                });
                Toast.fire({
                    type : 'error',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: data.msg,
                })
            }
            else
            {
                Toast.fire({
                    type : 'success',
                    icon: 'success',
                    title: '',
                    text: data.msg,
                })
            }
        }
    });
});
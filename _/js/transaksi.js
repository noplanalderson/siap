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
            'targets': [0],
            'orderable': false,
        }
    ],
    dom: '<"left"l><"right"fr>Btip',
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm p-2',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'admin/transaksi').load();
        }
    },
    {
        text: '<i class="fa fa-file-pdf"></i> PDF',
        className: 'btn btn-sm btn-danger p-2',
        extend: 'pdf',
        pageSize: 'Legal',
        orientation: 'landscape',
        title: 'Daftar Transaksi Loket',
        action: function(e, dt, button, config) {
            responsiveToggle(dt);
            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(dt.button(button), e, dt, button, config);
            responsiveToggle(dt);
        },
        customize : function(doc) {
            doc.content.splice(0, 1, {
                text: [{
                    text: "Daftar Transaksi Loket\n\n",
                    fontSize: 14,
                    alignment: 'center'
                }]
            });
            margin: [10, 5, 5, 10];
            alignment: 'center';
            doc.styles.tableHeader.alignment = 'center'
            doc.defaultStyle.fontSize = 12;
            doc.styles.tableHeader.fontSize = 12;

            var colCount = new Array();
            var tr = $('#tbl_transaksi tbody tr:first-child');
            var trWidth = $(tr).width();

            var length = $('#tbl_transaksi tbody tr:first-child td').length;

            $('#tbl_transaksi').find('tbody tr:first-child td').each(function()
            {
                var tdWidth = $(this).width();
                var widthFinal = parseFloat(tdWidth * 120);
                widthFinal = widthFinal.toFixed(2) / trWidth.toFixed(2);
                if ($(this).attr('colspan')) 
                {
                    for (var i = 1; i <= $(this).attr('colspan'); $i++) {
                        colCount.push('*');
                    }
                } 
                else 
                {
                    colCount.push(parseFloat(widthFinal.toFixed(2)) + '%');
                }
            });
            doc.content[1].table.widths = colCount;
        },
    },
    {
        text: '<i class="fa fa-file-excel"></i> Excel',
        className: 'btn btn-sm btn-success p-2',
        extend: 'excel',
        pageSize: 'Legal',
        orientation: 'landscape',
        title: 'Daftar Transaksi Loket',
        action: function(e, dt, button, config) {
            responsiveToggle(dt);
            $.fn.dataTable.ext.buttons.excelHtml5.action.call(dt.button(button), e, dt, button, config);
            responsiveToggle(dt);
        }
    }],
    'ajax': {
        'url': baseURI + 'admin/transaksi',
        'method': 'get'
    },
    "columns":[
        { "data": "transaction_id", "name": "transaction_id", "title": "ID Transaksi" },
        { "data": "date", "name": "date", "title": "Tanggal" },
        { "data": "counter_name", "name": "counter_name", "title": "Loket" },
        { "data": "employee_name", "name": "employee_name", "title": "Petugas" },
    ]
}

let tblTtransaksi = $('#tbl_transaksi').DataTable(tableCfg);

$('#submit_filter').on('click', function(e) {
    e.preventDefault();

    let loket = $('#counter_id').val();
    let start = $('#start_date').val();
    let end = $('#end_date').val();

    tblTtransaksi.ajax.url(baseURI + 'admin/transaksi/?loket='+loket+'&start_date='+start+'&end_date='+end).load();
})
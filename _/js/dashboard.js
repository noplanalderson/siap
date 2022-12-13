$(function(){

    $.ajax({
        url: baseURI + 'admin/dashboard/stats',
        method: 'get',
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
        success: function(data){

            var html = '';
                html += '<div class="col-xl-3 col-sm-6 grid-margin stretch-card">';
                html += '<div class="card">';
                html += '<div class="card-body">';
                html += '<div class="row"><div class="col-9"><div class="d-flex align-items-center align-self-start">';
                html += '<h3 class="mb-0 text-grey-m2">Operator</h3></div></div>';
                html += '<div class="col-3"><div class="icon p-4 icon-box-danger bg-white"><span class="fa-lg fas fa-users text-danger"></span></div></div></div>';
                html += '<h3 class="text-muted font-weight-normal">'+data.jumlah_petugas+'</h3></div></div></div>';

                html += '<div class="col-xl-3 col-sm-6 grid-margin stretch-card">';
                html += '<div class="card">';
                html += '<div class="card-body">';
                html += '<div class="row"><div class="col-9"><div class="d-flex align-items-center align-self-start">';
                html += '<h3 class="mb-0 text-grey-m2">Jumlah Loket</h3></div></div>';
                html += '<div class="col-3"><div class="icon p-4 icon-box-danger bg-white"><span class="fa-lg fas fa-chalkboard-teacher text-success"></span></div></div></div>';
                html += '<h3 class="text-muted font-weight-normal">'+data.jumlah_loket+'</h3></div></div></div>';

                html += '<div class="col-xl-3 col-sm-6 grid-margin stretch-card">';
                html += '<div class="card">';
                html += '<div class="card-body">';
                html += '<div class="row"><div class="col-9"><div class="d-flex align-items-center align-self-start">';
                html += '<h3 class="mb-0 text-grey-m2">Pengunjung Hari Ini</h3></div></div>';
                html += '<div class="col-3"><div class="icon p-4 icon-box-danger bg-white"><span class="fa-lg fas fa-receipt text-primary"></span></div></div></div>';
                html += '<h3 class="text-muted font-weight-normal">'+data.jumlah_pengunjung+'</h3></div></div></div>';

                html += '<div class="col-xl-3 col-sm-6 grid-margin stretch-card">';
                html += '<div class="card">';
                html += '<div class="card-body">';
                html += '<div class="row"><div class="col-9"><div class="d-flex align-items-center align-self-start">';
                html += '<h3 class="mb-0 text-grey-m2">Slide</h3></div></div>';
                html += '<div class="col-3"><div class="icon p-4 icon-box-danger bg-white"><span class="fa-lg fas fa-images text-warning"></span></div></div></div>';
                html += '<h3 class="text-muted font-weight-normal">'+data.jumlah_slide+'</h3></div></div></div>';

            $('#row_satu').html(html);
        }
    });
})

$(function () {
    var canvas = document.getElementById("grafik-investor");
    var ctx = canvas.getContext("2d");
    var json_url = baseURI + "admin/dashboard/stats";

    var visitorGraph = new Chart(ctx, {
        type: 'line',
        responsive:true,
        data: {
            labels: [],
            datasets: [
                {
                    label: "Grafik Pengunjung",
                    fill: true,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 100,
                    data: [],
                    spanGaps: false,
                }
            ]
        },
        options: {
            tooltips: {
                mode: 'index',
                intersect: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        stepSize: 50
                    }
                }]
            }
        }
    });

    ajax_chart(visitorGraph, json_url);

    function ajax_chart(chart, url, data) {
        var data = data || {};

        $.getJSON(url, data).done(function(response) {
            chart.data.labels = response.pengunjung_ytd.labels;
            chart.data.datasets[0].data = response.pengunjung_ytd.data.jumlah;
            chart.update();
        });
    }

    document.getElementById('btn-download').onclick = function() {
        // Trigger the download
        var a = document.createElement('a');
        a.href = visitorGraph.toBase64Image();
        a.download = 'grafik-pengunjung-tahun-ini.png';
        a.click();
    }
});
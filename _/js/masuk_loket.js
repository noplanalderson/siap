/*
 * Check for browser support
 */
var supportMsg = document.getElementById('msg');

if ('speechSynthesis' in window) {
  supportMsg.innerHTML = '<div class="alert alert-success" id="msg" role="alert">Your browser <strong>supports</strong> speech synthesis.</div>';
} else {
  supportMsg.innerHTML = '<div class="alert alert-success" id="msg" role="alert">Sorry your browser <strong>does not support</strong> speech synthesis.<br>Try this in <a href="https://www.google.co.uk/intl/en/chrome/browser/canary.html">Chrome Canary</a>.</div>';
  supportMsg.classList.add('not-supported');
}

navigator.saysWho = (() => {
  const { userAgent } = navigator
  let match = userAgent.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || []
  var temp

  if (/trident/i.test(match[1])) {
    temp = /\brv[ :]+(\d+)/g.exec(userAgent) || []

    return `IE ${temp[1] || ''}`
  }

  if (match[1] === 'Chrome') {
    temp = userAgent.match(/\b(OPR|Edge)\/(\d+)/)

    if (temp !== null) {
      var b = temp.slice(1).join(' ').replace('OPR', 'Opera')
        return b.toString().split(' ')[0];
    }

    temp = userAgent.match(/\b(Edg)\/(\d+)/)

    if (temp !== null) {
      var b = temp.slice(1).join(' ').replace('Edg', 'Edge')
        return b.toString().split(' ')[0];
    }
  }

  match = match[2] ? [ match[1], match[2] ] : [ navigator.appName, navigator.appVersion, '-?' ]
  temp = userAgent.match(/version\/(\d+)/i)

  if (temp !== null) {
    match.splice(1, 1, temp[1])
  }

  return match.join(' ')
})()

// Fetch the list of voices and populate the voice options.
function loadVoices() {
  // Fetch the available voices.
  var voices = speechSynthesis.getVoices();
}

// Execute loadVoices.
loadVoices();

// Chrome loads voices asynchronously.
window.speechSynthesis.onvoiceschanged = function(e) {
  loadVoices();
};


// Create a new utterance for the specified text and add it to
// the queue.
function speak(text) {
  // Create a new instance of SpeechSynthesisUtterance.
  var msg = new SpeechSynthesisUtterance();
  
  // Set the text.
  msg.text = text;
  
  // Set the attributes.
  msg.volume = 1;
  msg.rate = 0.8;
  msg.pitch = 1;

  // If a voice has been selected, find the voice and set the
  // utterance instance's voice attribute.
    var v = (navigator.saysWho == 'Chrome') ? "Google Bahasa Indonesia" : "Microsoft Andika - Indonesian (Indonesia)";
    msg.voice = speechSynthesis.getVoices().filter(function(voice) { return voice.name == v; })[0];

  // Queue this utterance.
  window.speechSynthesis.speak(msg);
}

$('#close').on('click', function(e){
	e.preventDefault();

    $(this).prop('disabled', true);
    $(this).html('<i class="fas fa-spinner fa-spin"></i> Menutup Loket...');

	let counter_id = $(this).data('id');

    $.ajax({
        url: baseURI + 'admin/loket/status',
        type: 'post',
        data: {
            counter_id: counter_id,
            status: 'close',
            siap_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        dataType:'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Toast.fire({
               type : 'error',
               icon: 'error',
               title: 'Terjadi Kesalahan',
               operator: data,
            }); 
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
                setTimeout(function(){
                   window.top.close();
                }, 3000);
            }
        }
    });
})

$('#call').on('click', function(e) {
    e.preventDefault();

    $(this).prop('disabled', true);
    $(this).html('<i class="fas fa-spinner fa-spin"></i> Tunggu...');

    document.getElementById('audiobell').pause();
    document.getElementById('audiobell').currentTime = 0;
    document.getElementById('audiobell').play();

    totalWaktu = document.getElementById('audiobell').duration*800;
    setTimeout(function(){
        speak('Nomor Antrian '+$('#queue').text()+', di loket '+$('#counter_seq').val());

    }, totalWaktu);

    totalWaktu = totalWaktu+5000;
    setTimeout(function(){
        $('#call').prop('disabled', false);
        $('#call').html('<i class="fas fa-volume-up"></i> Panggil');
    }, totalWaktu);
})

$('#next').on('click', function(e) {
	e.preventDefault();

    $(this).prop('disabled', true);
    $(this).html('<i class="fas fa-spinner fa-spin"></i> Tunggu...');

	let counter_id = $(this).data('id');
    let transaction_id = $(this).data('queue');

    // setTimeout(function(){

        $.ajax({
            url: baseURI + 'admin/masuk-loket/'+counter_id,
            type: 'post',
            data: {
                counter_id: counter_id,
                transaction_id: transaction_id,
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

                if(data.result == 1) {
                    var data = data.transaksi;
                    if(data == null)
                    {
                        $('#queue').text('-');
                        $('#next').html('<i class="fas fa-forward"></i> Selanjutnya');
                        $('#next').prop('disabled', true);
                        $('#call').prop('disabled', true);
                    }
                    else
                    {
                        $('#queue').text(data.queue_num);
                        $('#next').data('queue', data.transaction_id);

                        $('#next').prop('disabled', false);
                        $('#call').prop('disabled', false);
                        $('#next').html('<i class="fas fa-forward"></i> Selanjutnya');
                    }

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
    // }, totalWaktu)
})

$('#refresh').on('click', function(e){
    e.preventDefault();
    window.location.reload();
})
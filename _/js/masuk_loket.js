$(function(){

    $.ajax({
        url: baseURI + 'admin/loket/status',
        type: 'post',
        data: {
            counter_id: $('#counter_id').val(),
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
        }
    });
})
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

// Get the voice select element.
var voiceSelect = document.getElementById('voice');

// Fetch the list of voices and populate the voice options.
function loadVoices() {
  // Fetch the available voices.
  var voices = speechSynthesis.getVoices();
  
  // Loop through each of the voices.
  voices.forEach(function(voice, i) {
    // Create a new option element.
    var option = document.createElement('option');
    
    // Set the options value and text.
    option.value = voice.name;
    option.innerHTML = voice.name;
      
    // Add the option to the voice selector.
    voiceSelect.appendChild(option);
  });
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
  if (voiceSelect.value) {
    msg.voice = speechSynthesis.getVoices().filter(function(voice) { return voice.name == "Google Bahasa Indonesia"; })[0];
  }

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
    $(this).html('<i class="fas fa-spinner fa-spin"></i> Memanggil...');

	let counter_id = $(this).data('id');

	document.getElementById('audiobell').pause();
    document.getElementById('audiobell').currentTime = 0;
    document.getElementById('audiobell').play();

    totalWaktu = document.getElementById('audiobell').duration*800;
    setTimeout(function(){
        speak('Nomor Antrian '+$('#queue').text()+', di loket '+$('#counter_seq').val());

    }, totalWaktu);

    totalWaktu = totalWaktu+5000;

    setTimeout(function(){

        $.ajax({
            url: baseURI + 'admin/masuk-loket/'+counter_id,
            type: 'post',
            data: {
                counter_id: counter_id,
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
                    $('#queue').text(data);

                    } else {
                    
                    Toast.fire({
                       type : 'error',
                       icon: 'error',
                       title: 'Terjadi Kesalahan',
                       operator: data.msg,
                    });  
                }

                $('#call').prop('disabled', false);
                $('#call').html('<i class="fas fa-volume-up"></i> Panggil');
            }
        });
    }, totalWaktu)
})
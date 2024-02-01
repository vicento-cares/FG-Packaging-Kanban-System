// jQuery document ready function
$(() => {
  $('#qr_id').focus();
  setInterval(input_qr_id_focus, 1000);
  $.validator.setDefaults({
    submitHandler: () => {
      let qr_id = $('#qr_id').val();
      var ip = getCookie('ip');

      $.ajax({
        url: 'process/auth/sign_in2.php',
        type: 'POST',
        cache: false,
        data: {
          id_no: qr_id,
          ip: ip
        }, 
        beforeSend: (jqXHR, settings) => {
          var loading = `<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" id="loading"></span>`;
          $("#login").prepend(loading);
          $('#login').attr('disabled', true);
          jqXHR.url = settings.url;
          jqXHR.type = settings.type;
        }, 
        success: response => {
          if (response == 'success') {
            window.location.href = "pages/request.php";
          } else {
            if (response == 'failed') {
              swal('Requestor Account Sign In', `Sign In Failed. Maybe an incorrect credential or account not found`, 'info').then(isConfirm => {$("#qr_id").val('');return false;});
            } else if (response == 'Wrong Section') {
              swal('Requestor Account Sign In Error', `Requestor Verification Failed. ID Scanned in WRONG Section`, 'error').then(isConfirm => {$("#qr_id").val('');return false;});
            } else if (response == 'Not Section') {
              swal('Requestor Account Sign In Error', `Requestor Verification Failed. ID Scanned NOT in Section`, 'error').then(isConfirm => {$("#qr_id").val('');return false;});
            } else {
              swal('Requestor Account Sign In Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
            }
            $("#loading").remove();
            $('#login').attr('disabled', false);
          }
        }
      })
      .fail((jqXHR, textStatus, errorThrown) => {
        console.log(jqXHR);
        swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
        $("#loading").remove();
        $('#login').attr('disabled', false);
      });
    }
  });
  $('#quickForm').validate({
    rules: {
      qr_id: {
        required: true
      }
    },
    messages: {
      qr_id: {
        required: "Please enter/scan ID Number"
      }
    },
    errorElement: 'span',
    errorPlacement: (error, element) => {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: (element, errorClass, validClass) => {
      $(element).addClass('is-invalid');
    },
    unhighlight: (element, errorClass, validClass) => {
      $(element).removeClass('is-invalid');
    }
  });
});

const input_qr_id_focus = () => {$('#qr_id').focus();}
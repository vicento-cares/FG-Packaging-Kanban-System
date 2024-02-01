$(() => {
  $.validator.setDefaults({
    submitHandler: () => {
      let username = $('#username').val();
      let password = $('#password').val();

      $.ajax({
        url: '../process/auth/sign_in.php',
        type: 'POST',
        cache: false,
        data: {
          username: username,
          password: password
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
            window.location.href = "pages/requested-packaging-materials.php";
          } else {
            if (response == 'failed') {
              swal('Account Sign In', `Sign In Failed. Maybe an incorrect credential or account not found`, 'info');
            } else {
              swal('Account Sign In Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
      username: {
        required: true
      },
      password: {
        required: true
      }
    },
    messages: {
      username: {
        required: "Please enter your username",
      },
      password: {
        required: "Please enter your password"
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
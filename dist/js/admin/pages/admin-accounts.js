// jQuery document ready function
$(() => {
  load_data(1);
  if (getCookie('role') != 'Admin') {
    $('#btnAddAdminAccount').attr('disabled', true);
    $('#btnDeleteAdminAccount').attr('disabled', true);
  }
  sessionStorage.setItem('saved_i_search', '');
  sessionStorage.setItem('notif_pending', 0);
  load_notification_fg();
  realtime_load_notification_fg = setInterval(load_notification_fg, 5000);
});

const get_details = el => {
  var id = $(el).data("id");
  var username = $(el).data("username");
  var name = $(el).data("name");
  var role = $(el).data("role");

  $("#u_id").val(id);
  $("#u_username").val(username);
  $("#u_name").val(name);
  $("#u_role").val(role).trigger('change');
}

const count_data = () => {
  var i_search = sessionStorage.getItem('saved_i_search');
  $.ajax({
    url: '../../process/admin/admin-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_data',
      search: i_search
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt($("#adminAccountData tr").length);
      let loader_count = $('#loader_count').val();
      if (i_search == '') {
        $('#counter_view_search').hide();
        $('#search_more_data').hide();
        let counter_view = "";
        if (total_rows != 0) {
          if (total_rows < 2) {
            counter_view = `${table_rows} row of ${total_rows} record`;
          } else {
            counter_view = `${table_rows} rows of ${total_rows} records`;
          }
          $('#counter_view').html(counter_view);
          $('#counter_view').show();
        } else {
          $('#counter_view').hide();
        }

        if (total_rows == 0) {
          $('#load_more_data').hide();
        } else if (total_rows > loader_count) {
          $('#load_more_data').show();
        } else if (total_rows <= loader_count) {
          $('#load_more_data').hide();
        }
      } else {
        $('#counter_view').hide();
        $('#load_more_data').hide();
        let counter_view = "";
        if (total_rows != 0) {
          let counter_view_search = "";
          if (total_rows < 2) {
            counter_view_search = `${total_rows} record found`;
            counter_view = `${table_rows} row of ${total_rows} record`;
          } else {
            counter_view_search = `${total_rows} records found`;
            counter_view = `${table_rows} rows of ${total_rows} records`;
          }
          $('#counter_view_search').html(counter_view_search);
          $('#counter_view_search').show();
          $('#counter_view').html(counter_view);
          $('#counter_view').show();
        } else {
          $('#counter_view_search').hide();
          $('#counter_view').hide();
        }

        if (total_rows == 0) {
          $('#search_more_data').hide();
        } else if (total_rows > loader_count) {
          $('#search_more_data').show();
        } else if (total_rows <= loader_count) {
          $('#search_more_data').hide();
        }
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const load_data = option => {
  var id = 0;
  var i_search = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 2:
      var id = $('#adminAccountTable tr:last').attr('id');
      var loader_count = parseInt($('#loader_count').val());
      break;
    case 3:
      var i_search = $.trim($('#i_search').val());
      if (i_search == '') {
        var continue_loading = false;
        swal('Admin Account Search', 'Fill out search input field', 'info');
      }
      break;
    case 4:
      var id = $('#adminAccountTable tr:last').attr('id');
      var i_search = sessionStorage.getItem('saved_i_search');
      var loader_count = parseInt($('#loader_count').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../../process/admin/admin-accounts_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'fetch_data',
        id: id,
        search: i_search,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="5" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            $('#adminAccountData').html(loading);
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            $('#adminAccountData').html(response);
            $('#loader_count').val(10);
            sessionStorage.setItem('saved_i_search', '');
            break;
          case 3:
            $('#adminAccountData').html(response);
            $('#loader_count').val(10);
            sessionStorage.setItem('saved_i_search', i_search);
            break;
          case 2:
          case 4:
            $("#adminAccountTable tbody").append(response);
            $('#loader_count').val(loader_count + 10);
            break;
          default:
        }
        count_data();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

$('#i_search').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_data(3);
  }
});

$("#AddAccountModal").on('hidden.bs.modal', e => {
  $('#i_username').val('');
  $('#i_password').val('');
  $('#i_name').val('');
  $('#i_role').val('').trigger('change');
});

const account_info_modal_hidden = () => {
  $("#u_id").val('');
  $("#u_username").val('');
  $('#u_password').val('');
  $('#u_name').val('');
  $('#u_role').val('').trigger('change');
}

const save_data = () => {
  var username = $.trim($('#i_username').val());
  var password = $.trim($('#i_password').val());
  var name = $.trim($('#i_name').val());
  var role = $('#i_role').find('option:selected').val();

  $.ajax({
    url: '../../process/admin/admin-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_data',
      username:username,
      password:password,
      name:name,
      role:role
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Admin Account', 'Loading please wait...', {
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
      });
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      setTimeout(() => {
        swal.close();
        if (response == 'success') {
          swal('Admin Account', 'Successfully Saved', 'success');
          load_data(1);
          $('#AddAccountModal').modal('hide');
        } else if (response == 'Invalid Username') {
          swal('Admin Account', 'Username should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters (-\'_.)', 'info');
        } else if (response == 'Invalid Password') {
          swal('Admin Account', 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.', 'info');
        } else if (response == 'Invalid Name') {
          swal('Admin Account', 'Name should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters (-\'.)', 'info');
        } else if (response == 'Role Not Set') {
          swal('Admin Account', 'Please set an Account Role', 'info');
        } else if (response == 'Unauthorized Access') {
          swal('Admin Account Error', 'Only Admin Role is allowed to do this changes', 'error');
        } else if (response == 'Username Exists') {
          swal('Admin Account', 'Username Exists', 'info');
        } else {
          console.log(response);
          swal('Admin Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const update_username = () => {
  var id = $.trim($('#u_id').val());
  var username = $.trim($('#u_username').val());

  $.ajax({
    url: '../../process/admin/admin-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_username',
      id:id,
      username:username
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Admin Account', 'Loading please wait...', {
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
      });
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      setTimeout(() => {
        swal.close();
        if (response == 'success') {
          swal('Admin Account', 'Username Changed Successfully', 'success');
          load_data(1);
          account_info_modal_hidden();
          $('#AccountInfoModal').modal('hide');
        } else if (response == 'Invalid Username') {
          swal('Admin Account', 'Username should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters (-\'_.)', 'info');
        } else if (response == 'Unauthorized Access') {
          swal('Admin Account Error', 'Only Admin Role is allowed to do this changes', 'error');
        } else if (response == 'Username Exists') {
          swal('Admin Account', 'Username Exists', 'info');
        } else {
          console.log(response);
          swal('Admin Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const update_password = () => {
  var id = $.trim($('#u_id').val());
  var password = $.trim($('#u_password').val());

  $.ajax({
    url: '../../process/admin/admin-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_password',
      id:id,
      password:password
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Admin Account', 'Loading please wait...', {
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
      });
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      setTimeout(() => {
        swal.close();
        if (response == 'success') {
          swal('Admin Account', 'Password Changed Successfully', 'success');
          load_data(1);
          account_info_modal_hidden();
          $('#AccountInfoModal').modal('hide');
        } else if (response == 'Invalid Password') {
          swal('Admin Account', 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.', 'info');
        } else if (response == 'Unauthorized Access') {
          swal('Admin Account Error', 'Only Admin Role is allowed to do this changes', 'error');
        } else {
          console.log(response);
          swal('Admin Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const update_data = () => {
  var id = $.trim($('#u_id').val());
  var name = $.trim($('#u_name').val());
  var role = $('#u_role').find('option:selected').val();

  $.ajax({
    url: '../../process/admin/admin-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_data',
      id:id,
      name:name,
      role:role
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Admin Account', 'Loading please wait...', {
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
      });
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      setTimeout(() => {
        swal.close();
        if (response == 'success') {
          swal('Admin Account', 'Account Updated Successfully', 'success');
          load_data(1);
          $('#user_panel_name').html(getCookie('name')); //current user new account name
          account_info_modal_hidden();
          $('#AccountInfoModal').modal('hide');
        } else if (response == 'Invalid Name') {
          swal('Admin Account', 'Name should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters (-\'.)', 'info');
        } else if (response == 'Role Not Set') {
          swal('Admin Account', 'Please set an Account Role', 'info');
        } else if (response == 'Unauthorized Access') {
          swal('Admin Account Error', 'Only Admin Role is allowed to do this changes', 'error');
        } else if (response == 'Own Account') {
          swal('Admin Account Error', 'You cannot set role to your own account!', 'error');
        } else {
          console.log(response);
          swal('Admin Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const delete_data = () => {
  var id = $.trim($('#u_id').val());

  $.ajax({
    url: '../../process/admin/admin-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_data',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Admin Account', 'Loading please wait...', {
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
      });
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      setTimeout(() => {
        swal.close();
        if (response == 'success') {
          swal('Admin Account', 'Data Deleted', 'info');
          load_data(1);
          account_info_modal_hidden();
          $('#deleteDataModal').modal('hide');
        } else if (response == 'Own Account') {
          swal('Admin Account Error', 'You cannot delete your own account!', 'error');
          $('#deleteDataModal').modal('hide');
          $('#AccountInfoModal').modal('show');
        } else if (response == 'Unauthorized Access') {
          swal('Admin Account Error', 'Only Admin Role is allowed to do this changes', 'error');
          $('#deleteDataModal').modal('hide');
          $('#AccountInfoModal').modal('show');
        } else {
          console.log(response);
          swal('Admin Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
// jQuery document ready function
$(() => {
  get_line_datalist();
  get_section_dropdown();
  get_car_model_dropdown();
  get_factory_area_dropdown();
  load_data(1);
  sessionStorage.setItem('saved_i_search', '');
  sessionStorage.setItem('notif_pending', 0);
  load_notification_fg();
  realtime_load_notification_fg = setInterval(load_notification_fg, 5000);
});

const get_line_datalist = () => {
  $.ajax({
    url: '../../process/admin/route-number_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_line_datalist'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_lines').html(response);
      $('#u_lines').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_section_dropdown = () => {
  $.ajax({
    url: '../../process/admin/section_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_section_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_section').html(response);
      $('#u_section').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_car_model_dropdown = () => {
  $.ajax({
    url: '../../process/admin/car-model_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_car_model_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_car_model').html(response);
      $('#u_car_model').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_factory_area_dropdown = () => {
  $.ajax({
    url: '../../process/admin/factory-area_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_factory_area_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_factory_area').html(response);
      $('#u_factory_area').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details = el => {
  var id = $(el).data("id");
  var id_no = $(el).data("id_no");
  var name = $(el).data("name");
  var section = $(el).data("section");
  var car_model = $(el).data("car_model");
  var line_no = $(el).data("line_no");
  var factory_area = $(el).data("factory_area");
  var requestor = $(el).data("requestor");

  $("#u_id").val(id);
  $("#u_id_no").val(id_no);
  $("#u_name").val(name);
  $("#u_section").val(section).trigger('change');
  $("#u_car_model").val(car_model);
  $("#u_line_no").val(line_no);
  $("#u_factory_area").val(factory_area);
  $("#u_requestor").val(requestor);
}

const count_data = () => {
  var i_search = sessionStorage.getItem('saved_i_search');
  $.ajax({
    url: '../../process/admin/requestor-accounts_processor.php',
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
      let table_rows = parseInt($("#requestorAccountData tr").length);
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
      var id = $('#requestorAccountTable tr:last').attr('id');
      var loader_count = parseInt($('#loader_count').val());
      break;
    case 3:
      var i_search = $.trim($('#i_search').val());
      if (i_search == '') {
        var continue_loading = false;
        swal('Requestor Account Search', 'Fill out search input field', 'info');
      }
      break;
    case 4:
      var id = $('#requestorAccountTable tr:last').attr('id');
      var i_search = sessionStorage.getItem('saved_i_search');
      var loader_count = parseInt($('#loader_count').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../../process/admin/requestor-accounts_processor.php',
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
            var loading = `<tr><td colspan="8" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            $('#requestorAccountData').html(loading);
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            $('#requestorAccountData').html(response);
            $('#loader_count').val(10);
            sessionStorage.setItem('saved_i_search', '');
            break;
          case 3:
            $('#requestorAccountData').html(response);
            $('#loader_count').val(10);
            sessionStorage.setItem('saved_i_search', i_search);
            break;
          case 2:
          case 4:
            $("#requestorAccountTable tbody").append(response);
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

$("#AddRAccountModal").on('hidden.bs.modal', e => {
  $("#i_id_no").val('');
  $('#i_name').val('');
  $('#i_section').val('').trigger('change');
  $('#i_car_model').val('').trigger('change');
  $('#i_line_no').val('');
  $('#i_factory_area').val('').trigger('change');
  $('#i_requestor').val('');
});

const clear_r_account_info_fields = () => {
  $("#u_id").val('');
  $("#u_id_no").val('');
  $('#u_name').val('');
  $('#u_section').val('').trigger('change');
  $('#u_car_model').val('').trigger('change');
  $('#u_line_no').val('');
  $('#u_factory_area').val('').trigger('change');
  $('#u_requestor').val('');
}

const get_route_details = action => {
  var line_no = '';
  if (action == 'insert') {
    var line_no = $.trim($('#i_line_no').val());
  } else if (action == 'update') {
    var line_no = $.trim($('#u_line_no').val());
  }
  if (line_no != '') {
    $.ajax({
      url: '../../process/admin/route-number_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_route_details',
        line_no:line_no
      }, 
      beforeSend: (jqXHR, settings) => {
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        try {
          let response_array = JSON.parse(response);
          if (action == 'insert') {
            $('#i_line_no').val(response_array.line_no);
            $("#i_section").val(response_array.section).trigger('change');
            $("#i_car_model").val(response_array.car_model).trigger('change');
            $("#i_factory_area").val(response_array.factory_area).trigger('change');
          } else if (action == 'update') {
            $('#u_line_no').val(response_array.line_no);
            $("#u_section").val(response_array.section).trigger('change');
            $("#u_car_model").val(response_array.car_model).trigger('change');
            $("#u_factory_area").val(response_array.factory_area).trigger('change');
          }
        } catch(e) {
          console.log(response);
          swal('Requestor Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const save_data = () => {
  var id_no = $.trim($('#i_id_no').val());
  var name = $.trim($('#i_name').val());
  var section = $('#i_section').find('option:selected').val();
  var car_model = $('#i_car_model').find('option:selected').val();
  var line_no = $.trim($('#i_line_no').val());
  var factory_area = $('#i_factory_area').find('option:selected').val();
  var requestor = $.trim($('#i_requestor').val());

  $.ajax({
    url: '../../process/admin/requestor-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_data',
      id_no:id_no,
      name:name,
      section:section,
      car_model:car_model,
      line_no:line_no,
      factory_area:factory_area,
      requestor:requestor
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Requestor Account', 'Loading please wait...', {
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
          swal('Requestor Account', 'Successfully Saved', 'success');
          load_data(1);
          $('#AddRAccountModal').modal('hide');
        } else if (response == 'Invalid ID No.') {
          swal('Requestor Account', 'ID No. should be at least 8 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters: (-)', 'info');
        } else if (response == 'Invalid Name') {
          swal('Requestor Account', 'Name should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters (-\'.)', 'info');
        } else if (response == 'Section Not Set') {
          swal('Requestor Account', 'Please set Section', 'info');
        } else if (response == 'Car Model Empty') {
          swal('Requestor Account', 'Please fill out Car Model Field', 'info');
        } else if (response == 'Invalid Line No.') {
          swal('Requestor Account', 'Line No. should be at least 2 characters in length. It should not begin, trailing or end with Special Characters. Allowed Special Characters: \'(\' and \')\'', 'info');
        } else if (response == 'Factory Area Not Set') {
          swal('Requestor Account', 'Please set Factory Area', 'info');
        } else if (response == 'Invalid Requestor') {
          swal('Requestor Account', 'Requestor should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters: (-)', 'info');
        } else if (response == 'Line No. Doesn\'t Exists') {
          swal('Requestor Account', `Cannot Add New Requestor Account. Line No. Doesn't Exists!`, 'error');
        } else if (response == 'ID No. Exists') {
          swal('Requestor Account', 'ID No. Exists', 'info');
        } else {
          console.log(response);
          swal('Requestor Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const update_id_no = () => {
  var id = $.trim($('#u_id').val());
  var id_no = $.trim($('#u_id_no').val());

  $.ajax({
    url: '../../process/admin/requestor-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_id_no',
      id:id,
      id_no:id_no
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Requestor Account', 'Loading please wait...', {
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
          swal('Requestor Account', 'Successfully Updated', 'success');
          load_data(1);
          clear_r_account_info_fields();
          $('#RAccountInfoModal').modal('hide');
        } else if (response == 'Invalid ID No.') {
          swal('Requestor Account', 'ID No. should be at least 8 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters: (-)', 'info');
        } else if (response == 'ID No. Exists') {
          swal('Requestor Account', 'ID No. Exists', 'info');
        } else {
          console.log(response);
          swal('Requestor Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
  var section = $('#u_section').find('option:selected').val();
  var car_model = $('#u_car_model').find('option:selected').val();
  var line_no = $.trim($('#u_line_no').val());
  var factory_area = $('#u_factory_area').find('option:selected').val();
  var requestor = $.trim($('#u_requestor').val());

  $.ajax({
    url: '../../process/admin/requestor-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_data',
      id:id,
      name:name,
      section:section,
      car_model:car_model,
      line_no:line_no,
      factory_area:factory_area,
      requestor:requestor
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Requestor Account', 'Loading please wait...', {
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
          swal('Requestor Account', 'Successfully Updated', 'success');
          load_data(1);
          clear_r_account_info_fields();
          $('#RAccountInfoModal').modal('hide');
        } else if (response == 'Invalid Name') {
          swal('Requestor Account', 'Name should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters (-\'.)', 'info');
        } else if (response == 'Section Not Set') {
          swal('Requestor Account', 'Please set Section', 'info');
        } else if (response == 'Car Model Empty') {
          swal('Requestor Account', 'Please fill out Car Model Field', 'info');
        } else if (response == 'Invalid Line No.') {
          swal('Requestor Account', 'Line No. should be at least 2 characters in length. It should not begin, trailing or end with Special Characters. Allowed Special Characters: \'(\' and \')\'', 'info');
        } else if (response == 'Factory Area Not Set') {
          swal('Requestor Account', 'Please set Factory Area', 'info');
        } else if (response == 'Invalid Requestor') {
          swal('Requestor Account', 'Requestor should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters: (-)', 'info');
        } else if (response == 'Line No. Doesn\'t Exists') {
          swal('Requestor Account', `Cannot Update Requestor Account. Line No. Doesn't Exists!`, 'error');
        } else {
          console.log(response);
          swal('Requestor Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
    url: '../../process/admin/requestor-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_data',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Requestor Account', 'Loading please wait...', {
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
          swal('Requestor Account Information', 'Data Deleted', 'info');
          load_data(1);
          clear_r_account_info_fields();
          $('#deleteDataModal').modal('hide');
        } else {
          console.log(response);
          swal('Requestor Account Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
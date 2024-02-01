// jQuery document ready function
$(() => {
  get_line_datalist();
  get_items_datalist();
  get_items_dropdown();
  get_section_dropdown();
  get_area_dropdown();
  load_data(1);
  sessionStorage.setItem('saved_i_search_line_no', '');
  sessionStorage.setItem('saved_i_search_item_no', '');
  sessionStorage.setItem('saved_i_search_item_name', '');
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
      $('#i_search_lines').html(response);
      $('#i_lines').html(response);
      $('#u_lines').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_items_datalist = () => {
  $.ajax({
    url: '../../process/admin/packaging-materials_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_items_datalist'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_search_items').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_items_dropdown = () => {
  $.ajax({
    url: '../../process/admin/packaging-materials_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_items_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_item_name').html(response);
      $('#u_item_name').html(response);
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

const get_area_dropdown = () => {
  $.ajax({
    url: '../../process/admin/storage-area_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_area_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_storage_area').html(response);
      $('#u_storage_area').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details = el => {
  var id = $(el).data("id");
  var batch_no = $(el).data("batch_no");
  var kanban = $(el).data("kanban");
  var kanban_no = $(el).data("kanban_no");
  var serial_no = $(el).data("serial_no");
  var item_no = $(el).data("item_no");
  var item_name = $(el).data("item_name");
  var section = $(el).data("section");
  var line_no = $(el).data("line_no");
  var dimension = $(el).data("dimension");
  var size = $(el).data("size");
  var color = $(el).data("color");
  var quantity = $(el).data("quantity");
  var storage_area = $(el).data("storage_area");
  var req_limit = $(el).data("req_limit");
  var req_limit_qty = $(el).data("req_limit_qty");
  var req_limit_time = $(el).data("req_limit_time");

  $("#u_id").val(id);
  $("#u_item_no").val(item_no);
  $("#u_item_name").val(item_no).trigger('change');
  $("#u_section").val(section).trigger('change');
  $("#u_line_no").val(line_no);
  $("#u_dimension").val(dimension);
  $("#u_size").val(size);
  $("#u_color").val(color);
  $("#u_quantity").val(quantity);
  $("#u_storage_area").val(storage_area).trigger('change');
  $("#u_batch_no").val(batch_no);
  $("#u_kanban_no").val(kanban_no);
  $("#u_req_limit").val(req_limit);
  $("#u_req_limit_qty").val(req_limit_qty);
  $("#u_req_limit_time").val(req_limit_time);
}

const count_data = () => {
  var line_no = sessionStorage.getItem('saved_i_search_line_no');
  var item_no = sessionStorage.getItem('saved_i_search_item_no');
  var item_name = sessionStorage.getItem('saved_i_search_item_name');
  $.ajax({
    url: '../../process/admin/kanban-registration_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_data',
      line_no: line_no,
      item_no: item_no,
      item_name: item_name
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt($("#kanbanRegData tr").length);
      let loader_count = $('#loader_count').val();
      if (line_no == '' && item_no == '' && item_name == '') {
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
  var line_no = '';
  var item_no = '';
  var item_name = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 2:
      var id = $('#kanbanRegTable tr:last').attr('id');
      var loader_count = parseInt($('#loader_count').val());
      break;
    case 3:
      var line_no = $.trim($('#i_search_line_no').val());
      var item_no = $.trim($('#i_search_item_no').val());
      var item_name = $.trim($('#i_search_item_name').val());
      if (line_no == '' && item_no == '' && item_name == '') {
        var continue_loading = false;
        swal('Kanban Registration Search', 'Fill out search input field', 'info');
      }
      break;
    case 4:
      var id = $('#kanbanRegTable tr:last').attr('id');
      var line_no = sessionStorage.getItem('saved_i_search_line_no');
      var item_no = sessionStorage.getItem('saved_i_search_item_no');
      var item_name = sessionStorage.getItem('saved_i_search_item_name');
      var loader_count = parseInt($('#loader_count').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../../process/admin/kanban-registration_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'fetch_data',
        id: id,
        line_no: line_no,
        item_no: item_no,
        item_name: item_name,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="7" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            $('#kanbanRegData').html(loading);
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            $('#kanbanRegData').html(response);
            $('#loader_count').val(25);
            sessionStorage.setItem('saved_i_search_line_no', '');
            sessionStorage.setItem('saved_i_search_item_no', '');
            sessionStorage.setItem('saved_i_search_item_name', '');
            break;
          case 3:
            $('#kanbanRegData').html(response);
            $('#loader_count').val(25);
            sessionStorage.setItem('saved_i_search_line_no', line_no);
            sessionStorage.setItem('saved_i_search_item_no', item_no);
            sessionStorage.setItem('saved_i_search_item_name', item_name);
            break;
          case 2:
          case 4:
            $("#kanbanRegTable tbody").append(response);
            $('#loader_count').val(loader_count + 25);
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

$('#i_search_line_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_data(3);
  }
});

$('#i_search_item_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_data(3);
  }
});

$('#i_search_item_name').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_data(3);
  }
});

$("#AddKanbanModal").on('hidden.bs.modal', e => {
  $('#i_item_name').val('').trigger('change');
  $('#i_section').val('').trigger('change');
  $('#i_line_no').val('');
  $("#i_dimension").val('');
  $("#i_size").val('');
  $("#i_color").val('');
  $("#i_quantity").val('');
  $("#i_storage_area").val('').trigger('change');
  $("#i_req_limit").val('');
});

const clear_kanban_info_fields = () => {
  $("#u_id").val('');
  $('#u_item_no').val('');
  $('#u_item_name').val('').trigger('change');
  $('#u_section').val('').trigger('change');
  $('#u_line_no').val('');
  $("#u_dimension").val('');
  $("#u_size").val('');
  $("#u_color").val('');
  $("#u_quantity").val('');
  $("#u_storage_area").val('').trigger('change');
  $("#u_kanban_no").val('');
  $("#u_req_limit").val('');
  $("#u_req_limit_qty").val('');
  $("#u_req_limit_time").val('');
}

const get_item_details = action => {
  var item_no = '';
  if (action == 'insert') {
    var item_no = $('#i_item_name').find('option:selected').val();
  } else if (action == 'update') {
    var item_no = $('#u_item_name').find('option:selected').val();
  }
  if (item_no != '') {
    $.ajax({
      url: '../../process/admin/packaging-materials_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_item_details',
        item_no:item_no
      }, 
      beforeSend: (jqXHR, settings) => {
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        try {
          let response_array = JSON.parse(response);
          if (action == 'insert') {
            $("#i_dimension").val(response_array.dimension);
            $("#i_size").val(response_array.size);
            $("#i_color").val(response_array.color);
            $("#i_quantity").val(response_array.quantity);
          } else if (action == 'update') {
            $("#u_dimension").val(response_array.dimension);
            $("#u_size").val(response_array.size);
            $("#u_color").val(response_array.color);
            $("#u_quantity").val(response_array.quantity);
          }
        } catch(e) {
          console.log(response);
          swal('Kanban Registration Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
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
          } else if (action == 'update') {
            $('#u_line_no').val(response_array.line_no);
            $("#u_section").val(response_array.section).trigger('change');
          }
        } catch(e) {
          console.log(response);
          swal('Kanban Registration Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
  var item_no = $('#i_item_name').find('option:selected').val();
  var item_name = $('#i_item_name').find('option:selected').text();
  var section = $('#i_section').find('option:selected').val();
  var line_no = $.trim($('#i_line_no').val());
  var dimension = $.trim($('#i_dimension').val());
  var size = $.trim($('#i_size').val());
  var color = $.trim($('#i_color').val());
  var quantity = $.trim($('#i_quantity').val());
  var storage_area = $('#i_storage_area').find('option:selected').val();
  var req_limit = $.trim($('#i_req_limit').val());

  $.ajax({
    url: '../../process/admin/kanban-registration_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_data',
      item_no:item_no,
      item_name:item_name,
      section:section,
      line_no:line_no,
      dimension:dimension,
      size:size,
      color:color,
      quantity:quantity,
      storage_area:storage_area,
      req_limit:req_limit
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Kanban Registration', 'Loading please wait...', {
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
          swal('Kanban Registration', 'Successfully Saved', 'success');
          load_data(1);
          $('#AddKanbanModal').modal('hide');
        } else if (response == 'Item Name Not Set') {
          swal('Kanban Registration', 'Please set Item Name', 'info');
        } else if (response == 'Invalid Line No.') {
          swal('Kanban Registration', 'Line No. should be at least 2 characters in length. It should not begin, trailing or end with Special Characters. Allowed Special Characters: \'(\' and \')\'', 'info');
        } else if (response == 'Area Not Set') {
          swal('Kanban Registration', 'Please set Storage Area', 'info');
        } else if (response == 'Zero Quantity') {
          swal('Kanban Registration', `Cannot Proceed with Zero, Negative, Non Numerical or No Quantity`, 'info');
        } else if (response == 'Line No. Doesn\'t Exists') {
          swal('Kanban Registration', `Cannot Register Kanban. Line No. Doesn't Exists!`, 'error');
        } else {
          console.log(response);
          swal('Kanban Registration Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
  var item_no = $('#u_item_name').find('option:selected').val();
  var item_name = $('#u_item_name').find('option:selected').text();
  var section = $('#u_section').find('option:selected').val();
  var line_no = $.trim($('#u_line_no').val());
  var dimension = $.trim($('#u_dimension').val());
  var size = $.trim($('#u_size').val());
  var color = $.trim($('#u_color').val());
  var quantity = $.trim($('#u_quantity').val());
  var storage_area = $('#u_storage_area').find('option:selected').val();
  var req_limit = $.trim($('#u_req_limit').val());
  var req_limit_time = $.trim($('#u_req_limit_time').val());

  $.ajax({
    url: '../../process/admin/kanban-registration_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_data',
      id:id,
      item_no:item_no,
      item_name:item_name,
      section:section,
      line_no:line_no,
      dimension:dimension,
      size:size,
      color:color,
      quantity:quantity,
      storage_area:storage_area,
      req_limit:req_limit,
      req_limit_time:req_limit_time
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Kanban Registration', 'Loading please wait...', {
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
          swal('Kanban Registration', 'Successfully Updated', 'success');
          load_data(1);
          clear_kanban_info_fields();
          $('#KanbanInfoModal').modal('hide');
        } else if (response == 'Item Name Not Set') {
          swal('Kanban Registration', 'Please set Item Name', 'info');
        } else if (response == 'Invalid Line No.') {
          swal('Kanban Registration', 'Line No. should be at least 2 characters in length. It should not begin, trailing or end with Special Characters. Allowed Special Characters: \'(\' and \')\'', 'info');
        } else if (response == 'Area Not Set') {
          swal('Kanban Registration', 'Please set Storage Area', 'info');
        } else if (response == 'Zero Limit') {
          swal('Kanban Registration', `Cannot Proceed with Zero, Negative, Non Numerical or No Request Limit`, 'info');
        } else if (response == 'Zero Quantity') {
          swal('Kanban Registration', `Cannot Proceed with Zero, Negative, Non Numerical or No Quantity`, 'info');
        } else if (response == 'Line No. Doesn\'t Exists') {
          swal('Kanban Registration', `Cannot Register Kanban. Line No. Doesn't Exists!`, 'error');
        } else {
          console.log(response);
          swal('Kanban Registration Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
    url: '../../process/admin/kanban-registration_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_data',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Kanban Registration', 'Loading please wait...', {
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
          swal('Kanban Registration', 'Data Deleted', 'info');
          load_data(1);
          clear_kanban_info_fields();
          $('#deleteDataModal').modal('hide');
        } else {
          console.log(response);
          swal('Kanban Registration Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const download_format = () => {
  window.open('../../process/export/export_kanban_reg_format.php','_blank');
}

$("#UploadCsvModal").on('hidden.bs.modal', e => {
  $('#file').val('');
});

const upload_csv = () => {
  var form_data = new FormData();
  var ins = document.getElementById('file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('file').files[x]);
  }
  $.ajax({
    url: '../../process/import/import_kanban_reg.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    beforeSend: (jqXHR, settings) => {
      swal('Upload CSV', 'Loading please wait...', {
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
        if (response != '') {
          swal('Upload CSV', `Error: ${response}`, 'error');
        } else {
          swal('Upload CSV', 'Uploaded and updated successfully', 'success');
          load_data(1);
          $('#UploadCsvModal').modal('hide');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const print_single_kanban = () => {
  var id = $.trim($('#u_id').val());
  var kanban_printing_query = 'id='+id;
  $('#kanban_printing_option').val(1);
  $('#kanban_printing_query').val(kanban_printing_query);
  $('#PrintKanbanModal').modal('show');
}
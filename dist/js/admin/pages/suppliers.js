// jQuery document ready function
$(() => {
  load_data(1);
  sessionStorage.setItem('saved_i_search', '');
  sessionStorage.setItem('notif_pending', 0);
  load_notification_fg();
  realtime_load_notification_fg = setInterval(load_notification_fg, 5000);
});

const get_details = el => {
  var id = $(el).data("id");
  var supplier_name = $(el).data("supplier_name");

  $("#u_id").val(id);
  $("#u_supplier_name").val(supplier_name);
}

const count_data = () => {
  var i_search = sessionStorage.getItem('saved_i_search');
  $.ajax({
    url: '../../process/admin/suppliers_processor.php',
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
      let table_rows = parseInt($("#suppliersData tr").length);
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
      var id = $('#suppliersTable tr:last').attr('id');
      var loader_count = parseInt($('#loader_count').val());
      break;
    case 3:
      var i_search = $.trim($('#i_search').val());
      if (i_search == '') {
        var continue_loading = false;
        swal('Suppliers Search', 'Fill out search input field', 'info');
      }
      break;
    case 4:
      var id = $('#suppliersTable tr:last').attr('id');
      var i_search = sessionStorage.getItem('saved_i_search');
      var loader_count = parseInt($('#loader_count').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../../process/admin/suppliers_processor.php',
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
            var loading = `<tr><td colspan="3" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            $('#suppliersData').html(loading);
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            $('#suppliersData').html(response);
            $('#loader_count').val(10);
            sessionStorage.setItem('saved_i_search', '');
            break;
          case 3:
            $('#suppliersData').html(response);
            $('#loader_count').val(10);
            sessionStorage.setItem('saved_i_search', i_search);
            break;
          case 2:
          case 4:
            $("#suppliersTable tbody").append(response);
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

$("#AddSuppliersModal").on('hidden.bs.modal', e => {
  $("#i_supplier_name").val('');
});

const clear_suppliers_info_fields = () => {
  $("#u_id").val('');
  $("#u_supplier_name").val('');
}

const save_data = () => {
  var supplier_name = $.trim($('#i_supplier_name').val());

  $.ajax({
    url: '../../process/admin/suppliers_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_data',
      supplier_name:supplier_name
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Suppliers', 'Loading please wait...', {
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
          swal('Suppliers', 'Successfully Saved', 'success');
          load_data(1);
          $('#AddSuppliersModal').modal('hide');
        } else if (response == 'Invalid Supplier') {
          swal('Suppliers', 'Supplier Name should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters (-\'_.)', 'info');
        } else if (response == 'Duplicate') {
          swal('Route Number', 'Cannot Add Duplicate Record. This Record Already Exists.', 'info');
        } else {
          console.log(response);
          swal('Suppliers Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
  var supplier_name = $.trim($('#u_supplier_name').val());

  $.ajax({
    url: '../../process/admin/suppliers_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_data',
      id:id,
      supplier_name:supplier_name
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Suppliers', 'Loading please wait...', {
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
          swal('Suppliers', 'Successfully Updated', 'success');
          load_data(1);
          clear_suppliers_info_fields();
          $('#SuppliersInfoModal').modal('hide');
        } else if (response == 'Invalid Supplier') {
          swal('Suppliers', 'Supplier Name should be at least 2 characters in length. It should not begin, trailing or end with Special Characters or Whitespaces. Allowed Special Characters (-\'_.)', 'info');
        } else if (response == 'Already Exists') {
          swal('Suppliers', 'Supplier Name Already Exists', 'info');
        } else {
          console.log(response);
          swal('Suppliers Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
    url: '../../process/admin/suppliers_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_data',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Suppliers', 'Loading please wait...', {
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
          swal('Suppliers Information', 'Data Deleted', 'info');
          load_data(1);
          clear_suppliers_info_fields();
          $('#deleteDataModal').modal('hide');
        } else {
          console.log(response);
          swal('Suppliers Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
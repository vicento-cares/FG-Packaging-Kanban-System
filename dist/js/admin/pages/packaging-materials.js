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
  var item_no = $(el).data("item_no");
  var item_name = $(el).data("item_name");
  var dimension = $(el).data("dimension");
  var size = $(el).data("size");
  var color = $(el).data("color");
  var pcs_bundle = $(el).data("pcs_bundle");
  var req_quantity = $(el).data("req_quantity");

  $("#u_id").val(id);
  $("#u_item_no").val(item_no);
  $("#u_item_name").val(item_name);
  $("#u_dimension").val(dimension);
  $("#u_size").val(size);
  $("#u_color").val(color);
  $("#u_pcs_bundle").val(pcs_bundle);
  $("#u_req_quantity").val(req_quantity);
}

const count_data = () => {
  var i_search = sessionStorage.getItem('saved_i_search');
  $.ajax({
    url: '../../process/admin/packaging-materials_processor.php',
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
      let table_rows = parseInt($("#packagingMaterialsData tr").length);
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
      var id = $('#packagingMaterialsTable tr:last').attr('id');
      var loader_count = parseInt($('#loader_count').val());
      break;
    case 3:
      var i_search = $.trim($('#i_search').val());
      if (i_search == '') {
        var continue_loading = false;
        swal('Packaging Materials Search', 'Fill out search input field', 'info');
      }
      break;
    case 4:
      var id = $('#packagingMaterialsTable tr:last').attr('id');
      var i_search = sessionStorage.getItem('saved_i_search');
      var loader_count = parseInt($('#loader_count').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../../process/admin/packaging-materials_processor.php',
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
            var loading = `<tr><td colspan="6" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            $('#packagingMaterialsData').html(loading);
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            $('#packagingMaterialsData').html(response);
            $('#loader_count').val(10);
            sessionStorage.setItem('saved_i_search', '');
            break;
          case 3:
            $('#packagingMaterialsData').html(response);
            $('#loader_count').val(10);
            sessionStorage.setItem('saved_i_search', i_search);
            break;
          case 2:
          case 4:
            $("#packagingMaterialsTable tbody").append(response);
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

$("#AddPackagingMaterialsModal").on('hidden.bs.modal', e => {
  $("#i_item_no").val('');
  $('#i_item_name').val('');
  $('#i_dimension').val('');
  $('#i_size').val('');
  $('#i_color').val('');
  $('#i_pcs_bundle').val('');
  $('#i_req_quantity').val('').trigger('change');
});

const clear_pkg_materials_info_fields = () => {
  $("#u_id").val('');
  $("#u_item_no").val('');
  $('#u_item_name').val('');
  $('#u_dimension').val('');
  $('#u_size').val('');
  $('#u_color').val('');
  $('#u_pcs_bundle').val('');
  $('#u_req_quantity').val('').trigger('change');
}

const save_data = () => {
  var item_no = $.trim($('#i_item_no').val());
  var item_name = $.trim($('#i_item_name').val());
  var dimension = $.trim($('#i_dimension').val());
  var size = $.trim($('#i_size').val());
  var color = $.trim($('#i_color').val());
  var pcs_bundle = $.trim($('#i_pcs_bundle').val());
  var req_quantity = $('#i_req_quantity').find('option:selected').val();

  $.ajax({
    url: '../../process/admin/packaging-materials_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_data',
      item_no:item_no,
      item_name:item_name,
      dimension:dimension,
      size:size,
      color:color,
      pcs_bundle:pcs_bundle,
      req_quantity:req_quantity
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Packaging Materials', 'Loading please wait...', {
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
          swal('Packaging Materials', 'Successfully Saved', 'success');
          load_data(1);
          $('#AddPackagingMaterialsModal').modal('hide');
        } else if (response == 'Invalid Item No.') {
          swal('Packaging Materials', 'Item No. should be numerical characters', 'info');
        } else if (response == 'Invalid Item Name') {
          swal('Packaging Materials', 'Item Name should be at least 8 characters in length', 'info');
        } else if (response == 'Invalid Pcs Bundle') {
          swal('Packaging Materials', 'Pcs / Bundle should be at least 3 characters in length', 'info');
        } else if (response == 'Req Qty Not Set') {
          swal('Packaging Materials', 'Please set Req Quantity', 'info');
        } else if (response == 'Already Exists') {
          swal('Packaging Materials', 'Item Name Already Exists', 'info');
        } else {
          console.log(response);
          swal('Packaging Materials Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
  var item_no = $.trim($('#u_item_no').val());
  var item_name = $.trim($('#u_item_name').val());
  var dimension = $.trim($('#u_dimension').val());
  var size = $.trim($('#u_size').val());
  var color = $.trim($('#u_color').val());
  var pcs_bundle = $.trim($('#u_pcs_bundle').val());
  var req_quantity = $('#u_req_quantity').find('option:selected').val();

  $.ajax({
    url: '../../process/admin/packaging-materials_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_data',
      id:id,
      item_no:item_no,
      item_name:item_name,
      dimension:dimension,
      size:size,
      color:color,
      pcs_bundle:pcs_bundle,
      req_quantity:req_quantity
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Packaging Materials', 'Loading please wait...', {
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
          swal('Packaging Materials', 'Successfully Updated', 'success');
          load_data(1);
          clear_pkg_materials_info_fields();
          $('#PackagingMaterialsInfoModal').modal('hide');
        } else if (response == 'Invalid Item Name') {
          swal('Packaging Materials', 'Item Name should be at least 8 characters in length', 'info');
        } else if (response == 'Invalid Pcs Bundle') {
          swal('Packaging Materials', 'Pcs / Bundle should be at least 3 characters in length', 'info');
        } else if (response == 'Req Qty Not Set') {
          swal('Packaging Materials', 'Please set Req Quantity', 'info');
        } else if (response == 'Already Exists') {
          swal('Packaging Materials', 'Item Name Already Exists', 'info');
        } else {
          console.log(response);
          swal('Packaging Materials Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
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
  var item_no = $.trim($('#u_item_no').val());

  $.ajax({
    url: '../../process/admin/packaging-materials_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_data',
      id:id,
      item_no:item_no
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Packaging Materials', 'Loading please wait...', {
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
          swal('Packaging Materials Information', 'Data Deleted', 'info');
          load_data(1);
          clear_pkg_materials_info_fields();
          $('#deleteDataModal').modal('hide');
        } else if (response == 'Not Empty') {
          swal('Packaging Materials Info', `The inventory of this item from all storage areas are not empty`, 'info');
          $('#PackagingMaterialsInfoModal').modal('show');
          $('#deleteDataModal').modal('hide');
        } else if (response == 'Kanban Exists') {
          swal('Packaging Materials Info', `Registered Kanban of this item still exists. Please remove all Registered Kanban associated with this item before deletion.`, 'info');
          $('#PackagingMaterialsInfoModal').modal('show');
          $('#deleteDataModal').modal('hide');
        } else {
          console.log(response);
          swal('Packaging Materials Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
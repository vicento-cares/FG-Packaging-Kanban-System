// jQuery document ready function
$(() => {
  get_area_dropdown_fg();
  get_items_datalist();
  sessionStorage.setItem('search_store_in_date_from', '');
  sessionStorage.setItem('search_store_in_date_to', '');
  sessionStorage.setItem('search_si_storage_area', '');
  sessionStorage.setItem('search_si_item_no', '');
  sessionStorage.setItem('search_si_item_name', '');
  sessionStorage.setItem('search_store_out_date_from', '');
  sessionStorage.setItem('search_store_out_date_to', '');
  sessionStorage.setItem('search_so_storage_area', '');
  sessionStorage.setItem('search_so_remarks', '');
  sessionStorage.setItem('search_so_item_no', '');
  sessionStorage.setItem('search_so_item_name', '');
  sessionStorage.setItem('notif_pending', 0);
  load_notification_fg();
  realtime_load_notification_fg = setInterval(load_notification_fg, 5000);
});

const get_area_dropdown_fg = () => {
  $.ajax({
    url: '../../process/admin/storage-area_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_area_dropdown_fg'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#si_storage_area').html(response);
      $('#so_storage_area').html(response);
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
      $('#si_items').html(response);
      $('#so_items').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const count_store_in = () => {
  var store_in_date_from = sessionStorage.getItem('search_store_in_date_from');
  var store_in_date_to = sessionStorage.getItem('search_store_in_date_to');
  var storage_area = sessionStorage.getItem('search_si_storage_area');
  var item_no = sessionStorage.getItem('search_si_item_no');
  var item_name = sessionStorage.getItem('search_si_item_name');

  $.ajax({
    url: '../../process/admin/inventory-history_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_store_in',
      store_in_date_from:store_in_date_from,
      store_in_date_to:store_in_date_to,
      storage_area:storage_area,
      item_no:item_no,
      item_name:item_name
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt($("#siInvHistoryData tr").length);
      let loader_count = $('#loader_count').val();
      $('#counter_view').hide();
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
        $('#btnExportSiInvHistoryCsv').attr('disabled', false);
      } else {
        $('#counter_view_search').hide();
        $('#counter_view').hide();
        $('#btnExportSiInvHistoryCsv').attr('disabled', true);
      }

      if (total_rows == 0) {
        $('#search_more_data').hide();
      } else if (total_rows > loader_count) {
        $('#search_more_data').show();
      } else if (total_rows <= loader_count) {
        $('#search_more_data').hide();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const count_store_out = () => {
  var store_out_date_from = sessionStorage.getItem('search_store_out_date_from');
  var store_out_date_to = sessionStorage.getItem('search_store_out_date_to');
  var storage_area = sessionStorage.getItem('search_so_storage_area');
  var remarks = sessionStorage.getItem('search_so_remarks');
  var item_no = sessionStorage.getItem('search_so_item_no');
  var item_name = sessionStorage.getItem('search_so_item_name');

  $.ajax({
    url: '../../process/admin/inventory-history_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_store_out',
      store_out_date_from:store_out_date_from,
      store_out_date_to:store_out_date_to,
      storage_area:storage_area,
      remarks:remarks,
      item_no:item_no,
      item_name:item_name
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt($("#soInvHistoryData tr").length);
      let loader_count2 = $('#loader_count2').val();
      $('#counter_view2').hide();
      let counter_view2 = "";
      if (total_rows != 0) {
        let counter_view_search2 = "";
        if (total_rows < 2) {
          counter_view_search2 = `${total_rows} record found`;
          counter_view2 = `${table_rows} row of ${total_rows} record`;
        } else {
          counter_view_search2 = `${total_rows} records found`;
          counter_view2 = `${table_rows} rows of ${total_rows} records`;
        }
        $('#counter_view_search2').html(counter_view_search2);
        $('#counter_view_search2').show();
        $('#counter_view2').html(counter_view2);
        $('#counter_view2').show();
        $('#btnExportSoInvHistoryCsv').attr('disabled', false);
      } else {
        $('#counter_view_search2').hide();
        $('#counter_view2').hide();
        $('#btnExportSoInvHistoryCsv').attr('disabled', true);
      }

      if (total_rows == 0) {
        $('#search_more_data2').hide();
      } else if (total_rows > loader_count2) {
        $('#search_more_data2').show();
      } else if (total_rows <= loader_count2) {
        $('#search_more_data2').hide();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_si_inventory_history = option => {
  var id = 0;
  var store_in_date_from = '';
  var store_in_date_to = '';
  var storage_area = '';
  var item_no = '';
  var item_name = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var store_in_date_from = $.trim($('#store_in_date_from').val());
      var store_in_date_to = $.trim($('#store_in_date_to').val());
      var storage_area = $('#si_storage_area').find('option:selected').val();
      var item_no = $.trim($('#si_item_no').val());
      var item_name = $.trim($('#si_item_name').val());
      if (store_in_date_from == '' && store_in_date_to == '') {
        var continue_loading = false;
        swal('Store In History Search', 'Fill out date fields to search for', 'info');
      }
      break;
    case 2:
      var id = $('#siInvHistoryTable tr:last').attr('id');
      var store_in_date_from = sessionStorage.getItem('search_store_in_date_from');
      var store_in_date_to = sessionStorage.getItem('search_store_in_date_to');
      var storage_area = sessionStorage.getItem('search_si_storage_area');
      var item_no = sessionStorage.getItem('search_si_item_no');
      var item_name = sessionStorage.getItem('search_si_item_name');
      var loader_count = parseInt($('#loader_count').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../../process/admin/inventory-history_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_si_inventory_history',
        id: id,
        store_in_date_from:store_in_date_from,
        store_in_date_to:store_in_date_to,
        storage_area:storage_area,
        item_no:item_no,
        item_name:item_name,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        if (option == 1) {
          var loading = `<tr><td colspan="15" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
          $('#siInvHistoryData').html(loading);
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            $('#siInvHistoryData').html(response);
            $('#loader_count').val(25);
            sessionStorage.setItem('search_store_in_date_from', store_in_date_from);
            sessionStorage.setItem('search_store_in_date_to', store_in_date_to);
            sessionStorage.setItem('search_si_storage_area', storage_area);
            sessionStorage.setItem('search_si_item_no', item_no);
            sessionStorage.setItem('search_si_item_name', item_name);
            break;
          case 2:
            $("#siInvHistoryTable tbody").append(response);
            $('#loader_count').val(loader_count + 25);
            break;
          default:
        }
        count_store_in();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const get_so_inventory_history = option => {
  var id = 0;
  var store_out_date_from = '';
  var store_out_date_to = '';
  var storage_area = '';
  var remarks = '';
  var item_no = '';
  var item_name = '';
  var loader_count2 = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var store_out_date_from = $.trim($('#store_out_date_from').val());
      var store_out_date_to = $.trim($('#store_out_date_to').val());
      var storage_area = $('#so_storage_area').find('option:selected').val();
      var remarks = $('#so_remarks').find('option:selected').val();
      var item_no = $.trim($('#so_item_no').val());
      var item_name = $.trim($('#so_item_name').val());
      if (store_out_date_from == '' && store_out_date_to == '') {
        var continue_loading = false;
        swal('Store Out Request History Search', 'Fill out date fields to search for', 'info');
      }
      break;
    case 2:
      var id = $('#soInvHistoryTable tr:last').attr('id');
      var store_out_date_from = sessionStorage.getItem('search_store_out_date_from');
      var store_out_date_to = sessionStorage.getItem('search_store_out_date_to');
      var storage_area = sessionStorage.getItem('search_so_storage_area');
      var remarks = sessionStorage.getItem('search_so_remarks');
      var item_no = sessionStorage.getItem('search_so_item_no');
      var item_name = sessionStorage.getItem('search_so_item_name');
      var loader_count2 = parseInt($('#loader_count2').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../../process/admin/inventory-history_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_so_inventory_history',
        id: id,
        store_out_date_from:store_out_date_from,
        store_out_date_to:store_out_date_to,
        storage_area:storage_area,
        remarks:remarks,
        item_no:item_no,
        item_name:item_name,
        c: loader_count2
      }, 
      beforeSend: (jqXHR, settings) => {
        if (option == 1) {
          var loading = `<tr><td colspan="10" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
          $('#soInvHistoryData').html(loading);
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            $('#soInvHistoryData').html(response);
            $('#loader_count2').val(25);
            sessionStorage.setItem('search_store_out_date_from', store_out_date_from);
            sessionStorage.setItem('search_store_out_date_to', store_out_date_to);
            sessionStorage.setItem('search_so_storage_area', storage_area);
            sessionStorage.setItem('search_so_remarks', remarks);
            sessionStorage.setItem('search_so_item_no', item_no);
            sessionStorage.setItem('search_so_item_name', item_name);
            break;
          case 2:
            $("#soInvHistoryTable tbody").append(response);
            $('#loader_count2').val(loader_count2 + 25);
            break;
          default:
        }
        count_store_out();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

$('#si_item_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_si_inventory_history(1);
  }
});

$('#si_item_name').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_si_inventory_history(1);
  }
});

$('#so_item_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_so_inventory_history(1);
  }
});

$('#so_item_name').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_so_inventory_history(1);
  }
});

const export_si_inventory_history = () => {
  var store_in_date_from = sessionStorage.getItem('search_store_in_date_from');
  var store_in_date_to = sessionStorage.getItem('search_store_in_date_to');
  var storage_area = sessionStorage.getItem('search_si_storage_area');
  var item_no = sessionStorage.getItem('search_si_item_no');
  var item_name = sessionStorage.getItem('search_si_item_name');

  window.open('../../process/export/export_si_inventory_history.php?store_in_date_from='+store_in_date_from+'&&store_in_date_to='+store_in_date_to+'&&storage_area='+storage_area+'&&item_no='+item_no+'&&item_name='+item_name,'_blank');
}

const export_so_inventory_history = () => {
  var store_out_date_from = sessionStorage.getItem('search_store_out_date_from');
  var store_out_date_to = sessionStorage.getItem('search_store_out_date_to');
  var storage_area = sessionStorage.getItem('search_so_storage_area');
  var remarks = sessionStorage.getItem('search_so_remarks');
  var item_no = sessionStorage.getItem('search_so_item_no');
  var item_name = sessionStorage.getItem('search_so_item_name');

  window.open('../../process/export/export_so_inventory_history.php?store_out_date_from='+store_out_date_from+'&&store_out_date_to='+store_out_date_to+'&&storage_area='+storage_area+'&&remarks='+remarks+'&&item_no='+item_no+'&&item_name='+item_name,'_blank');
}

const po_no_details = el => {
  var id = $(el).data("id");
  var po_no = $(el).data("po_no");

  $("#u_store_in_id").val(id);
  $("#u_store_in_po_no").val(po_no);
}

$("#StoreInPoNoDetailsModal").on('hidden.bs.modal', e => {
  $("#u_store_in_id").val('');
  $("#u_store_in_po_no").val('');
});

const update_po_no = () => {
  var id = $.trim($('#u_store_in_id').val());
  var po_no = $.trim($('#u_store_in_po_no').val());

  $.ajax({
    url: '../../process/admin/inventory-history_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_po_no',
      id:id,
      po_no:po_no
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Store In History', 'Loading please wait...', {
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
          swal('Store In History', 'Successfully Updated', 'success');
          get_si_inventory_history();
          $('#StoreInPoNoDetailsModal').modal('hide');
        } else {
          console.log(response);
          swal('Store In History Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
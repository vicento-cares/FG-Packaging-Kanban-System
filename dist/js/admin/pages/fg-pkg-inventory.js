// jQuery document ready function
$(() => {
  get_area_dropdown_fg();
  get_items_datalist();
  get_items_dropdown();
  get_suppliers_dropdown();
  get_area_dropdown();
  sessionStorage.setItem('notif_pending', 0);
  load_notification_fg();
  realtime_load_notification_fg = setInterval(load_notification_fg, 5000);
});

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
      $('#inv_items').html(response);
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
      $('#si_item_name').html(response);
      $('#so_item_name').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_suppliers_dropdown = () => {
  $.ajax({
    url: '../../process/admin/suppliers_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_suppliers_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#si_supplier_name').html(response);
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
      $('#si_storage_area').html(response);
      $('#so_storage_area').html(response);
      $('#so_to_storage_area').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

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
      $('#inv_storage_area').html(response);
      get_inventory(1);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details = el => {
  var id = $(el).data("id");
  var item_no = $(el).data("item_no");
  var item_name = $(el).data("item_name");
  var storage_area = $(el).data("storage_area");
  var quantity = $(el).data("quantity");
  var safety_stock = $(el).data("safety_stock");

  $("#u_id").val(id);
  $("#u_item_no").val(item_no);
  $("#u_item_name").val(item_name);
  $("#u_quantity").val(quantity);
  $("#u_storage_area").val(storage_area).trigger('change');
  $("#u_safety_stock").val(safety_stock);
}

const count_inventory = () => {
  var storage_area = sessionStorage.getItem('search_inv_storage_area');
  var item_no = sessionStorage.getItem('search_inv_item_no');
  var item_name = sessionStorage.getItem('search_inv_item_name');

  $.ajax({
    url: '../../process/admin/inventory_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_inventory',
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
      let table_rows = parseInt($("#fgPkgInvData tr").length);
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
        $('#btnExportFgPkgInvCsv').attr('disabled', false);
        $('#btnRefreshFgPkgInv').attr('disabled', false);
      } else {
        $('#counter_view_search').hide();
        $('#counter_view').hide();
        $('#btnExportFgPkgInvCsv').attr('disabled', true);
        $('#btnRefreshFgPkgInv').attr('disabled', true);
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

const get_inventory = option => {
  var id = 0;
  var storage_area = '';
  var item_no = '';
  var item_name = '';
  var loader_count = 0;
  switch (option) {
    case 1:
      var storage_area = $('#inv_storage_area').find('option:selected').val();
      var item_no = $.trim($('#inv_item_no').val());
      var item_name = $.trim($('#inv_item_name').val());
      break;
    case 2:
      var id = $('#fgPkgInvTable tr:last').attr('id');
      var storage_area = sessionStorage.getItem('search_inv_storage_area');
      var item_no = sessionStorage.getItem('search_inv_item_no');
      var item_name = sessionStorage.getItem('search_inv_item_name');
      var loader_count = parseInt($('#loader_count').val());
      break;
    case 3:
      var storage_area = sessionStorage.getItem('search_inv_storage_area');
      var item_no = sessionStorage.getItem('search_inv_item_no');
      var item_name = sessionStorage.getItem('search_inv_item_name');
      break;
    default:
  }
  $.ajax({
    url: '../../process/admin/inventory_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_inventory',
      id: id,
      storage_area:storage_area,
      item_no:item_no,
      item_name:item_name,
      c: loader_count
    }, 
    beforeSend: (jqXHR, settings) => {
      switch (option) {
        case 1:
        case 3:
          var loading = `<tr><td colspan="6" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
          $('#fgPkgInvData').html(loading);
          break;
        default:
      }
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      switch (option) {
        case 1:
        case 3:
          $('#fgPkgInvData').html(response);
          $('#loader_count').val(50);
          sessionStorage.setItem('search_inv_storage_area', storage_area);
          sessionStorage.setItem('search_inv_item_no', item_no);
          sessionStorage.setItem('search_inv_item_name', item_name);
          break;
        case 2:
          $("#fgPkgInvTable tbody").append(response);
          $('#loader_count').val(loader_count + 50);
          break;
        default:
      }
      count_inventory();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$('#inv_item_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_inventory(1);
  }
});

$('#inv_item_name').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_inventory(1);
  }
});

$("#FgPkgInvInfoModal").on('hidden.bs.modal', e => {
  $("#u_id").val('');
  $('#u_item_no').val('');
  $('#u_item_name').val('');
  $("#u_storage_area").val('');
  $("#u_quantity").val(''); 
  $("#u_safety_stock").val('');
});

const update_safety_stock = () => {
  var id = $.trim($('#u_id').val());
  var safety_stock = $.trim($('#u_safety_stock').val());

  $.ajax({
    url: '../../process/admin/inventory_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_safety_stock',
      id:id,
      safety_stock:safety_stock
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response == 'success') {
        swal('FG Packaging Inventory', 'Successfully Updated', 'success');
        get_inventory(1);
        $('#FgPkgInvInfoModal').modal('hide');
      } else if (response == 'Zero Quantity') {
        swal('FG Packaging Inventory', `Cannot Proceed with Negative, Non Numerical or No Safety Stock`, 'info');
      } else {
        console.log(response);
        swal('FG Packaging Inventory Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$("#FgPkgInvStoreInModal").on('hidden.bs.modal', e => {
  $('#si_item_name').val('').trigger('change');
  $('#si_supplier_name').val('').trigger('change');
  $("#si_invoice_no").val('');
  $("#si_po_no").val('');
  $("#si_dr_no").val('');
  $("#si_quantity").val('');
  $("#si_storage_area").val('').trigger('change');
  $("#si_delivery_date_time").val('');
  $('#si_reason').each((i, el) => {
    el.checked = false;
  });
});

$("#FgPkgInvTransferModal").on('hidden.bs.modal', e => {
  $('#so_item_name').val('').trigger('change');
  $("#so_quantity").val('');
  $("#so_storage_area").val('').trigger('change');
  $("#so_to_storage_area").val('').trigger('change');
});

const store_in = () => {
  var item_no = $('#si_item_name').find('option:selected').val();
  var item_name = $('#si_item_name').find('option:selected').text();
  var supplier_name = $('#si_supplier_name').find('option:selected').val();
  var invoice_no = $.trim($('#si_invoice_no').val());
  var po_no = $.trim($('#si_po_no').val());
  var dr_no = $.trim($('#si_dr_no').val());
  var quantity = $.trim($('#si_quantity').val());
  var storage_area = $('#si_storage_area').find('option:selected').val();
  var delivery_date_time = $.trim($('#si_delivery_date_time').val());
  var reason = '';
  $('#si_reason:checked').each((i, el) => {
    reason = $(el).val();
  });

  $.ajax({
    url: '../../process/admin/inventory_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'store_in',
      item_no:item_no,
      item_name:item_name,
      supplier_name:supplier_name,
      invoice_no:invoice_no,
      po_no:po_no,
      dr_no:dr_no,
      quantity:quantity,
      storage_area:storage_area,
      reason:reason,
      delivery_date_time:delivery_date_time
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Store In', 'Loading please wait...', {
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
          swal('Store In', 'Stored In Successfully', 'success');
          get_inventory(1);
          $('#FgPkgInvStoreInModal').modal('hide');
        } else if (response == 'Item Name Not Set') {
          swal('Store In', 'Please set Item Name', 'info');
        } else if (response == 'Supplier Not Set') {
          swal('Store In', 'Please set Supplier Name', 'info');
        } else if (response == 'Area Not Set') {
          swal('Store In', 'Please set Storage Area', 'info');
        } else if (response == 'Invoice No. Empty') {
          swal('Store In', 'Please fill out Invoice No. Field', 'info');
        } else if (response == 'PO No. Empty') {
          swal('Store In', 'PO No. is required. The reason set needs PO No. to continue store in', 'info');
        } else if (response == 'DR No. Empty') {
          swal('Store In', 'Please fill out DR No. Field', 'info');
        } else if (response == 'Zero Quantity') {
          swal('Store In', `Cannot Proceed with Zero, Negative, Non Numerical or No Quantity`, 'info');
        } else if (response == 'Exists') {
          swal('Store In Error', `Cannot Proceed to Store In. Record Exists!`, 'error');
        } else {
          console.log(response);
          swal('Store In Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const transfer = () => {
  var item_no = $('#so_item_name').find('option:selected').val();
  var item_name = $('#so_item_name').find('option:selected').text();
  var quantity = $.trim($('#so_quantity').val());
  var storage_area = $('#so_storage_area').find('option:selected').val();
  var to_storage_area = $('#so_to_storage_area').find('option:selected').val();

  $.ajax({
    url: '../../process/admin/inventory_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'transfer',
      item_no:item_no,
      item_name:item_name,
      quantity:quantity,
      storage_area:storage_area,
      to_storage_area:to_storage_area
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Transfer', 'Loading please wait...', {
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
          swal('Transfer', 'Stored Out Successfully', 'success');
          get_inventory(1);
          $('#FgPkgInvTransferModal').modal('hide');
        } else if (response == 'Item Name Not Set') {
          swal('Transfer', 'Please set Item Name', 'info');
        } else if (response == 'Area Not Set') {
          swal('Transfer', 'Please set Storage Area', 'info');
        } else if (response == 'To Area Not Set') {
          swal('Transfer', 'Please set To Storage Area', 'info');
        } else if (response == 'Zero Quantity') {
          swal('Transfer', `Cannot Proceed with Zero, Negative, Non Numerical or No Quantity`, 'info');
        } else if (response == 'Insufficient Stock') {
          swal('Transfer Error', `Cannot Transfer with Insufficient Stock. The quantity to be transfered is greater than the actual item quantity.`, 'error');
        } else {
          console.log(response);
          swal('Transfer Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const export_fg_pkg_inv = () => {
  var storage_area = sessionStorage.getItem('search_inv_storage_area');
  var item_no = sessionStorage.getItem('search_inv_item_no');
  var item_name = sessionStorage.getItem('search_inv_item_name');

  window.open('../../process/export/export_fg_pkg_inv.php?storage_area='+storage_area+'&&item_no='+item_no+'&&item_name='+item_name,'_blank');
}
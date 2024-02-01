// Global Variables for Realtime Tables
var realtime_display_pending_on_section;
var realtime_display_ongoing_on_section;
var realtime_display_so_on_section;
var realtime_display_scanned; // global variable for realtime request modal table

$(() => {
  display_pending_on_section();
  display_ongoing_on_section();
  display_so_on_section();
  realtime_display_pending_on_section = setInterval(display_pending_on_section, 15000);
  realtime_display_ongoing_on_section = setInterval(display_ongoing_on_section, 30000);
  realtime_display_so_on_section = setInterval(display_so_on_section, 30000);
  sessionStorage.setItem('notif_ongoing', 0);
  sessionStorage.setItem('notif_store_out', 0);
  $('#RequestModal').modal("show");
  load_notification_section_req();
  realtime_load_notification_section_req = setInterval(load_notification_section_req, 30000);
  update_notification_section();
});

const display_pending_on_section = () => {
  var section = getCookie('section');
  $.ajax({
    url: '../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'display_pending_on_section',
      section:section,
      c:0
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);

        $('#pendingRequestData').html(response_array.data);

        var total_rows = parseInt(response_array.total);
        var total_rows_req = parseInt(response_array.total_req);

        if (total_rows != 0) {
          let counter_view_search = "";
          if (total_rows < 2) {
            counter_view_search = `<b>${total_rows}</b> Total Pending Request`;
          } else {
            counter_view_search = `<b>${total_rows}</b> Total Pending Requests`;
          }
          $('#counter_view_search').html(counter_view_search);
          $('#counter_view_search').show();
        } else {
          $('#counter_view_search').hide();
        }

        if (total_rows_req != 0) {
          let counter_view_search_req = "";
          if (total_rows_req < 2) {
            counter_view_search_req = `<b>${total_rows_req}</b> Total Pending Request Group`;
          } else {
            counter_view_search_req = `<b>${total_rows_req}</b> Total Pending Request Groups`;
          }
          $('#counter_view_search_req').html(counter_view_search_req);
          $('#counter_view_search_req').show();
        } else {
          $('#counter_view_search_req').hide();
        }
      } catch(e) {
        console.log(response);
        console.log(`Pending Request Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_display_pending_on_fg);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const display_ongoing_on_section = () => {
  var section = getCookie('section');
  $.ajax({
    url: '../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'display_ongoing_on_section',
      section:section,
      c:0
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);

        $('#ongoingRequestData').html(response_array.data);

        var total_rows = parseInt(response_array.total);
        var total_rows_req = parseInt(response_array.total_req);

        if (total_rows != 0) {
          let counter_view_search2 = "";
          if (total_rows < 2) {
            counter_view_search2 = `<b>${total_rows}</b> Total Ongoing Request`;
          } else {
            counter_view_search2 = `<b>${total_rows}</b> Total Ongoing Requests`;
          }
          $('#counter_view_search2').html(counter_view_search2);
          $('#counter_view_search2').show();
        } else {
          $('#counter_view_search2').hide();
        }

        if (total_rows_req != 0) {
          let counter_view_search_req2 = "";
          if (total_rows_req < 2) {
            counter_view_search_req2 = `<b>${total_rows_req}</b> Total Ongoing Request Group`;
          } else {
            counter_view_search_req2 = `<b>${total_rows_req}</b> Total Ongoing Request Groups`;
          }
          $('#counter_view_search_req2').html(counter_view_search_req2);
          $('#counter_view_search_req2').show();
        } else {
          $('#counter_view_search_req2').hide();
        }
      } catch(e) {
        console.log(response);
        console.log(`Ongoing Request Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_display_ongoing_on_section);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const display_so_on_section = () => {
  var section = getCookie('section');
  $.ajax({
    url: '../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'display_so_on_section',
      section:section,
      c:0
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#soRequestData').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_display_so_on_section);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

$('#pendingRequestTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('table-primary');
});

$('#ongoingRequestTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('table-warning');
});

$('#soRequestTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('table-success');
});

const view_pending_request_details = request_id => {
  $('#pendingRequestDetailsData').html('');
  $.ajax({
    url: '../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'view_pending_request_details',
      request_id:request_id
    }, 
    beforeSend: (jqXHR, settings) => {
      var loading = `<tr><td colspan="9" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
      $('#pendingRequestDetailsData').html(loading);
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        $('#pendingRequestDetailsData').html(response_array.data);
        $("#pending_requestor_name").html(response_array.requestor_name);
      } catch(e) {
        console.log(response);
        swal('Pending Request Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const view_ongoing_request_details = el => {
  var request_id = $(el).data("request_id");
  $('#ongoingRequestDetailsData').html('');
  $.ajax({
    url: '../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'view_ongoing_request_details',
      request_id:request_id
    }, 
    beforeSend: (jqXHR, settings) => {
      var loading = `<tr><td colspan="9" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
      $('#ongoingRequestDetailsData').html(loading);
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        $('#ongoingRequestDetailsData').html(response_array.data);
        $("#ongoing_requestor_name").html(response_array.requestor_name);
      } catch(e) {
        console.log(response);
        swal('Ongoing Request Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const view_so_request_details = el => {
  var request_id = $(el).data("request_id");
  $('#soRequestDetailsData').html('');
  $.ajax({
    url: '../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'view_so_request_details',
      request_id:request_id
    }, 
    beforeSend: (jqXHR, settings) => {
      var loading = `<tr><td colspan="12" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
      $('#soRequestDetailsData').html(loading);
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        $('#soRequestDetailsData').html(response_array.data);
        $("#so_requestor_name").html(response_array.requestor_name);
      } catch(e) {
        console.log(response);
        swal('Stored Out Request Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const i_kanban_focus = () => {
  setTimeout(() => {
    $('#i_kanban').focus();
  }, 100);
}

const recursive_realtime_display_scanned = () => {
  load_recent_scanned();
  realtime_display_scanned = setTimeout(recursive_realtime_display_scanned, 10000);
}

$("#RequestModal").on('show.bs.modal', e => {
  var requestor_id_no = getCookie('id_no');
  var requestor_name = getCookie('requestor_name');
  var requestor = getCookie('requestor');
  var request_id = getCookie('request_id');
  $('#verified_id_no').val(requestor_id_no);
  $('#verified_requestor_name').val(requestor_name);
  $('#verified_requestor').val(requestor);
  $('#i_request_id').val(request_id);
  i_kanban_focus();
  recursive_realtime_display_scanned();
});

$("#RequestModal").on('hidden.bs.modal', e => {
  clearTimeout(realtime_display_scanned);
});

// Revisions (Vince)
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

$('#i_kanban').on("keyup", e => {
  delay(function(){
    if (e.which === 13){
      e.preventDefault();
      scanned_action();
    } else if ($("#i_kanban").val().length < 256) {
      $("#i_kanban").val("");
    }
  }, 100);
});

const load_recent_scanned = () => {
  var requestor_id_no = getCookie('id_no');
  var section = getCookie('section');

  $.ajax({
    url: '../process/requestor/requestor-request_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'load_recent_scanned',
      section: section,
      requestor_id_no: requestor_id_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        $('#i_request_id').val(response);
        display_scanned();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearTimeout(realtime_display_scanned);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

// Check and Create Request
const scanned_action = () => {
  var kanban = $.trim($('#i_kanban').val());
  var requestor_id_no = $.trim($('#verified_id_no').val());
  var requestor_name = $.trim($('#verified_requestor_name').val());
  var requestor = $.trim($('#verified_requestor').val());
  var request_id = $.trim($('#i_request_id').val());
  var section = getCookie('section');
  $.ajax({
    url: '../process/requestor/requestor-request_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'scanned_action',
      kanban:kanban,
      requestor_id_no:requestor_id_no,
      requestor_name:requestor_name,
      requestor:requestor,
      request_id:request_id,
      section:section
    }, 
    beforeSend: (jqXHR, settings) => {
      var loading = `Scan Kanban<span class="spinner-border spinner-border-sm ml-1" role="status" aria-hidden="true" id="loading"></span>`;
      $("#scan_kanban").html(loading);
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response == 'Please Scan Kanban') {
        swal('Request Info', `Please Scan Kanban`, 'info', {timer: 2000}).then(isConfirm => {$("#i_kanban").val('');i_kanban_focus();return false;});
      } else if (response == 'Invalid Kanban') {
        swal('Request Error', `Invalid Kanban!!! If this happens again, call IT personnel immediately!`, 'error', {timer: 2000}).then(isConfirm => {$("#i_kanban").val('');i_kanban_focus();return false;});
      } else if (response == 'Duplicated Entry') {
        swal('Request Info', `Duplicated Entry`, 'info', {timer: 2000}).then(isConfirm => {$("#i_kanban").val('');i_kanban_focus();return false;});
      } else if (response == 'Already Requested') {
        swal('Request Info', `Already Requested`, 'info', {timer: 2000}).then(isConfirm => {$("#i_kanban").val('');i_kanban_focus();return false;});
      } else if (response == 'Unregistered') {
        swal('Request Error', `Unregistered Kanban/Serial No.`, 'error', {timer: 2000}).then(isConfirm => {$("#i_kanban").val('');i_kanban_focus();return false;});
      } else if (response == 'Wrong Section') {
        swal('Request Error', `Kanban/Serial No. Scanned In WRONG Section`, 'error', {timer: 2000}).then(isConfirm => {$("#i_kanban").val('');i_kanban_focus();return false;});
      } else if (response == 'Multiple Line No.') {
        swal('Request Error', `Multiple Line No. Error!!! Cannot accept kanban that has different Line No. on your recent scanned kanban. Replace recent scanned kanban with this kanban or make a new request for this packaging material.`, 'error', {timer: 2000}).then(isConfirm => {$("#i_kanban").val('');i_kanban_focus();return false;});
      } else if (response == 'Multiple Same Item') {
        swal('Request Error', `Multiple Same Item Error!!! Not duplicated entry but cannot accept kanban that has similar packaging material name on your recent scanned kanban. Replace recent scanned kanban with this kanban or make a new request for this packaging material.`, 'error', {timer: 2000}).then(isConfirm => {$("#i_kanban").val('');i_kanban_focus();return false;});
      } else if (response == 'Request Limit Reached') {
        swal('Request Error', `Request Limit Reached!!! Request for this packaging material reaches its limit! Try again later or contact FG Personnel for more details.`, 'error', {timer: 2000}).then(isConfirm => {$("#i_kanban").val('');i_kanban_focus();return false;});
      } else {
        try {
          let response_array = JSON.parse(response);
          if (response_array.message == 'success') {
            $('#i_request_id').val(response_array.request_id);
            display_scanned();
          } else {
            swal('Request Error', `Error: ${response_array.message}`, 'error');
          }
          console.log(response_array.message);
          $('#i_kanban').val('');
          i_kanban_focus();
        } catch(e) {
          console.log(response);
          swal('Request Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
      $("#loading").remove();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    $("#loading").remove();
  });
}

// Display Request on Table
const display_scanned = () => {
  var request_id = $.trim($('#i_request_id').val());
   $.ajax({
    url: '../process/requestor/requestor-request_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'display_scanned',
      request_id:request_id
    }, 
    beforeSend: (jqXHR, settings) => {
      var loading = `Scan Kanban<span class="spinner-border spinner-border-sm ml-1" role="status" aria-hidden="true" id="loading"></span>`;
      $("#scan_kanban").html(loading);
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        if (response_array.message == 'success') {
          $('#scannedKanbanData').html(response_array.data);
          $('#current_request_id_shown').html(request_id);
          let table_rows = parseInt($("#scannedKanbanData tr").length);
          $('#current_total_kanban').html(table_rows);
          if (table_rows > 0) {
            $('#btnRequestScannedKanban').attr('disabled', false);
          } else {
            $('#btnRequestScannedKanban').attr('disabled', true);
          }
        }
      } catch(e) {
        console.log(response);
        console.log(`Request Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $("#loading").remove();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearTimeout(realtime_display_scanned);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
    $("#loading").remove();
  });
}

// Request Quantity
const quantity_details_section = el => {
  var request_id = $(el).data("request_id");
  var id = $(el).data("id");
  var quantity = $(el).data("quantity");
  var fixed_quantity = $(el).data("fixed_quantity");

  $.ajax({
    url: '../process/requestor/requestor-request_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'quantity_details_section',
      id:id,
      request_id:request_id
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        $('#i_request_limit_quantity').html(response);
        $('#i_req_limit_qty_row').show();
      } else {
        $('#i_req_limit_qty_row').hide();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
  $("#i_request_id_2").val(request_id);
  $("#i_request_quantity_id").val(id);
  $("#i_request_quantity").val(quantity);
  $('#i_request_quantity_max').html(fixed_quantity);
  $('#RequestQtyDetailsSectionModal').modal({backdrop: 'static', keyboard: false});
}

// Request Quantity
const update_request_quantity = () => {
  var id = $.trim($("#i_request_quantity_id").val());
  var request_id = $.trim($("#i_request_id_2").val());
  var quantity = $.trim($("#i_request_quantity").val());
  $.ajax({
    url: '../process/requestor/requestor-request_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_request_quantity',
      id:id,
      request_id:request_id,
      quantity:quantity
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Quantity', 'Loading please wait...', {
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
          swal('Quantity', 'Quantity Updated Successfully', 'success');
          display_scanned();
          $('#RequestQtyDetailsSectionModal').modal('hide');
          $('#RequestModal').modal('show');
        } else if (response == 'Zero Quantity') {
          swal('Quantity', `Cannot Proceed with Negative, Non Numerical or No Quantity`, 'info');
        } else if (response == 'Over Quantity') {
          swal('Quantity Error', `Cannot Save Quantity greater than previous quantity. Max Quantity is the Default Quantity Set on Kanban`, 'error');
        } else {
          console.log(response);
          swal('Quantity Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

// Remarks Modal
const remarks_details_section = el => {
  var id = $(el).data("id");
  var request_id = $(el).data("request_id");
  var kanban = $(el).data("kanban");
  var kanban_no = $(el).data("kanban_no");
  var serial_no = $(el).data("serial_no");
  var requestor_name = $(el).data("requestor_name");
  var scan_date_time = $(el).data("scan_date_time");
  var has_requestor_remarks = $(el).data("has_requestor_remarks");
  var is_history = $(el).data("is_history");
  var data_target = $(el).data("data_target");
  $('#btnRequestRemarksDetailsSectionModalClose1').attr('data-target', data_target);
  $('#btnRequestRemarksDetailsSectionModalClose2').attr('data-target', data_target);

  if (has_requestor_remarks == 1) {
    $.ajax({
      url: '../process/requestor/remarks_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_requestor_remarks',
        request_id:request_id,
        kanban:kanban,
        serial_no:serial_no
      }, 
      beforeSend: (jqXHR, settings) => {
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        try {
          let response_array = JSON.parse(response);
          if (response_array.message == 'success') {
            $('#requestor_remarks_id').val(response_array.requestor_remarks_id);
            $('#i_requestor_remarks').val(response_array.requestor_remarks);
            sessionStorage.setItem('saved_requestor_remarks', response_array.requestor_remarks);
            $('#remarks_requestor_date_time').html(response_array.requestor_date_time);
            $("#remarks_requestor_name").html(requestor_name);
            if (is_history != 1) {
              $('#btnSaveRemarks').show();
              $('#i_requestor_remarks').attr('disabled', false);
            } else {
              $('#i_requestor_remarks').attr('disabled', true);
            }
            $('#btnSaveRemarks').attr('disabled', true);
          }
        } catch(e) {
          console.log(response);
          swal('Remarks Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  } else {
    sessionStorage.setItem('saved_requestor_remarks', '');
    $('#remarks_requestor_date_time').html('N/A');
    $("#remarks_requestor_name").html('');
    if (is_history != 1) {
      $('#btnAddRemarks').show();
      $('#i_requestor_remarks').attr('disabled', false);
    } else {
      $('#i_requestor_remarks').attr('disabled', true);
    }
    $('#btnAddRemarks').attr('disabled', true);
  }

  $("#remarks_id").val(id);
  $("#remarks_request_id").val(request_id);
  $("#remarks_request_id_shown").html(request_id);
  $("#remarks_kanban").val(kanban);
  $("#remarks_kanban_no").val(kanban_no);
  $("#remarks_serial_no").val(serial_no);
  $("#remarks_scan_date_time").val(scan_date_time);

  $('#RequestRemarksDetailsSectionModal').modal({backdrop: 'static', keyboard: false});
}

// Remarks Modal
$("#RequestRemarksDetailsSectionModal").on('show.bs.modal', e => {
  setTimeout(() => {
    var max_length = $('#i_requestor_remarks').attr('maxlength');
    var remarks_length = $('#i_requestor_remarks').val().length;
    var i_requestor_remarks_count = `${remarks_length} / ${max_length}`;
    $('#i_requestor_remarks_count').html(i_requestor_remarks_count);
  }, 100);
});

// Remarks Modal
$("#RequestRemarksDetailsSectionModal").on('hidden.bs.modal', e => {
  $('#btnRequestRemarksDetailsSectionModalClose1').attr('data-target', '');
  $('#btnRequestRemarksDetailsSectionModalClose2').attr('data-target', '');
  sessionStorage.removeItem('saved_requestor_remarks');
  $('#i_requestor_remarks').val('');
  $('#btnAddRemarks').hide();
  $('#btnAddRemarks').attr('disabled', true);
  $('#btnSaveRemarks').hide();
  $('#btnSaveRemarks').attr('disabled', true);
});

// Remarks Modal
const count_requestor_remarks_char = () => {
  var max_length = $('#i_requestor_remarks').attr('maxlength');
  var requestor_remarks = $('#i_requestor_remarks').val();
  var remarks_length = $('#i_requestor_remarks').val().length;
  var saved_requestor_remarks = sessionStorage.getItem('saved_requestor_remarks');
  var i_requestor_remarks_count = `${remarks_length} / ${max_length}`;
  $('#i_requestor_remarks_count').html(i_requestor_remarks_count);
  if (remarks_length > 0) {
    $('#btnAddRemarks').attr('disabled', false);
    if (saved_requestor_remarks != requestor_remarks) {
      $('#btnSaveRemarks').attr('disabled', false);
    } else {
      $('#btnSaveRemarks').attr('disabled', true);
    }
  } else {
    $('#btnAddRemarks').attr('disabled', true);
    $('#btnSaveRemarks').attr('disabled', true);
  }
}

// Remarks Modal
const save_requestor_remarks = () => {
  var request_id = $.trim($('#remarks_request_id').val());
  var kanban = $.trim($('#remarks_kanban').val());
  var kanban_no = $.trim($('#remarks_kanban_no').val());
  var serial_no = $.trim($('#remarks_serial_no').val());
  var section = getCookie('section');
  var scan_date_time = $.trim($('#remarks_scan_date_time').val());
  var requestor_remarks = $.trim($('#i_requestor_remarks').val());
  var data_target = $('#btnRequestRemarksDetailsSectionModalClose1').attr('data-target');
  $.ajax({
    url: '../process/requestor/remarks_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_requestor_remarks',
      request_id:request_id,
      kanban:kanban,
      kanban_no:kanban_no,
      serial_no:serial_no,
      section:section,
      scan_date_time:scan_date_time,
      requestor_remarks:requestor_remarks,
      data_target:data_target
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Requestor Remarks', 'Loading please wait...', {
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
          swal('Requestor Remarks', 'Remarks Added Successfully', 'success');
          if (data_target == '#RequestModal') {
            display_scanned();
          } else if (data_target == '#PendingRequestDetailsSectionModal') {
            view_pending_request_details(request_id);
          }
          $('#RequestRemarksDetailsSectionModal').modal('hide');
          $(`${data_target}`).modal('show');
        } else if (response == 'Empty') {
          swal('Requestor Remarks', 'Please enter remarks', 'info');
        } else {
          console.log(response);
          swal('Requestor Remarks Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

// Remarks Modal
const update_requestor_remarks = () => {
  var request_id = $.trim($('#remarks_request_id').val());
  var requestor_remarks_id = $.trim($('#requestor_remarks_id').val());
  var requestor_remarks = $.trim($('#i_requestor_remarks').val());
  var data_target = $('#btnRequestRemarksDetailsSectionModalClose1').attr('data-target');
  $.ajax({
    url: '../process/requestor/remarks_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_requestor_remarks',
      id:requestor_remarks_id,
      requestor_remarks:requestor_remarks
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Requestor Remarks', 'Loading please wait...', {
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
          swal('Requestor Remarks', 'Remarks Updated Successfully', 'success');
          if (data_target == '#RequestModal') {
            display_scanned();
          } else if (data_target == '#PendingRequestDetailsSectionModal') {
            view_pending_request_details(request_id);
          }
          $('#RequestRemarksDetailsSectionModal').modal('hide');
          $(`${data_target}`).modal('show');
        } else if (response == 'Empty') {
          swal('Requestor Remarks', 'Please enter remarks', 'info');
        } else {
          console.log(response);
          swal('Requestor Remarks Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

// Request Delete
const delete_single_scanned = el => {
  var request_id = $(el).data("request_id");
  var id = $(el).data("id");
  $.ajax({
    url: '../process/requestor/requestor-request_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_single_scanned',
      request_id:request_id,
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response == 'success') {
        display_scanned();
      } else {
        console.log(response);
        swal('Request Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

// Update Request to Pending
const update_scanned = () => {
  var requestor_id_no = $.trim($('#verified_id_no').val());
  var requestor_name = $.trim($('#verified_requestor_name').val());
  var requestor = $.trim($('#verified_requestor').val());
  var request_id = $.trim($('#i_request_id').val());
  $.ajax({
    url: '../process/requestor/requestor-request_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_scanned',
      requestor_id_no:requestor_id_no,
      requestor_name:requestor_name,
      requestor:requestor,
      request_id:request_id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Request Packaging Materials', 'Loading please wait...', {
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
          swal('Request Packaging Materials', 'Requested Successfully', 'success');
          $('#i_request_id').val('');
          $('#verified_id_no').val('');
          $('#verified_requestor_name').val('');
          $('#verified_requestor').val('');
          $('#scannedKanbanData').html('');
          $('#current_request_id_shown').html('');
          $('#current_total_kanban').html('');
          $('#btnCloseScannedKanban').attr('disabled', false);
          $('#btnRequestScannedKanban').attr('disabled', true);
          $('#RequestModal').modal('hide');
          display_pending_on_section();
        } else if (response == 'Limit Reached') {
          swal('Request Packaging Materials Error', `Cannot continue request when quantity is greater than the remaining quantity allowed for requesting. Please change quantity based on remaining quantity to all red rows!`, 'error');
        } else if (response == 'No Remarks') {
          swal('Request Packaging Materials', `Cannot continue request. Remarks is required for Kanban that has changed its quantity.`, 'info');
        } else {
          console.log(response);
          swal('Request Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
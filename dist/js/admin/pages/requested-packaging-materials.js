// Global Variables for Realtime Tables
var realtime_display_pending_on_fg;
var realtime_display_ongoing_on_fg;

// jQuery document ready function
$(() => {
  display_pending_on_fg();
  display_ongoing_on_fg();
  realtime_display_pending_on_fg = setInterval(display_pending_on_fg, 15000);
  realtime_display_ongoing_on_fg = setInterval(display_ongoing_on_fg, 30000);
  sessionStorage.setItem('notif_pending', 0);
  load_notification_fg_req();
  realtime_load_notification_fg_req = setInterval(load_notification_fg_req, 30000);
  update_notification_fg();
  $('#PrintKanbanModal').attr('data-backdrop', 'static');
  $('#PrintKanbanModal').attr('data-keyboard', 'false');
});

const display_pending_on_fg = () => {
  var section = $('#pending_section').find('option:selected').val();
  $.ajax({
    url: '../../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'display_pending_on_fg',
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

        $('#pending_section').html(response_array.dropdown);

        $('#pendingRequestedData').html(response_array.data);

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

const display_ongoing_on_fg = () => {
  var section = $('#ongoing_section').find('option:selected').val();
  $.ajax({
    url: '../../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'display_ongoing_on_fg',
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

        $('#ongoing_section').html(response_array.dropdown);

        $('#ongoingRequestedData').html(response_array.data);

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
        console.log(`Ongoing Request Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_display_ongoing_on_fg);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

$('#pendingRequestedTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('table-primary');
});

$('#ongoingRequestedTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('table-warning');
});

const view_pending_requested_details = el => {
  var request_id = $(el).data("request_id");
  $('#pendingRequestedDetailsData').html('');
  $.ajax({
    url: '../../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'view_pending_requested_details',
      request_id:request_id
    }, 
    beforeSend: (jqXHR, settings) => {
      var loading = `<tr><td colspan="10" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
      $('#pendingRequestedDetailsData').html(loading);
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        $('#pending_request_id').val(request_id);
        $('#pendingRequestedDetailsData').html(response_array.data);
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

const view_ongoing_requested_details = el => {
  var request_id = $(el).data("request_id");
  $('#ongoingRequestedDetailsData').html('');
  $.ajax({
    url: '../../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'view_ongoing_requested_details',
      request_id:request_id
    }, 
    beforeSend: (jqXHR, settings) => {
      var loading = `<tr><td colspan="10" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
      $('#ongoingRequestedDetailsData').html(loading);
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        $('#ongoing_request_id').val(request_id);
        $('#ongoingRequestedDetailsData').html(response_array.data);
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

// Remarks Modal (View)
const remarks_details_fg_view = el => {
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
  $('#btnViewRemarksDetailsFgModalClose1').attr('data-target', data_target);
  $('#btnViewRemarksDetailsFgModalClose2').attr('data-target', data_target);

  if (has_requestor_remarks == 1) {
    $.ajax({
      url: '../../process/requestor/remarks_processor.php',
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
            $('#requestor_remarks_id1').val(response_array.requestor_remarks_id);
            $('#i_requestor_remarks1').val(response_array.requestor_remarks);
            sessionStorage.setItem('saved_requestor_remarks1', response_array.requestor_remarks);
            $('#remarks_requestor_date_time1').html(response_array.requestor_date_time);
            $("#remarks_requestor_name1").html(requestor_name);
            $('#i_requestor_remarks1').attr('disabled', true);
            $('#btnSaveRemarks1').attr('disabled', true);
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
    sessionStorage.setItem('saved_requestor_remarks1', '');
    $('#remarks_requestor_date_time1').html('N/A');
    $("#remarks_requestor_name1").html('');
    $('#i_requestor_remarks1').attr('disabled', true);
    $('#btnAddRemarks1').attr('disabled', true);
  }

  $("#remarks_id1").val(id);
  $("#remarks_request_id1").val(request_id);
  $("#remarks_request_id_shown1").html(request_id);
  $("#remarks_kanban1").val(kanban);
  $("#remarks_kanban_no1").val(kanban_no);
  $("#remarks_serial_no1").val(serial_no);
  $("#remarks_scan_date_time1").val(scan_date_time);

  $('#ViewRemarksDetailsFgModal').modal({backdrop: 'static', keyboard: false});
}

// Remarks Modal (Pending - View)
$("#ViewRemarksDetailsFgModal").on('show.bs.modal', e => {
  setTimeout(() => {
    var max_length = $('#i_requestor_remarks1').attr('maxlength');
    var remarks_length = $('#i_requestor_remarks1').val().length;
    var i_requestor_remarks_count = `${remarks_length} / ${max_length}`;
    $('#i_requestor_remarks_count1').html(i_requestor_remarks_count);
  }, 100);
});

// Remarks Modal (Pending - View)
$("#ViewRemarksDetailsFgModal").on('hidden.bs.modal', e => {
  $('#btnViewRemarksDetailsFgModalClose1').attr('data-target','');
  $('#btnViewRemarksDetailsFgModalClose2').attr('data-target','');
  sessionStorage.removeItem('saved_requestor_remarks1');
  $('#i_requestor_remarks1').val('');
  $('#btnAddRemarks1').hide();
  $('#btnAddRemarks1').attr('disabled', true);
  $('#btnSaveRemarks1').hide();
  $('#btnSaveRemarks1').attr('disabled', true);
});

// Remarks Modal (Pending - View)
const count_requestor_remarks_char_view = () => {
  var max_length = $('#i_requestor_remarks1').attr('maxlength');
  var requestor_remarks = $('#i_requestor_remarks1').val();
  var remarks_length = $('#i_requestor_remarks1').val().length;
  var saved_requestor_remarks = sessionStorage.getItem('saved_requestor_remarks1');
  var i_requestor_remarks_count = `${remarks_length} / ${max_length}`;
  $('#i_requestor_remarks_count1').html(i_requestor_remarks_count);
  if (remarks_length > 0) {
    $('#btnAddRemarks1').attr('disabled', false);
    if (saved_requestor_remarks != requestor_remarks) {
      $('#btnSaveRemarks1').attr('disabled', false);
    } else {
      $('#btnSaveRemarks1').attr('disabled', true);
    }
  } else {
    $('#btnAddRemarks1').attr('disabled', true);
    $('#btnSaveRemarks1').attr('disabled', true);
  }
}

// uncheck all
const uncheck_all_pending = () => {
  var select_all = document.getElementById('check_all_pending');
  select_all.checked = false;
  $('.singleCheck').each((i, el) => {
    el.checked = false;
  });
  get_checked_pending();
}
// check all
const select_all_pending_func = () => {
  var select_all = document.getElementById('check_all_pending');
  if (select_all.checked == true) {
    console.log('check');
    $('.singleCheck').each((i, el) => {
      el.checked = true;
    });
  } else {
    console.log('uncheck');
    $('.singleCheck').each((i, el) => {
      el.checked = false;
    }); 
  }
  get_checked_pending();
}
// GET THE LENGTH OF CHECKED CHECKBOXES
const get_checked_pending = () => {
  var arr = [];
  $('input.singleCheck:checkbox:checked').each((i, el) => {
    arr.push($(el).val());
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    $('#btnMarkAsOngoingRequest').attr('disabled', false);
  } else {
    $('#btnMarkAsOngoingRequest').attr('disabled', true);
  }
}

const mark_as_ongoing_request_arr = () => {
  var request_id = $.trim($('#pending_request_id').val());
  var arr = [];
  $('input.singleCheck:checkbox:checked').each((i, el) => {
    arr.push($(el).val());
  });
  console.log(arr);

  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    $.ajax({
      url: '../../process/requestor/requestor-requested_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'mark_as_ongoing_request_arr',
        requested_arr: arr,
        request_id: request_id
      }, 
      beforeSend: (jqXHR, settings) => {
        swal('Pending Request', 'Loading please wait...', {
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
          try {
            let response_array = JSON.parse(response);
            if (response_array.message == 'success') {
              scanned_kanban_id_arr = Object.values(response_array.scanned_kanban_id_arr);
              var kanban_printing_query = 'scanned_kanban_id_arr='+scanned_kanban_id_arr;
              $('#kanban_printing_option').val(8);
              $('#kanban_printing_query').val(kanban_printing_query);
              $('#PrintKanbanModal').modal('show');
              swal('Pending Request', 'Status Changed Successfully', 'info');
              uncheck_all_pending();
              display_pending_on_fg();
              display_ongoing_on_fg();
            } else if (response_array.message == 'Inventory Limit Reached') {
              swal('Pending Request Error', `Inventory Limit Reached!!! One or more requested packaging materials reaches its limit before running out of inventory`, 'error');
              uncheck_all_pending();
              $("#PendingRequestDetailsFgModal").modal('show');
            } else {
              swal('Pending Request Error', `Error: ${response_array.message}`, 'error');
            }
          } catch(e) {
            console.log(response);
            swal('Pending Request Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
          }
        }, 500);
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  } else {
    swal('Pending Request', `No checkbox checked`, 'info');
  }
}

// uncheck all
const uncheck_all_ongoing = () => {
  var select_all = document.getElementById('check_all_ongoing');
  select_all.checked = false;
  $('.singleCheck2').each((i, el) => {
    el.checked = false;
  });
  get_checked_ongoing();
}
// check all
const select_all_ongoing_func = () => {
  var select_all = document.getElementById('check_all_ongoing');
  if (select_all.checked == true) {
    console.log('check');
    $('.singleCheck2').each((i, el) => {
      el.checked = true;
    });
  } else {
    console.log('uncheck');
    $('.singleCheck2').each((i, el) => {
      el.checked = false;
    }); 
  }
  get_checked_ongoing();
}
// GET THE LENGTH OF CHECKED CHECKBOXES
const get_checked_ongoing = () => {
  var arr = [];
  $('input.singleCheck2:checkbox:checked').each((i, el) => {
    arr.push($(el).val());
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    $('#btnPrintOngoing').attr('disabled', false);
    $('#btnStoreOutRequested').attr('disabled', false);
  } else {
    $('#btnPrintOngoing').attr('disabled', true);
    $('#btnStoreOutRequested').attr('disabled', true);
  }
}

const print_ongoing = () => {
  var arr = [];
  $('input.singleCheck2:checkbox:checked').each((i, el) => {
    arr.push($(el).val());
  });
  console.log(arr);

  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    scanned_kanban_id_arr = Object.values(arr);
    $('#OngoingRequestDetailsFgModal').modal('hide');
    var kanban_printing_query = 'scanned_kanban_id_arr='+scanned_kanban_id_arr;
    $('#kanban_printing_option').val(8);
    $('#kanban_printing_query').val(kanban_printing_query);
    $('#PrintKanbanModal').modal('show');
    uncheck_all_ongoing();
  } else {
    swal('Ongoing Request', `No checkbox checked`, 'info');
  }
}

const store_out_requested_arr = () => {
  var request_id = $.trim($('#ongoing_request_id').val());
  var store_out_person = getCookie('name');
  var arr = [];
  $('input.singleCheck2:checkbox:checked').each((i, el) => {
    arr.push($(el).val());
  });
  console.log(arr);

  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    $.ajax({
      url: '../../process/requestor/requestor-requested_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'store_out_requested_arr',
        requested_arr: arr,
        request_id: request_id,
        store_out_person: store_out_person
      }, 
      beforeSend: (jqXHR, settings) => {
        swal('Ongoing Request', 'Loading please wait...', {
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
          try {
            let response_array = JSON.parse(response);
            if (response_array.message == 'success') {
              kanban_history_id_arr = Object.values(response_array.kanban_history_id_arr);
              var kanban_printing_query = 'kanban_history_id_arr='+kanban_history_id_arr;
              $('#kanban_printing_option').val(9);
              $('#kanban_printing_query').val(kanban_printing_query);
              $('#PrintKanbanModal').modal('show');
              swal('Ongoing Request', 'Status Changed Successfully', 'info');
              $('#btnPrintOngoing').attr('disabled', true);
              $('#btnStoreOutRequested').attr('disabled', true);
              uncheck_all_ongoing();
              display_ongoing_on_fg();
            } else {
              swal('Ongoing Request Error', `Error: ${response_array.message}`, 'error');
            }
          } catch(e) {
            console.log(response);
            swal('Ongoing Request Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
          }
        }, 500);
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  } else {
    swal('Ongoing Request', `No checkbox checked`, 'info');
  }
}
$(()=> {
  get_section_dropdown_fg();
  get_line_datalist();
  get_items_datalist();
  sessionStorage.setItem('search_request_date_from', '');
  sessionStorage.setItem('search_request_date_to', '');
  sessionStorage.setItem('search_request_section', '');
  sessionStorage.setItem('search_request_status', '');
  sessionStorage.setItem('search_request_line_no', '');
  sessionStorage.setItem('search_request_item_no', '');
  sessionStorage.setItem('search_request_item_name', '');
  sessionStorage.setItem('notif_pending', 0);
  load_notification_fg();
  realtime_load_notification_fg = setInterval(load_notification_fg, 5000);
});

const get_section_dropdown_fg = () => {
  $.ajax({
    url: '../../process/admin/section_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_section_dropdown_fg'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_request_section').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

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
      $('#i_request_lines').html(response);
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
      $('#i_request_items').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$('#i_request_line_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_request_searched(1);
  }
});

$('#i_request_item_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_request_searched(1);
  }
});

$('#i_request_item_name').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_request_searched(1);
  }
});

const count_request_searched = () => {
  var request_date_from = sessionStorage.getItem('search_request_date_from');
  var request_date_to = sessionStorage.getItem('search_request_date_to');
  var section = sessionStorage.getItem('search_request_section');
  var status = sessionStorage.getItem('search_request_status');
  var line_no = sessionStorage.getItem('search_request_line_no');
  var item_no = sessionStorage.getItem('search_request_item_no');
  var item_name = sessionStorage.getItem('search_request_item_name');
  $.ajax({
    url: '../../process/requestor/requestor-requested_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_request_searched',
      request_date_from: request_date_from,
      request_date_to: request_date_to,
      section: section,
      status: status,
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
      let table_rows = parseInt($("#requestSearchData tr").length);
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
        $('#btnExportRequestSearchCsv').attr('disabled', false);
      } else {
        $('#counter_view_search').hide();
        $('#counter_view').hide();
        $('#btnExportRequestSearchCsv').attr('disabled', true);
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

const get_request_searched = option => {
  var id = 0;
  var request_date_from = '';
  var request_date_to = '';
  var section = '';
  var status = '';
  var line_no = '';
  var item_no = '';
  var item_name = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var request_date_from = $.trim($('#i_request_date_from').val());
      var request_date_to = $.trim($('#i_request_date_to').val());
      var line_no = $.trim($('#i_request_line_no').val());
      var item_no = $.trim($('#i_request_item_no').val());
      var item_name = $.trim($('#i_request_item_name').val());
      var section = $('#i_request_section').find('option:selected').val();
      var status = $('#i_request_status').find('option:selected').val();
      if (request_date_from == '' && request_date_to == '') {
        var continue_loading = false;
        swal('Request Search', 'Fill out date fields to search for', 'info');
      }
      break;
    case 2:
      var id = $('#requestSearchTable tr:last').attr('id');
      var request_date_from = sessionStorage.getItem('search_request_date_from');
      var request_date_to = sessionStorage.getItem('search_request_date_to');
      var section = sessionStorage.getItem('search_request_section');
      var status = sessionStorage.getItem('search_request_status');
      var line_no = sessionStorage.getItem('search_request_line_no');
      var item_no = sessionStorage.getItem('search_request_item_no');
      var item_name = sessionStorage.getItem('search_request_item_name');
      var loader_count = parseInt($('#loader_count').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../../process/requestor/requestor-requested_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_request_searched',
        id: id,
        request_date_from: request_date_from,
        request_date_to: request_date_to,
        line_no: line_no,
        item_no: item_no,
        item_name: item_name, 
        section: section,
        status: status,
        c: loader_count
      },  
      beforeSend: (jqXHR, settings) => {
        if (option == 1) {
          var loading = `<tr><td colspan="11" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
          $('#requestSearchData').html(loading);
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            $('#requestSearchData').html(response);
            $('#loader_count').val(25);
            sessionStorage.setItem('search_request_date_from', request_date_from);
            sessionStorage.setItem('search_request_date_to', request_date_to);
            sessionStorage.setItem('search_request_section', section);
            sessionStorage.setItem('search_request_status', status);
            sessionStorage.setItem('search_request_line_no', line_no);
            sessionStorage.setItem('search_request_item_no', item_no);
            sessionStorage.setItem('search_request_item_name', item_name);
            break;
          case 2:
            $("#requestSearchTable tbody").append(response);
            $('#loader_count').val(loader_count + 25);
            break;
          default:
        }
        count_request_searched();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const export_request_searched = () => {
  var request_date_from = sessionStorage.getItem('search_request_date_from');
  var request_date_to = sessionStorage.getItem('search_request_date_to');
  var section = sessionStorage.getItem('search_request_section');
  var status = sessionStorage.getItem('search_request_status');
  var line_no = sessionStorage.getItem('search_request_line_no');
  var item_no = sessionStorage.getItem('search_request_item_no');
  var item_name = sessionStorage.getItem('search_request_item_name');

  window.open('../../process/export/export_request_searched.php?request_date_from='+request_date_from+'&&request_date_to='+request_date_to+'&&line_no='+line_no+'&&item_no='+item_no+'&&item_name='+item_name+'&&section='+section+'&&status='+status,'_blank');
}
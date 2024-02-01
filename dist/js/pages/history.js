$(()=> {
  get_line_datalist();
  get_items_datalist();
  sessionStorage.setItem('search_store_out_date_from', '');
  sessionStorage.setItem('search_store_out_date_to', '');
  sessionStorage.setItem('search_store_out_section', '');
  sessionStorage.setItem('search_store_out_line_no', '');
  sessionStorage.setItem('search_store_out_item_no', '');
  sessionStorage.setItem('search_store_out_item_name', '');
  sessionStorage.setItem('notif_ongoing', 0);
  sessionStorage.setItem('notif_store_out', 0);
  load_notification_section();
  realtime_load_notification_section = setInterval(load_notification_section, 5000);
});

const get_line_datalist = () => {
  $.ajax({
    url: '../process/admin/route-number_processor.php',
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
      $('#i_store_out_lines').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_items_datalist = () => {
  $.ajax({
    url: '../process/admin/packaging-materials_processor.php',
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
      $('#i_store_out_items').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$('#i_store_out_line_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_store_out_request_history_section(1);
  }
});

$('#i_store_out_item_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_store_out_request_history_section(1);
  }
});

$('#i_store_out_item_name').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_store_out_request_history_section(1);
  }
});

const count_store_out_request_history_section = () => {
  var store_out_date_from = sessionStorage.getItem('search_store_out_date_from');
  var store_out_date_to = sessionStorage.getItem('search_store_out_date_to');
  var section = sessionStorage.getItem('search_store_out_section');
  var line_no = sessionStorage.getItem('search_store_out_line_no');
  var item_no = sessionStorage.getItem('search_store_out_item_no');
  var item_name = sessionStorage.getItem('search_store_out_item_name');
  $.ajax({
    url: '../process/requestor/kanban-history_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_store_out_request_history',
      store_out_date_from: store_out_date_from,
      store_out_date_to: store_out_date_to,
      section: section,
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
      let table_rows = parseInt($("#storeOutRequestHistoryData tr").length);
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
        $('#btnExportStoreOutRequestHistoryCsv').attr('disabled', false);
        $('#btnExportWithRemarks').attr('disabled', false);
      } else {
        $('#counter_view_search').hide();
        $('#counter_view').hide();
        $('#btnExportStoreOutRequestHistoryCsv').attr('disabled', true);
        $('#btnExportWithRemarks').attr('disabled', true);
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

const get_store_out_request_history_section = option => {
  var id = 0;
  var store_out_date_from = '';
  var store_out_date_to = '';
  var line_no = '';
  var item_no = '';
  var item_name = '';
  var section = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var store_out_date_from = $.trim($('#i_store_out_date_from').val());
      var store_out_date_to = $.trim($('#i_store_out_date_to').val());
      var line_no = $.trim($('#i_store_out_line_no').val());
      var item_no = $.trim($('#i_store_out_item_no').val());
      var item_name = $.trim($('#i_store_out_item_name').val());
      var section = getCookie('section');
      if (store_out_date_from == '' && store_out_date_to == '') {
        var continue_loading = false;
        swal('Store Out Request History Search', 'Fill out date fields to search for', 'info');
      }
      break;
    case 2:
      var id = $('#storeOutRequestHistoryTable tr:last').attr('id');
      var store_out_date_from = sessionStorage.getItem('search_store_out_date_from');
      var store_out_date_to = sessionStorage.getItem('search_store_out_date_to');
      var section = sessionStorage.getItem('search_store_out_section');
      var line_no = sessionStorage.getItem('search_store_out_line_no');
      var item_no = sessionStorage.getItem('search_store_out_item_no');
      var item_name = sessionStorage.getItem('search_store_out_item_name');
      var loader_count = parseInt($('#loader_count').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/requestor/kanban-history_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_store_out_request_history',
        id: id,
        store_out_date_from: store_out_date_from,
        store_out_date_to: store_out_date_to,
        line_no: line_no,
        item_no: item_no,
        item_name: item_name, 
        section: section,
        printing: 0,
        c: loader_count
      },  
      beforeSend: (jqXHR, settings) => {
        if (option == 1) {
          var loading = `<tr><td colspan="14" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
          $('#storeOutRequestHistoryData').html(loading);
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            $('#storeOutRequestHistoryData').html(response);
            $('#loader_count').val(25);
            sessionStorage.setItem('search_store_out_date_from', store_out_date_from);
            sessionStorage.setItem('search_store_out_date_to', store_out_date_to);
            sessionStorage.setItem('search_store_out_section', section);
            sessionStorage.setItem('search_store_out_line_no', line_no);
            sessionStorage.setItem('search_store_out_item_no', item_no);
            sessionStorage.setItem('search_store_out_item_name', item_name);
            break;
          case 2:
            $("#storeOutRequestHistoryTable tbody").append(response);
            $('#loader_count').val(loader_count + 25);
            break;
          default:
        }
        count_store_out_request_history_section();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const export_store_out_request_history_section = with_remarks => {
  var store_out_date_from = sessionStorage.getItem('search_store_out_date_from');
  var store_out_date_to = sessionStorage.getItem('search_store_out_date_to');
  var section = sessionStorage.getItem('search_store_out_section');
  var line_no = sessionStorage.getItem('search_store_out_line_no');
  var item_no = sessionStorage.getItem('search_store_out_item_no');
  var item_name = sessionStorage.getItem('search_store_out_item_name');
  window.open('../process/export/export_store_out_request_history.php?store_out_date_from='+store_out_date_from+'&&store_out_date_to='+store_out_date_to+'&&line_no='+line_no+'&&item_no='+item_no+'&&item_name='+item_name+'&&section='+section+'&&with_remarks='+with_remarks,'_blank');
}
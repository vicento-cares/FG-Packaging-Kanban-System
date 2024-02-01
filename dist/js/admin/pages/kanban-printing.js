// jQuery document ready function
$(() => {
  get_section_dropdown_fg();
  get_batch_dropdown();
  get_line_dropdown();
  get_line_datalist();
  get_items_datalist();
  sessionStorage.setItem('search_print_category', '');
  sessionStorage.setItem('search_section', '');
  sessionStorage.setItem('search_batch_no', '');
  sessionStorage.setItem('search_line_no', '');
  sessionStorage.setItem('search_store_out_date_from', '');
  sessionStorage.setItem('search_store_out_date_to', '');
  sessionStorage.setItem('search_store_out_section', '');
  sessionStorage.setItem('search_store_out_line_no', '');
  sessionStorage.setItem('search_store_out_item_no', '');
  sessionStorage.setItem('search_store_out_item_name', '');
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
      $('#i_section_batch').html(response);
      $('#i_section_line').html(response);
      $('#i_section').html(response);
      $('#store_out_history_section').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_batch_dropdown = () => {
  $.ajax({
    url: '../../process/admin/kanban-printing_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_batch_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_batch').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_line_dropdown = () => {
  $.ajax({
    url: '../../process/admin/kanban-printing_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_line_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      $('#i_line').html(response);
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
      $('#i_store_out_items').html(response);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const printing_category = () => {
  var category = $('#i_print_category').find('option:selected').val();
  if (category == 'By Batch') {
    $('#i_batch').show();
    $('#i_line').hide();
    $('#i_section').hide();
    $('#i_section_line').hide();
    $('#i_section_batch').show();
  } else if(category == 'By Line No.') {
    $('#i_line').show();
    $('#i_batch').hide();
    $('#i_section_batch').hide();
    $('#i_section').hide();
    $('#i_section_line').show();
  } else if(category == 'By Latest Upload') {
    $('#i_line').hide();
    $('#i_batch').hide();
    $('#i_section_batch').hide();
    $('#i_section_line').hide();
    $('#i_section').show();
  }
  sessionStorage.setItem('search_print_category', category);
  load_kanban(1);
}

const count_kanban = () => {
  var section = sessionStorage.getItem('search_section');
  var batch_no = sessionStorage.getItem('search_batch_no');
  var line_no = sessionStorage.getItem('search_line_no');
  $.ajax({
    url: '../../process/admin/kanban-printing_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_kanban',
      batch_no: batch_no,
      line_no: line_no,
      section: section
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt($("#kanbanRegData tr").length);
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
        $('#btnPrintKbnByCat').attr('disabled', false);
      } else {
        $('#counter_view_search').hide();
        $('#counter_view').hide();
        $('#btnPrintKbnByCat').attr('disabled', true);
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

const load_kanban = option => {
  var id = 0;
  var category = sessionStorage.getItem('search_print_category');
  var section = '';
  var batch_no = '';
  var line_no = '';
  var loader_count = 0;
  switch (option) {
    case 1:
      if (category == 'By Batch') {
        var batch_no = $('#i_batch').find('option:selected').val();
        var section = $('#i_section_batch').find('option:selected').val();
      } else if (category == 'By Line No.') {
        var line_no = $('#i_line').find('option:selected').val();
        var section = $('#i_section_line').find('option:selected').val();
      } else if (category == 'By Latest Upload') {
        var section = $('#i_section').find('option:selected').val();
      }
      break;
    case 2:
      var id = $('#kanbanRegTable tr:last').attr('id');
      var section = sessionStorage.getItem('search_section');
      var batch_no = sessionStorage.getItem('search_batch_no');
      var line_no = sessionStorage.getItem('search_line_no');
      var loader_count = parseInt($('#loader_count').val());
      break;
    default:
  }
  $.ajax({
    url: '../../process/admin/kanban-printing_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_kanban',
      id:id,
      batch_no:batch_no,
      line_no:line_no,
      section:section,
      c:loader_count
    }, 
    beforeSend: (jqXHR, settings) => {
      if (option == 1) {
        var loading = `<tr><td colspan="7" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
        $('#kanbanRegData').html(loading);
      }
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      switch (option) {
        case 1:
          $('#kanbanRegData').html(response);
          $('#loader_count').val(25);
          sessionStorage.setItem('search_section', section);
          if (category == 'By Batch') {
            sessionStorage.setItem('search_batch_no', batch_no);
            sessionStorage.setItem('search_line_no', '');
          } else if (category == 'By Line No.') {
            sessionStorage.setItem('search_batch_no', '');
            sessionStorage.setItem('search_line_no', line_no);
          } else if (category == 'By Latest Upload') {
            sessionStorage.setItem('search_batch_no', '');
            sessionStorage.setItem('search_line_no', '');
          }
          uncheck_all_kanban();
          break;
        case 2:
          $("#kanbanRegTable tbody").append(response);
          $('#loader_count').val(loader_count + 25);
          break;
        default:
      }
      count_kanban();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

// uncheck all
const uncheck_all_kanban = () => {
  var select_all = document.getElementById('check_all_kanban');
  select_all.checked = false;
  $('.singleCheck').each((i, el) => {
    el.checked = false;
  });
  get_checked_kanban();
}
// check all
const select_all_kanban_func = () => {
  var select_all = document.getElementById('check_all_kanban');
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
  get_checked_kanban();
}
// GET THE LENGTH OF CHECKED CHECKBOXES
const get_checked_kanban = () => {
  var arr = [];
  $('input.singleCheck:checkbox:checked').each((i, el) => {
    arr.push($(el).val());
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    $('#btnPrintSelKbnByCat').attr('disabled', false);
  } else {
    $('#btnPrintSelKbnByCat').attr('disabled', true);
  }
}

const print_selected_kanban_by_category = () => {
  var arr = [];
  $('input.singleCheck:checkbox:checked').each((i, el) => {
    arr.push($(el).val());
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    kanban_reg_id_arr = Object.values(arr);
    var kanban_printing_query = 'kanban_reg_id_arr='+kanban_reg_id_arr;
    $('#kanban_printing_option').val(2);
    $('#kanban_printing_query').val(kanban_printing_query);
    $('#PrintKanbanModal').modal('show');
    uncheck_all_kanban();
  } else {
    swal('Kanban Printing', `No checkbox checked`, 'info');
  }
}

const print_kanban_by_category = () => {
  var category = $('#i_print_category').find('option:selected').val();
  var section = '';
  var kanban_printing_query = '';
  if (category == 'By Batch') {
    var batch_no = $('#i_batch').find('option:selected').val();
    var section = $('#i_section_batch').find('option:selected').val();
    var kanban_printing_query = 'batch_no='+batch_no+'&&section='+section;
    $('#kanban_printing_option').val(3);
  } else if (category == 'By Line No.') {
    var line_no = $('#i_line').find('option:selected').val();
    var section = $('#i_section_line').find('option:selected').val();
    var kanban_printing_query = 'line_no='+line_no+'&&section='+section;
    $('#kanban_printing_option').val(4);
  } else if (category == 'By Latest Upload') {
    var section = $('#i_section').find('option:selected').val();
    var kanban_printing_query = 'section='+section;
    $('#kanban_printing_option').val(5)
  }
  $('#kanban_printing_query').val(kanban_printing_query);
  $('#PrintKanbanModal').modal('show');
}

const print_single_kanban = id => {
  var kanban_printing_query = 'id='+id;
  $('#kanban_printing_option').val(1);
  $('#kanban_printing_query').val(kanban_printing_query);
  $('#PrintKanbanModal').modal('show');
}

$('#i_store_out_line_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_store_out_request_history_printing(1);
  }
});

$('#i_store_out_item_no').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_store_out_request_history_printing(1);
  }
});

$('#i_store_out_item_name').on("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_store_out_request_history_printing(1);
  }
});

const count_store_out_request_history_printing = () => {
  var store_out_date_from = sessionStorage.getItem('search_store_out_date_from');
  var store_out_date_to = sessionStorage.getItem('search_store_out_date_to');
  var section = sessionStorage.getItem('search_store_out_section');
  var line_no = sessionStorage.getItem('search_store_out_line_no');
  var item_no = sessionStorage.getItem('search_store_out_item_no');
  var item_name = sessionStorage.getItem('search_store_out_item_name');
  $.ajax({
    url: '../../process/requestor/kanban-history_processor.php',
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
        $('#btnPrintStoreOutRequestKbnHistory').attr('disabled', false);
      } else {
        $('#counter_view_search2').hide();
        $('#counter_view2').hide();
        $('#btnPrintStoreOutRequestKbnHistory').attr('disabled', true);
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

const get_store_out_request_history_printing = option => {
  var id = 0;
  var store_out_date_from = '';
  var store_out_date_to = '';
  var line_no = '';
  var item_no = '';
  var item_name = '';
  var section = '';
  var loader_count2 = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var store_out_date_from = $.trim($('#i_store_out_date_from').val());
      var store_out_date_to = $.trim($('#i_store_out_date_to').val());
      var line_no = $.trim($('#i_store_out_line_no').val());
      var item_no = $.trim($('#i_store_out_item_no').val());
      var item_name = $.trim($('#i_store_out_item_name').val());
      var section = $('#store_out_history_section').find('option:selected').val();
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
      var loader_count2 = parseInt($('#loader_count2').val());
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../../process/requestor/kanban-history_processor.php',
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
        printing: 1,
        c: loader_count2
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
            $('#loader_count2').val(25);
            sessionStorage.setItem('search_store_out_date_from', store_out_date_from);
            sessionStorage.setItem('search_store_out_date_to', store_out_date_to);
            sessionStorage.setItem('search_store_out_section', section);
            sessionStorage.setItem('search_store_out_line_no', line_no);
            sessionStorage.setItem('search_store_out_item_no', item_no);
            sessionStorage.setItem('search_store_out_item_name', item_name);
            uncheck_all_kanban_history();
            break;
          case 2:
            $("#storeOutRequestHistoryTable tbody").append(response);
            $('#loader_count2').val(loader_count2 + 25);
            break;
          default:
        }
        count_store_out_request_history_printing();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

// uncheck all
const uncheck_all_kanban_history = () => {
  var select_all = document.getElementById('check_all_kanban_history');
  select_all.checked = false;
  $('.singleCheck2').each((i, el) => {
    el.checked = false;
  });
  get_checked_kanban_history();
}
// check all
const select_all_kanban_history_func = () => {
  var select_all = document.getElementById('check_all_kanban_history');
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
  get_checked_kanban_history();
}
// GET THE LENGTH OF CHECKED CHECKBOXES
const get_checked_kanban_history = () => {
  var arr = [];
  $('input.singleCheck2:checkbox:checked').each((i, el) => {
    arr.push($(el).val());
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    $('#btnPrintSelStoreOutRequestKbnHistory').attr('disabled', false);
  } else {
    $('#btnPrintSelStoreOutRequestKbnHistory').attr('disabled', true);
  }
}

const print_selected_store_out_request_history = () => {
  var arr = [];
  $('input.singleCheck2:checkbox:checked').each((i, el) => {
    arr.push($(el).val());
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    kanban_history_id_arr = Object.values(arr);
    var kanban_printing_query = 'kanban_history_id_arr='+kanban_history_id_arr;
    $('#kanban_printing_option').val(9);
    $('#kanban_printing_query').val(kanban_printing_query);
    $('#PrintKanbanModal').modal('show');
    uncheck_all_kanban_history();
  } else {
    swal('Kanban Printing', `No checkbox checked`, 'info');
  }
}

const print_store_out_request_history = () => {
  var store_out_date_from = sessionStorage.getItem('search_store_out_date_from');
  var store_out_date_to = sessionStorage.getItem('search_store_out_date_to');
  var section = sessionStorage.getItem('search_store_out_section');
  var line_no = sessionStorage.getItem('search_store_out_line_no');
  var item_no = sessionStorage.getItem('search_store_out_item_no');
  var item_name = sessionStorage.getItem('search_store_out_item_name');

  var kanban_printing_query = 'store_out_date_from='+store_out_date_from+'&&store_out_date_to='+store_out_date_to+'&&line_no='+line_no+'&&item_no='+item_no+'&&item_name='+item_name+'&&section='+section+'&&c=0';
  $('#kanban_printing_option').val(7);
  $('#kanban_printing_query').val(kanban_printing_query);
  $('#PrintKanbanModal').modal('show');
}

const print_single_kanban_history = id => {
  var kanban_printing_query = 'id='+id;
  $('#kanban_printing_option').val(6);
  $('#kanban_printing_query').val(kanban_printing_query);
  $('#PrintKanbanModal').modal('show');
}
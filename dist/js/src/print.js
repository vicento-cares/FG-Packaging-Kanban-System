const print_kanban = method => {
  var option = parseInt($('#kanban_printing_option').val());
  var kanban_printing_query = $.trim($('#kanban_printing_query').val());
  var url = '../../process';
  switch (method) {
    case 1:
      var url = url + '/print-v2';
      break;
    case 2:
      var url = url + '/print';
      break;
    default:
  }
  switch (option) {
    case 1:
      var url = url + '/print_kanban_single.php?';
      break;
    case 2:
      var url = url + '/print_kanban_selected.php?';
      break;
    case 3:
      var url = url + '/print_kanban_by_batch.php?';
      break;
    case 4:
      var url = url + '/print_kanban_by_line.php?';
      break;
    case 5:
      var url = url + '/print_kanban_by_latest.php?';
      break;
    case 6:
      var url = url + '/print_kanban_history_single.php?';
      break;
    case 7:
      var url = url + '/print_kanban_history.php?';
      break;
    case 8:
      var url = url + '/print_kanban_ongoing.php?';
      break;
    case 9:
      var url = url + '/print_kanban_store_out.php?';
      break;
    default:
  }
  console.log(url + kanban_printing_query);
  window.open(url + kanban_printing_query,'_blank');
}
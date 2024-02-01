// Notification Global Variables for Realtime
var realtime_load_notification_fg;
var realtime_load_notification_fg_req;
var realtime_load_notification_section;
var realtime_load_notification_section_req;

// Notifications
const load_notification_fg = () => {
  $.ajax({
    url: '../../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_fg'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_pending = "";
      var notif_pending_val = sessionStorage.getItem('notif_pending');
      var notif_pending_body = "";
      if (response > 0) {
        if (response > 99) {
          var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
        } else {
          var badge = `<span class="badge badge-danger navbar-badge">${response}</span>`;
        }
        var notif_badge = `${icon}${badge}`;
        if (response < 2) {
          var notif_pending = `<i class="fas fa-archive mr-2"></i> ${response} new pending request<span class="float-right text-muted text-sm"></span>`;
          var notif_pending_body = `${response} new pending request`;
        } else {
          var notif_pending = `<i class="fas fa-archive mr-2"></i> ${response} new pending requests<span class="float-right text-muted text-sm"></span>`;
          var notif_pending_body = `${response} new pending requests`;
        }
        if (notif_pending_val != response) {
          $(document).Toasts('create', {
            class: 'bg-navy',
            body: notif_pending_body,
            title: 'Pending Requested Packaging Materials',
            icon: 'fas fa-archive fa-lg',
            autohide: true,
            delay: 3000
          });
        }
        sessionStorage.setItem('notif_pending', response);
      } else if (response < 1) {
        sessionStorage.setItem('notif_pending', 0);
        var notif_badge = `${icon}`;
        var notif_pending = `<i class="fas fa-archive mr-2"></i> No new pending request<span class="float-right text-muted text-sm"></span>`;
      } else {
        console.log(response);
        console.log(`Notification Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_pending').html(notif_pending);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notification_fg);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

// Notifications
const load_notification_section = () => {
  var section = getCookie('section');
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_section',
      section: section
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_ongoing = "";
      var notif_store_out = "";
      var notif_ongoing_val = sessionStorage.getItem('notif_ongoing');
      var notif_store_out_val = sessionStorage.getItem('notif_store_out');
      var notif_ongoing_body = "";
      var notif_store_out_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.ongoing > 0) {
            if (response_array.ongoing < 2) {
              var notif_ongoing = `<i class="fas fa-spinner mr-2"></i> ${response_array.ongoing} new ongoing request<span class="float-right text-muted text-sm"></span>`;
              var notif_ongoing_body = `${response_array.ongoing} new ongoing request`;
            } else {
              var notif_ongoing = `<i class="fas fa-spinner mr-2"></i> ${response_array.ongoing} new ongoing requests<span class="float-right text-muted text-sm"></span>`;
              var notif_ongoing_body = `${response_array.ongoing} new ongoing requests`;
            }
          } else {
            var notif_ongoing = `<i class="fas fa-spinner mr-2"></i> No new ongoing requests<span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.store_out > 0) {
            if (response_array.store_out < 2) {
              var notif_store_out = `<i class="fas fa-history mr-2"></i> ${response_array.store_out} new stored out request<span class="float-right text-muted text-sm"></span>`;
              var notif_store_out_body = `${response_array.store_out} new stored out request`;
            } else {
              var notif_store_out = `<i class="fas fa-history mr-2"></i> ${response_array.store_out} new stored out requests<span class="float-right text-muted text-sm"></span>`;
              var notif_store_out_body = `${response_array.store_out} new stored out requests`;
            }
          } else {
            var notif_store_out = `<i class="fas fa-history mr-2"></i> No new stored out requests<span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_ongoing_val != response_array.ongoing) {
            $(document).Toasts('create', {
              class: 'bg-warning',
              body: notif_ongoing_body,
              title: 'Ongoing Requested Packaging Materials',
              icon: 'fas fa-spinner fa-lg',
              autohide: true,
              delay: 3000
            });
          }
          if (notif_store_out_val != response_array.store_out) {
            $(document).Toasts('create', {
              class: 'bg-success',
              body: notif_store_out_body,
              title: 'Stored Out Requested Packaging Materials',
              icon: 'fas fa-history fa-lg',
              autohide: true,
              delay: 3000
            });
          }
          sessionStorage.setItem('notif_ongoing', response_array.ongoing);
          sessionStorage.setItem('notif_store_out', response_array.store_out);
        } else {
          sessionStorage.setItem('notif_ongoing', 0);
          sessionStorage.setItem('notif_store_out', 0);
          var notif_badge = `${icon}`;
          var notif_ongoing = `<i class="fas fa-spinner mr-2"></i> No new ongoing request<span class="float-right text-muted text-sm"></span>`;
          var notif_store_out = `<i class="fas fa-history mr-2"></i> No new stored out request<span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_ongoing').html(notif_ongoing);
      $('#notif_store_out').html(notif_store_out);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notification_section);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

// Notifications
const update_notification_fg = () => {
  $.ajax({
    url: '../../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_fg'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var notif_badge = `${icon}`;
      var notif_pending = `<i class="fas fa-archive mr-2"></i> No new pending request<span class="float-right text-muted text-sm"></span>`;
      $('#notif_badge').html(notif_badge);
      $('#notif_pending').html(notif_pending);
      if (response != '') {
        console.log(response);
        console.log(`Notification Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const load_notification_fg_req = () => {
  $.ajax({
    url: '../../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_fg'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var notif_pending_val = sessionStorage.getItem('notif_pending');
      var notif_pending_body = "";
      if (response > 0) {
        if (response < 2) {
          var notif_pending_body = `${response} new pending request`;
        } else {
          var notif_pending_body = `${response} new pending requests`;
        }
        if (notif_pending_val != response) {
          if (notif_pending_val < response) {
            $(document).Toasts('create', {
              class: 'bg-navy',
              body: notif_pending_body,
              title: 'Pending Requested Packaging Materials',
              icon: 'fas fa-archive fa-lg',
              autohide: true,
              delay: 4800
            });
          }
        }
        sessionStorage.setItem('notif_pending', response);
      } else if (response < 1) {
        sessionStorage.setItem('notif_pending', 0);
      } else {
        console.log(response);
        console.log(`Notification Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    } 
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notification_fg_req);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

// Notifications
const update_notification_section = () => {
  var section = getCookie('section');
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_section',
      section: section
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var notif_badge = `${icon}`;
      var notif_ongoing = `<i class="fas fa-spinner mr-2"></i> No new ongoing request<span class="float-right text-muted text-sm"></span>`;
      var notif_store_out = `<i class="fas fa-history mr-2"></i> No new stored out request<span class="float-right text-muted text-sm"></span>`;
      $('#notif_badge').html(notif_badge);
      $('#notif_ongoing').html(notif_ongoing);
      $('#notif_store_out').html(notif_store_out);
      if (response != '') {
        console.log(response);
        console.log(`Notification Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const load_notification_section_req = () => {
  var section = getCookie('section');
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_section',
      section: section
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var notif_ongoing_val = sessionStorage.getItem('notif_ongoing');
      var notif_store_out_val = sessionStorage.getItem('notif_store_out');
      var notif_ongoing_body = "";
      var notif_store_out_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.ongoing > 0) {
            if (response_array.ongoing < 2) {
              var notif_ongoing_body = `${response_array.ongoing} new ongoing request`;
            } else {
              var notif_ongoing_body = `${response_array.ongoing} new ongoing requests`;
            }
          }
          if (response_array.store_out > 0) {
            if (response_array.store_out < 2) {
              var notif_store_out_body = `${response_array.store_out} new stored out request`;
            } else {
              var notif_store_out_body = `${response_array.store_out} new stored out requests`;
            }
          }
          if (notif_ongoing_val != response_array.ongoing) {
            if (notif_ongoing_val < response_array.ongoing) {
              $(document).Toasts('create', {
                class: 'bg-warning',
                body: notif_ongoing_body,
                title: 'Ongoing Requested Packaging Materials',
                icon: 'fas fa-spinner fa-lg',
                autohide: true,
                delay: 4800
              });
            }
          }
          if (notif_store_out_val != response_array.store_out) {
            if (notif_store_out_val < response_array.store_out) {
              $(document).Toasts('create', {
                class: 'bg-success',
                body: notif_store_out_body,
                title: 'Stored Out Requested Packaging Materials',
                icon: 'fas fa-history fa-lg',
                autohide: true,
                delay: 4800
              });
            }
          }
          sessionStorage.setItem('notif_ongoing', response_array.ongoing);
          sessionStorage.setItem('notif_store_out', response_array.store_out);
        } else {
          sessionStorage.setItem('notif_ongoing', 0);
          sessionStorage.setItem('notif_store_out', 0);
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notification_section_req);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}
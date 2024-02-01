// Logout Function
const logout = url => {
  var loading = `<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" id="loading"></span>`;
  $("#logout").prepend(loading);
  $('#logout').attr('disabled', true);
  $('#logoutClose').attr('disabled', true);
  window.location.href = url;
}
// Get Cookie Function
const getCookie = cname => {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

// Check Cookie Enable
const checkCookie = () => {
  if (navigator.cookieEnabled == false) {
    var log = 'The system will not work properly if cookies are disabled!!! Please enable cookies on this browser.';
    console.log(log);
    swal('System Warning', `Call IT Personnel Immediately!!! They will fix it right away. Warning: ${log}`, 'warning');
  }
}

$(() => {
  checkCookie();
  setInterval(checkCookie, 10000);
});

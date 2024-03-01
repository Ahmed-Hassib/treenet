
/**
 * history_control function
 * used to control history
 */
function history_control(return_btn = null) {
  // get history
  let history_referer = document.referrer;
  // previous url
  let prev_url = "";
  // check if history url contains any of this words::
  // [1] Insert
  // [1] Update
  // [1] Delete
  if (history_referer.includes('insert'.toLocaleLowerCase()) || history_referer.includes('update'.toLocaleLowerCase()) || history_referer.includes('delete'.toLocaleLowerCase())) {
    if (history_referer.includes('name='.toLocaleLowerCase())) {
      prev_url = history_referer.slice(0, history_referer.indexOf('&do'));
    } else {
      prev_url = history_referer.slice(0, history_referer.indexOf('.php') + 4);
    }
  } else {
    prev_url = history_referer;
  }
  // redirect to previous page
  window.location.href = prev_url;
}
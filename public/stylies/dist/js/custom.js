function getOffset(el) {
  el = el.getBoundingClientRect();

  // You can use getBoundingClientRect().left or any type only

  return {
    left: el.left + window.scrollX,
    top: el.top + window.scrollY
  }
}
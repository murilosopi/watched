function nextScroll(container) {
  container = document.getElementById(container);
  container.scrollLeft += 250;
}

function prevScroll(container) {
  container = document.getElementById(container);
  container.scrollLeft -= 250;
}
(function() {
  const form = document.querySelector("form");
  form.addEventListener('reset', e => {
    e.preventDefault;

    const allInputs = form.querySelectorAll('input');
    allInputs.forEach(input => {
      input.value = '';
      input.defaultValue = '';
    });
  });
})()
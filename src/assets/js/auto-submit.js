(function() {
  formAutoSubmit = document.querySelector('.auto-submit');
  toggler = formAutoSubmit.querySelector('.toggler');

  toggler.addEventListener('change', ()=> {
    formAutoSubmit.submit();
  });
})()
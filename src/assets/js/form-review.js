(function() {
    const form = document.getElementById('form-review');
    console.log(form);
    form.addEventListener('submit', e => {
        e.preventDefault();
        let rating = document.getElementById('rating');
        if(rating.value == 0) {
            const modal = new bootstrap.Modal('#confirmRating');

            const modalElement = document.getElementById('confirmRating');
            const formModal = modalElement.querySelector('form');
            formModal.addEventListener('submit', e => {
                e.preventDefault();
                form.submit();
            }) 

            modal.show();
        } else {
            form.submit();
        }
    });
})()
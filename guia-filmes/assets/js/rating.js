(function() {
  const ratingList = document.querySelectorAll('#rating-list > *');
  ratingList.forEach(star => {
    star.addEventListener('click', () => {
      const ratingValue = star.getAttribute('data-rating');
      const inputRating = document.getElementById('rating');
      inputRating.value = ratingValue;

      unfillAllStars();
      fillStarsUntil(ratingValue);
    });

    star.addEventListener('dblclick', () => {
      const ratingValue = star.getAttribute('data-rating');
      const inputRating = document.getElementById('rating');
      inputRating.value = ratingValue - 0.5;

      unfillAllStars();
      fillStarsUntil(inputRating.value);
    });
  });

  function unfillAllStars() {
    ratingList.forEach(star => {
      star.firstChild.className = "bi bi-star";
    })
  }

  function fillStarsUntil(max) {
    ratingList.forEach(star => {
      if(star.getAttribute('data-rating') <= max) {
        star.firstChild.className = "bi bi-star-fill";
      }
    })

    if(Math.ceil(max) != max) {
      const star = ratingList[Math.floor(max)];
      star.firstChild.className = "bi bi-star-half";
      
    }
  }
})()
(function() {
  const likeToggler = document.getElementById('like-toggler');
  const likeInput = document.getElementById('like');
  
  likeToggler.addEventListener('click', () => {
    let likeIcon = likeToggler.querySelector('i');
    if(likeInput.value == 1) {
      likeIcon.className = "bi bi-heart";
      likeInput.value = 0;
    } else {
      likeIcon.className = "bi bi-heart-fill";
      likeInput.value = 1;
    }
  });
})()
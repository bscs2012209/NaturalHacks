function img(activeImg) {
    document.querySelector('.slide').src = activeImg;
}

  function change(change) {
    const line = document.querySelector('.home');
    line.style.background = change;
  }
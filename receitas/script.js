 window.addEventListener('scroll', function () {
    const imagem = document.getElementById('image');
    const limite = 305; // ponto onde ela vai grudar

    if (window.scrollY >= limite) {
      imagem.classList.add('fixo');
    } else {
      imagem.classList.remove('fixo');
    }
  });

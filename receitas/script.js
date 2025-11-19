window.addEventListener('scroll', function () {
    const imagem = document.getElementById('image');
    const footer = document.querySelector('footer');

    if (!imagem) return; // nada a fazer se não existir a imagem

    const limiteFixo = 320;  // ponto onde começa a ficar fixa
    const alturaImagem = imagem.offsetHeight;

    // Se não houver footer no HTML, colocamos um limiteParar muito grande
    let limiteParar;
    if (footer) {
        const distanciaFooter = footer.getBoundingClientRect().top + window.scrollY;
        limiteParar = distanciaFooter - alturaImagem - 250; // margem opcional
    } else {
        // Se quiser que pare em um certo ponto mesmo sem footer, ajuste aqui.
        limiteParar = Number.POSITIVE_INFINITY; // nunca para
    }

    if (window.scrollY >= limiteParar) {
        // PARAR a imagem: volta ao fluxo (posição absoluta dentro do container)
        imagem.classList.remove('fixo');
        imagem.classList.add('parou');

        // calcula top relativo ao documento para que a imagem "pare" antes do footer
        const topParado = limiteParar; 
        imagem.style.position = 'absolute';
        imagem.style.top = topParado + 'px';
        imagem.style.left = ''; // mantém o layout por CSS
    }
    else if (window.scrollY >= limiteFixo) {
        // IMAGEM FIXA
        imagem.classList.add('fixo');
        imagem.classList.remove('parou');

        // usa posição fixed para fixar na viewport
        imagem.style.position = 'fixed';
        imagem.style.top = '150px'; // top fixo dentro da viewport
        imagem.style.left = ''; // se quiser um left específico, defina no CSS
    }
    else {
        // comportamento normal: volta ao fluxo
        imagem.classList.remove('fixo');
        imagem.classList.remove('parou');
        imagem.style.position = '';
        imagem.style.top = '';
        imagem.style.left = '';
    }
});

document.addEventListener("DOMContentLoaded", () => {
    console.log("Favoritar.js carregado");

    const hearts = document.querySelectorAll(".heart-btn");
    console.log(`Encontrados ${hearts.length} corações para favoritar`);

    hearts.forEach(heart => {
        heart.addEventListener("click", async (e) => {
            e.preventDefault();
            e.stopPropagation();

            // Pega o ID da receita
            const id_receita = heart.getAttribute("data-id");
            console.log("ID da receita:", id_receita);
            
            // Verifica se o usuário está logado
            if (!id_receita) {
                if (typeof notifications !== 'undefined') {
                    notifications.error("Erro: ID da receita não encontrado");
                } else {
                    alert("Erro: ID da receita não encontrado");
                }
                return;
            }

            // Verifica se o coração já está favoritado
            const isFavorited = heart.classList.contains("favorited");
            console.log("Já estava favoritado?", isFavorited);
            
            // Alterna a classe de favorito (cor)
            heart.classList.toggle("favorited");

            // Adiciona animação
            heart.classList.add("animate");

            // Remove a animação após terminar (senão não repete)
            setTimeout(() => {
                heart.classList.remove("animate");
            }, 300);

            // Envia requisição para o servidor
            try {
                // Usa caminho absoluto para evitar problemas com rotas
                const url = window.location.origin + window.location.pathname.split('/').slice(0, -1).join('/') + '/favoritar/favoritar.php';
                
                console.log("URL da requisição:", url);

                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id_receita: parseInt(id_receita),
                        favoritado: isFavorited ? 0 : 1
                    })
                });

                console.log("Status da resposta:", response.status);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log("Resultado do servidor:", result);

                // Exibe notificação se o sistema de notificações estiver disponível
                if (result.ok) {
                    if (typeof notifications !== 'undefined') {
                        // Usa notificação específica de favorito
                        if (result.favoritado == 1) {
                            notifications.favorite(result.mensagem || 'Receita adicionada aos favoritos!');
                        } else {
                            notifications.unfavorite(result.mensagem || 'Receita removida dos favoritos!');
                        }
                    } else {
                        alert(result.mensagem || 'Operação realizada com sucesso');
                    }
                } else {
                    if (typeof notifications !== 'undefined') {
                        notifications.error(result.msg || "Erro ao processar sua solicitação");
                    } else {
                        alert(result.msg || "Erro ao processar sua solicitação");
                    }
                    // Desfaz a alteração visual em caso de erro
                    heart.classList.toggle("favorited");
                }
            } catch (error) {
                console.error("Erro ao favoritar:", error);
                if (typeof notifications !== 'undefined') {
                    notifications.error("Erro ao processar sua solicitação: " + error.message);
                } else {
                    alert("Erro ao processar sua solicitação: " + error.message);
                }
                // Desfaz a alteração visual em caso de erro
                heart.classList.toggle("favorited");
            }
        });
    });

});

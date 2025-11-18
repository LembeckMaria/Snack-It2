# Dark Mode - SnackIt

## Implementação Completa do Modo Escuro

Este documento descreve a implementação completa do **dark mode** no site SnackIt, incluindo todas as funcionalidades e arquivos modificados.

## 📁 Arquivos Adicionados

### 1. CSS do Dark Mode
- **Arquivo**: `css/dark-mode.css`
- **Função**: Contém todas as variáveis CSS e estilos específicos para o tema escuro
- **Características**:
  - Utiliza variáveis CSS customizadas (`--primary-color`, `--text-color`, etc.)
  - Aplica estilos usando o atributo `data-theme="dark"`
  - Inclui transições suaves entre temas
  - Responsivo para dispositivos móveis

### 2. JavaScript do Dark Mode
- **Arquivo**: `js/dark-mode.js`
- **Função**: Controla toda a lógica de alternância entre temas
- **Características**:
  - Classe `DarkModeToggle` para gerenciamento completo
  - Salva preferência do usuário no `localStorage`
  - Detecta preferência do sistema operacional
  - Botão flutuante para toggle
  - Ícones dinâmicos (lua/sol)

## 🎨 Funcionalidades Implementadas

### Toggle de Tema
- **Botão flutuante** no canto superior direito
- **Ícones dinâmicos**: 🌙 (tema claro) / ☀️ (tema escuro)
- **Posição fixa** que acompanha o scroll
- **Hover effects** com animações suaves

### Persistência de Preferência
- **localStorage**: Salva a escolha do usuário
- **Detecção automática**: Usa preferência do sistema se não houver escolha salva
- **Sincronização**: Mantém o tema entre páginas

### Transições Suaves
- **Animações CSS**: Transições de 0.3s para mudanças de cor
- **Efeito visual**: Mudança gradual entre temas
- **Performance otimizada**: Transições apenas nos elementos necessários

## 🎯 Páginas Integradas

O dark mode foi implementado em **todas as 17 páginas** do site:

1. `index.html` - Página inicial
2. `filmes-series.html` - Receitas de filmes e séries
3. `veganas.html` - Receitas veganas
4. `fitness.html` - Receitas fitness
5. `originais.html` - Receitas originais
6. `sobre.html` - Página sobre
7. `login.html` - Página de login
8. `perfil.html` - Página de perfil
9. `waffle.html` - Receita do waffle
10. `ratatouille.html` - Receita do ratatouille
11. `matilda.html` - Receita do bolo da Matilda
12. `serendipity.html` - Receita do frozen hot chocolate
13. `raspadinha-melancia.html` - Receita da raspadinha
14. `apfelstrudel.html` - Receita do apfelstrudel
15. `a-dama-e-o-vagabundo.html` - Receita do espaguete
16. `frozen-hot-chocolate.html` - Receita detalhada
17. `hamburguer-veg.html` - Receita do hambúrguer vegano

## 🔧 Como Funciona

### Estrutura CSS
```css
/* Variáveis para tema claro (padrão) */
:root {
    --primary-color: #cf92a5;
    --text-color: #333333;
    --white: #F5F5F5;
}

/* Variáveis para tema escuro */
:root[data-theme="dark"] {
    --primary-color: #e8a5b8;
    --text-color: #e0e0e0;
    --white: #121212;
}
```

### Estrutura JavaScript
```javascript
class DarkModeToggle {
    // Inicialização automática
    // Criação do botão toggle
    // Gerenciamento de eventos
    // Persistência de dados
}
```

## 📱 Responsividade

O dark mode é **totalmente responsivo** e inclui:

- **Botão adaptativo**: Tamanho menor em dispositivos móveis
- **Posicionamento otimizado**: Não interfere com a navegação
- **Touch-friendly**: Área de toque adequada para mobile
- **Performance**: Otimizado para diferentes tamanhos de tela

## 🎨 Paleta de Cores

### Tema Claro (Original)
- **Primária**: `#cf92a5` (Rosa suave)
- **Secundária**: `#C75C71` (Rosa médio)
- **Texto**: `#333333` (Cinza escuro)
- **Fundo**: `#F5F5F5` (Cinza claro)

### Tema Escuro
- **Primária**: `#e8a5b8` (Rosa claro)
- **Secundária**: `#d67a8f` (Rosa médio claro)
- **Texto**: `#e0e0e0` (Cinza claro)
- **Fundo**: `#121212` (Preto suave)

## 🚀 Como Usar

### Para Usuários
1. **Clique no botão** 🌙/☀️ no canto superior direito
2. **Alternância instantânea** entre temas
3. **Preferência salva** automaticamente
4. **Funciona em todas as páginas**

### Para Desenvolvedores
1. **CSS**: Adicione `css/dark-mode.css` após `styles.css`
2. **JavaScript**: Inclua `js/dark-mode.js` antes do `</body>`
3. **Automático**: O sistema se inicializa sozinho

## ✅ Testes Realizados

- ✅ **Toggle funcional** em todas as páginas
- ✅ **Persistência** entre navegação
- ✅ **Responsividade** em diferentes dispositivos
- ✅ **Acessibilidade** com labels apropriados
- ✅ **Performance** sem impacto na velocidade
- ✅ **Compatibilidade** com navegadores modernos

## 🎯 Benefícios

1. **Experiência do usuário**: Opção de tema preferido
2. **Acessibilidade**: Melhor para usuários com sensibilidade à luz
3. **Modernidade**: Funcionalidade esperada em sites atuais
4. **Profissionalismo**: Demonstra atenção aos detalhes
5. **Usabilidade**: Fácil de usar e intuitivo

---

**Implementado com sucesso em todas as páginas do SnackIt! 🎉**

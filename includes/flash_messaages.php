<?php
/**
 * Flash Messages - Exibe mensagens de sessão
 * Inclua este arquivo no início do <body> de suas páginas
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se há mensagens de sucesso
if (isset($_SESSION['mensagem_sucesso'])) {
    $mensagem = $_SESSION['mensagem_sucesso'];
    unset($_SESSION['mensagem_sucesso']);
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof notifications !== 'undefined') {
                notifications.success('<?php echo addslashes($mensagem); ?>');
            }
        });
    </script>
    <?php
}

// Verifica se há mensagens de erro
if (isset($_SESSION['mensagem_erro'])) {
    $mensagem = $_SESSION['mensagem_erro'];
    unset($_SESSION['mensagem_erro']);
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof notifications !== 'undefined') {
                notifications.error('<?php echo addslashes($mensagem); ?>');
            }
        });
    </script>
    <?php
}

// Verifica se há mensagens de aviso
if (isset($_SESSION['mensagem_aviso'])) {
    $mensagem = $_SESSION['mensagem_aviso'];
    unset($_SESSION['mensagem_aviso']);
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof notifications !== 'undefined') {
                notifications.warning('<?php echo addslashes($mensagem); ?>');
            }
        });
    </script>
    <?php
}

// Verifica se há mensagens de informação
if (isset($_SESSION['mensagem_info'])) {
    $mensagem = $_SESSION['mensagem_info'];
    unset($_SESSION['mensagem_info']);
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof notifications !== 'undefined') {
                notifications.info('<?php echo addslashes($mensagem); ?>');
            }
        });
    </script>
    <?php
}
?>

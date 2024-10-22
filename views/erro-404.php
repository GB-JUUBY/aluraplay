<?php
require_once __DIR__ . '/cabecalho.php';
?>
<main class="container">
    <div class="container__error">
        <h2 class="error__titulo">Error 404</h2>
        <p class="error__mensagem">
            Desculpe... Não foi possível encontrar "<?= $_SERVER['PATH_INFO'] ?>".
        </p>
    </div>
</main>
<?php require_once __DIR__ . '/rodape.php'; ?>
<?php

use Alura\MVC\Entity\Video;

require_once __DIR__ . '/cabecalho.php';

/** @var Video[] $listaVideos */
?>
<ul class="videos__container">
    <?php foreach ($listaVideos as $video) : ?>
        <li class="videos__item">
            <?php if ($video->getCaminhoImagem() !== null):?>
            <a href="<?= $video->url ?>">
                <img src="<?= "img/uploads/" . $video->getCaminhoImagem() ?>" alt="" style="width: 100%;">
            </a>
            <?php else:?>
            <iframe width="100%" height="72%" src="<?= $video->url; ?>"
                    title="YouTube video player"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
            <?php endif;?>
            <div class="descricao-video">
                <img src="/img/logo.png" alt="logo canal alura">
                <h3><?= $video->titulo; ?></h3>
                <div class="acoes-video">
                    <a href="/editar-video?id=<?= $video->id; ?>">Editar</a>
                    <?php if ($video->getCaminhoImagem() !== null):?>
                    <a href="/remover-capa?id=<?= $video->id; ?>">Remover capa</a>
                    <?php endif; ?>
                    <a href="/remover-video?id=<?= $video->id; ?>">Excluir</a>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?php require_once __DIR__ . '/rodape.php'; ?>
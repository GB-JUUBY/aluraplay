<?php require_once __DIR__ . "/cabecalho.php" ?>
    <main class="container">
        <form class="container__formulario" method="post">
            <h3 class="formulario__titulo">Efetue login</h3>
            <?php if (array_key_exists('sucesso', $_GET) && !is_null($_GET['sucesso']) && $_GET['sucesso'] == 0):?>
            <div class="error__aviso">
                Usuário ou senha inválidos.
            </div>
            <?php endif;?>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="usuario">Usuário</label>
                <input name="email" class="campo__escrita" required
                placeholder="Digite seu usuário" id='usuario' />
            </div>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="senha">Senha</label>
                <input type="password" name="senha" class="campo__escrita" required placeholder="Digite sua senha"
                        id='senha' />
            </div>
            <input class="formulario__botao" type="submit" value="Entrar" />
        </form>
    </main>
<?php require_once __DIR__ . "/cabecalho.php" ?>
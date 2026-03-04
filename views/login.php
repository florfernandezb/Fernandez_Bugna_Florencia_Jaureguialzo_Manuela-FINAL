<main class="container text-center">
    <section class="row justify-content-center">
        <h2>Inicia Sesión</h2>

        <?php if (!empty($_SESSION['login_error'])): ?>
            <div class="alert alert-danger col-12 col-md-6" role="alert">
                <?= htmlspecialchars($_SESSION['login_error'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>

        <?php if (!empty($login_message)): ?>
            <div class="alert alert-warning col-12 col-md-6" role="alert">
                <?= htmlspecialchars($login_message, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form action="./admin/actions/auth_login.php" method="POST">
            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="email" class="form-control" required>
                    </div>
                </div>    
            </div>
            
            <button type="submit" class="btn btn-dark form-button">Entrar</button>
    </form>
    </section>
</main>
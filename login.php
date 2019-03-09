<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	require_once __DIR__ . "/inc/layout/nav.php"; 
?>

<div class="container">
	<?php echo display_success(); ?>
    <?php print display_errors(); ?>
    <div class="col-sm-6 offset-sm-3">
        <form class="form-signin" method="post" action="/procedures/doLogin.php">
            <h2 class="form-signin-heading">Введите данные</h2>
            <label for="inputLogin" class="sr-only">Email</label>
            <input type="text" id="inputLogin" name="login" class="form-control" placeholder="Login" required autofocus>
            <label for="inputPassword" class="sr-only">Пароль</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
<?php

use App\Core\Router;
?>
<form action="<?= Router::url('login') ?>" method="POST">
    <h3>Login</h3>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error'] ?></p>
<?php unset($_SESSION['error']);
endif; ?>
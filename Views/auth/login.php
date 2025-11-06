<?php

use App\Core\Router;
?>
<div class="container pt-5">
    <div class="row">
        <div class="col-md-4 offset-md-4">

            <div class="border border-success p-3 rounded-3">
                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php unset($_SESSION['error']);
                endif; ?>


                <form action="<?= Router::url('login') ?>" method="post">
                    <div class="form-group mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm">Login</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php

use App\Core\Router;
?>
<div class="container">
  <div class="alert alert-primary" role="alert">
    <div class="row">
      <div class="col-md-10">
        <?= $title ?>
      </div>
      <div class="col-md-2 align-right">
        <a href="<?= Router::url('teachers.index') ?>" class="btn btn-sm btn-success">All teachers</a>
      </div>
    </div>
  </div>

</div>

<?php if (!empty($_SESSION['errors'])): ?>
  <div class="container">
    <div class="alert alert-danger alert-dismissible" role="alert">
      <?php foreach ($_SESSION['errors'] as $field => $messages): ?>
        <?php foreach ($messages as $msg): ?>
          <span class="d-block"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
      <?php endforeach; ?>

      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>
  </div>
  <?php unset($_SESSION['errors']); ?>
<?php endif; ?>



<form method="post" action="<?= Router::url('teachers.create.handle') ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control">
  </div>
  <button type="submit" class="btn btn-success">Create</button>
</form>
</div>
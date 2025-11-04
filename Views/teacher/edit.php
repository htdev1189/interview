<div class="container">
  <div class="row">
    <div class="alert alert-primary" role="alert">
      <?= $title ?>
    </div>
  </div>

  <?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <?php foreach ($_SESSION['errors'] as $field => $messages): ?>
        <?php foreach ($messages as $msg): ?>
          <span class="d-block"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
      <?php endforeach; ?>

      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>
    <?php unset($_SESSION['errors']); ?>
  <?php endif; ?>


  <form method="post" action="<?= Router::url('teachers.update') ?>">
    <input type="hidden" name="id" value="<?= $teacher['id'] ?>">
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($teacher['name']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($teacher['email']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($teacher['phone']) ?>">
    </div>
    <button type="submit" class="btn btn-success">Update</button>
  </form>


</div>
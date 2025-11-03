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

<form method="post" action="/interview/students/update">
  <input type="hidden" name="id" value="<?= $student['id'] ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($student['phone']) ?>">
  </div>
  <button type="submit" class="btn btn-success">Update</button>
</form>
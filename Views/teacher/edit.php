<?php ob_start(); ?>

<div class="container">
  <div class="row">
    <div class="col-md-10">
      <div class="alert alert-primary" role="alert">
        <?= $title ?>
      </div>
    </div>
  </div>
</div>


<form method="post" action="/interview/teachers/update">
    <input type="hidden" name="id" value="<?= $teacher->id ?>">
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($teacher->name) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($teacher->email) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($teacher->phone)?>">
    </div>
    <button type="submit" class="btn btn-success">Create</button>
</form>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . "/../layout.php"; ?>
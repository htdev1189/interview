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


<form method="post" action="/interview/students">
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
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . "/../layout.php"; ?>
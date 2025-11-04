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

<form method="post" action="/interview/teachers">
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
<form method="post" action="/interview/students/update">
    <input type="hidden" name="id" value="<?= $student->id ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student->name) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student->email) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($student->phone) ?>">
  </div>
  <button type="submit" class="btn btn-success">Update</button>
</form>

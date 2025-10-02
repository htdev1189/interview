<!-- views/teacher/list.php -->
<div class="alert alert-primary alert-sm" role="alert">
  <div class="row">
    <div class="col-9"><?= $title ?></div>
    <div class="col-3 text-end"><a href="/interview/teachers/create" class="btn btn-success btn-sm">Add New</a></div>
  </div>
</div>


<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($teachers as $teacher): ?>
      <tr>
        <th scope="row"><?= $teacher->id; ?></th>
        <td><?= $teacher->name; ?></td>
        <td><?= $teacher->email; ?></td>
        <td><?= $teacher->phone; ?></td>
        <td>
          <a href="/interview/teachers/edit/<?= $teacher->id ?>" class="btn btn-primary btn-sm">Edit</a>
          <form action="/interview/teachers/delete" method="POST" style="display:inline;"
            onsubmit="return confirm('Bạn có chắc chắn muốn xóa giáo viên này không?');">
            <input type="hidden" name="id" value="<?= $teacher->id ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>

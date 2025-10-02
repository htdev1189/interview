<!-- views/courses/list.php -->
<div class="alert alert-primary alert-sm" role="alert">
  <div class="row">
    <div class="col-md-10"><?= $title ?></div>
    <div class="col-md-2 text-end"><a href="/interview/courses/create" class="btn btn-success btn-sm">Add New</a></div>
  </div>
</div>


<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($courses as $course): ?>
      <tr>
        <th scope="row"><?= $course->id; ?></th>
        <td><?= $course->title; ?></td>
        <td><?= $course->description; ?></td>
        <td>
          <a href="/interview/courses/edit/<?= $course->id ?>" class="btn btn-primary btn-sm">Edit</a>
          <form action="/interview/courses/delete" method="POST" style="display:inline;"
            onsubmit="return confirm('Bạn có chắc chắn muốn xóa khóa học này không?');">
            <input type="hidden" name="id" value="<?= $course->id ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>

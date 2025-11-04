<?php

use App\Core\Router;
?>
<!-- views/courses/list.php -->
<div class="alert alert-primary alert-sm" role="alert">
  <div class="row">
    <div class="col-md-10"><?= $title ?></div>
    <div class="col-md-2 text-end"><a href="<?= Router::url('course.create') ?>" class="btn btn-success btn-sm">Add New</a></div>
  </div>
</div>

<!-- flash session -->
<?php
if (!empty($_SESSION['success'])) { ?>
  <div class="alert alert-success" role="alert">
    <div class="row">
      <div class="col md-6"><?= $_SESSION['success'] ?></div>
      <div class="col md-6 text-end"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    </div>
  </div>
<?php unset($_SESSION['success']);
} ?>

<?php if (!empty($_SESSION['error'])) { ?>
  <div class="alert alert-danger" role="alert">
    <div class="row">
      <div class="col md-6"><?= $_SESSION['error'] ?></div>
      <div class="col md-6 text-end"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    </div>
  </div>
<?php unset($_SESSION['error']);
} ?>



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
        <th scope="row"><?= $course['id']; ?></th>
        <td><?= $course['title']; ?></td>
        <td><?= $course['description']; ?></td>
        <td>
          <a href="<?= Router::url('course.edit',['id' => $course['id']]) ?>" class="btn btn-primary btn-sm">Edit</a>
          <form action="<?= Router::url('course.destroy',['id' => $course['id']]) ?>" method="POST" style="display:inline;"
            onsubmit="return confirm('Bạn có chắc chắn muốn xóa khóa học này không?');">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>

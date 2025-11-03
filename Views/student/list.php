<!-- views/student/list.php -->

<div class="alert alert-primary alert-sm" role="alert">
  <div class="row">
    <div class="col-md-9"><?= $title ?></div>
    <div class="col text-end"><a href="/interview/students/create" class="btn btn-success btn-sm">Add New</a></div>
    <div class="col text-end"><a href="/interview/students/registerCourse" class="btn btn-success btn-sm">Register course</a></div>
  </div>
</div>

<?php if (!empty($_SESSION['success'])) { ?>
  <div class="alert alert-success alert-dismissible" role="alert">
    <?= $_SESSION['success'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php unset($_SESSION['success']);
} ?>

<?php if (!empty($_SESSION['error'])) { ?>
  <div class="alert alert-danger alert-dismissible" role="alert">
    <?= $_SESSION['error'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php unset($_SESSION['error']);
} ?>


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
    <?php foreach ($students as $student): ?>
      <tr>
        <th scope="row"><?= $student['id']; ?></th>
        <td><?= $student['name']; ?></td>
        <td><?= $student['email']; ?></td>
        <td><?= $student['phone'] ?></td>
        <td>
          <a href="/interview/students/view/<?= $student['id'] ?>" class="btn btn-primary btn-sm">View</a>
          <a href="/interview/students/edit/<?= $student['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
          <form action="/interview/students/delete/<?= $student['id'] ?>" method="POST" style="display:inline;"
            onsubmit="return confirm('Bạn có chắc chắn muốn xóa sinh viên này không?');">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>
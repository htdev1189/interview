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


<form method="post" action="/interview/students/registerCourse">
    <div class="mb-3">
        <label class="form-label">Student</label>
        <select class="form-select" name="student_id">
            <option selected>Choise student</option>
            <?php foreach ($students as $student) { ?>
                <option value="<?= $student->id ?>"><?= $student->name ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Course</label>
        <select class="form-select" name="course_id">
            <option selected>Choise course</option>
            <?php foreach ($courses as $course) { ?>
                <option value="<?= $course->id ?>"><?= $course->title ?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
</form>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . "/../layout.php"; ?>
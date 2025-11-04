<?php

use App\Core\Router;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-primary" role="alert">
                <?= $title ?>
            </div>
        </div>
    </div>

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


    <form method="post" action="<?= Router::url('course.update', ['id' => $course['id']]) ?>">
        <input type="hidden" name="id" value="<?= $course['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($course['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="5"><?= htmlspecialchars($course['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Teacher</label>
            <select class="form-select" name="teacher_id">
                <option value="">Choise teacher</option>
                <?php foreach ($teachers as $teacher) { ?>
                    <option value="<?= $teacher['id'] ?>" <?= $course['teacher_id'] == $teacher['id'] ? 'selected' : '' ?>><?= $teacher['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update Course</button>
    </form>
</div>
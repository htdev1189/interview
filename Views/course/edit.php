<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="alert alert-primary" role="alert">
                <?= $title ?>
            </div>
        </div>
    </div>
    <form method="post" action="/interview/courses/update">
        <input type="hidden" name="id" value="<?= $course->id ?>">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($course->title) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="5"><?= htmlspecialchars($course->description) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Teacher</label>
            <select class="form-select" name="teacher_id">
                <option selected>Choise teacher</option>
                <?php foreach ($teachers as $teacher) { ?>
                    <option value="<?= $teacher->id ?>" <?= $course->teacher_id == $teacher->id ? 'selected' : '' ?>><?= $teacher->name ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update Course</button>
    </form>
</div>
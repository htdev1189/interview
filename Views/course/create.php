<div class="container">
    <div class="row">
        <div class="alert alert-primary" role="alert">
            <?= $title ?>
        </div>
    </div>

    <form method="post" action="/interview/courses">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Teacher</label>
            <select class="form-select" name="teacher_id">
                <option selected>Choise teacher</option>
                <?php foreach ($teachers as $teacher) { ?>
                    <option value="<?= $teacher->id ?>"><?= $teacher->name ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
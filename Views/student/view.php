<?php ob_start(); ?>
<div class="container">
    <div class="row">
        <div class="alert alert-primary alert-sm" role="alert">
            <div class="row">
                <div class="col-md-10"><?= $title ?></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">

            <div class="card mb-3" style="">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="https://images.unsplash.com/photo-1758633370468-686fba5ead85?q=80&w=385&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $student->name ?></h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                            <a class="btn btn-primary btn-sm" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">show courses</a>
                            <ul class="list-group mt-2 collapse" id="collapseExample">
                                <?php foreach ($student->courses as $course) { ?>
                                    <li class="list-group-item"><?= $course->title ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <!-- <div class="card">
                <img src="https://images.unsplash.com/photo-1758633370468-686fba5ead85?q=80&w=385&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $student->name ?></h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                    <a class="btn btn-primary btn-sm" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">show courses</a>
                    <ul class="list-group mt-2 collapse" id="collapseExample">
                        <?php foreach ($student->courses as $course) { ?>
                            <li class="list-group-item"><?= $course->title ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div> -->
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . "/../layout.php"; ?>
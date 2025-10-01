<?php ob_start(); ?>

<div class="container">
  <div class="row">
    <div class="col-md-10">
      <div class="alert alert-danger" role="alert">
        <?= $error ?>
      </div>
    </div>
  </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/../layout.php"; ?>
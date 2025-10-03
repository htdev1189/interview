<!-- layout/backend.php -->
<?php session_start(); ?>
<!-- flash session -->
<?php if(!empty($_SESSION['success'])) { ?>
<div class="alert alert-success" role="alert">
  <?= $_SESSION['success']?>
</div>
<?php unset($_SESSION['success']); } ?>

<?php if(!empty($_SESSION['error'])) { ?>
<div class="alert alert-danger" role="alert">
  <?= $_SESSION['error']?>
</div>
<?php unset($_SESSION['error']); } ?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? "Demo App" ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/interview">MyApp</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
              data-bs-target="#navbarNav" aria-controls="navbarNav" 
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/interview/students') ? 'active' : '' ?>" 
               href="/interview/students">Students</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/interview/teachers') ? 'active' : '' ?>" 
               href="/interview/teachers">Teachers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/interview/courses') ? 'active' : '' ?>" 
               href="/interview/courses">Courses</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container mt-3">
    <?= $content ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? "Demo App" ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <div class="container">

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
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                href="<?= Router::url('course.show') ?>">Courses</a>
            </li>
          </ul>

          <!-- Right side (user info + logout) -->
          <ul class="navbar-nav ms-auto">
            <?php

            use App\Core\Router;

            if (!empty($_SESSION['user'])): ?>
              <li class="nav-item">
                <span class="navbar-text text-light me-3">
                  👤 <?= htmlspecialchars($_SESSION['user']['name']) ?>
                </span>
              </li>
              <li class="nav-item">
                <form action="<?= Router::url('logout') ?>" method="POST" class="d-inline">
                  <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>


              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-3">
      <?= $content ?>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
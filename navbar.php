<?php 
    $URI = $_SERVER['REQUEST_URI'];
    $IS_INDEX = $URI == '/' || $URI == 'index.php';
    $IS_POSTS =  str_contains($URI, 'posts.php');
?>
<nav class="navbar navbar-dark bg-primary navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="./images/mohammad.svg" alt="" width="30" height="24" class="d-inline-block align-text-top">
      CRUD
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item <?= $IS_INDEX ? 'border-bottom' : '' ?>">
          <a class="nav-link <?= $IS_INDEX ? 'active' : '' ?>" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item <?= $IS_POSTS ? 'border-bottom' : '' ?>"">
          <a class="nav-link <?= $IS_POSTS ? 'active' : '' ?>" href="./posts.php">See posts 👀</a>
        </li>
      </ul>
    </div>
    <?= $URI; ?>
  </div>
</nav>
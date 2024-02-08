
<nav class="navbar navbar-expand-lg navbar-ligth bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/../home.php"><i class="fa-sharp fa-solid fa-house"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/../application/contact.php">Contact</a>
        </li>
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="/../login/login.php">Connexion</a>
          </li>
        <?php endif; ?>
        <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="/../application/recipes_create.php">Ajoutez une recette !</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/../login/logout.php">Déconnexion</a>
          </li>
        <?php endif; ?>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<script src="https://kit.fontawesome.com/b2ba396bc9.js" crossorigin="anonymous"></script>

<nav class="navbar">
      <div class="nav-center">
        <div class="nav-header">
          <a href="index.html" class="nav-logo">
            <img src="./assets/logo.svg" alt="simply recipes" />
          </a>
          <button class="nav-btn btn">
            <i class="fas fa-align-justify"></i>
          </button>
        </div>
        <div class="nav-links">
          <a href="index.html" class="nav-link"> home </a>
          <a href="about.html" class="nav-link"> about </a>
          <a href="tags.html" class="nav-link"> tags </a>
          <a href="recipes.html" class="nav-link"> recipes </a>

          <div class="nav-link contact-link">
            <a href="contact.html" class="btn"> contact </a>
          </div>
        </div>
      </div>
    </nav>
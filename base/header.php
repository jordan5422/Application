<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a href="../home.php" class="nav-logo">
      <img src="../final/assets/logo.svg" alt="simply recipes" />
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" style="justify-content: right;" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <?php if (!isset($_SESSION['LOGGED_USER'])): ?>
            <a class="nav-link" href="/../login/login.php">Connexion</a>
          <?php endif; ?>
        </li>
        <?php if (isset($_SESSION['LOGGED_USER'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="/../application/AjoutRecettes.php">Ajoutez une recette !</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/../login/logout.php">Déconnexion</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <div class="nav-link contact-link">
            <a class="nav-link" href="/../application/contact.php" class="btn">Contact</a>
          </div>
        </li>
        <?php if (isset($_SESSION['LOGGED_USER'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="/../application/profil.php">Profil</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<header class="hero">
  <div class="hero-container">
    <div class="hero-text">
      <h1>simply recipes</h1>
      <h4>no fluff, just recipes</h4>
    </div>
  </div>
</header>
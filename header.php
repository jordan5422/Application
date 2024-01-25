<nav class="navbar navbar-expand-lg navbar-ligth bg-ligth">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><i class="fa-sharp fa-solid fa-house"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Connexion</a>
          </li>
        <?php endif; ?>
        <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="recipes_create.php">Ajoutez une recette !</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Déconnexion</a>
          </li>
        <?php endif; ?>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-dark" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<script src="https://kit.fontawesome.com/b2ba396bc9.js" crossorigin="anonymous"></script>
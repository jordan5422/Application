<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profil.css">
    <link rel="stylesheet" href="static/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <section class="container main_sec">
        <div class="main">
            <div class="navbar row">
                    <?php
                    require_once(__DIR__ . '/../base/header.php');
                    ?>
            </div>
                <br>
           <div class="content">
                    <img src="/../images/soso.jpg" alt="photo de profil">
                    <br>
                    <a href="modifProfil.php"><button type="button">Modifier le Profil</button></a>
            </div>
            <div class="content">
            <img src="/../images/prive.jpg" alt="photo de profil">
            <img src="/../images/favorie.jpg" alt="photo de profil">
            <img src="/../images/like.jpg" alt="photo de profil"> 
            </div>
        </div>
    </section>
    <?php
    require_once(__DIR__ . '/../base/footer.php');
    ?>
</body>
</html>

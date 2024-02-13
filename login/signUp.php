<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact || Final</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="../final/assets/favicon.ico" type="image/x-icon" />
    <!-- normalize -->
    <link rel="stylesheet" href="../final/css/normalize.css" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <!-- main css -->
    <link rel="stylesheet" href="../final/css/main.css" />
</head>


<body class="justify-content-center">
    <!-- nav  -->
    <?php
    require_once(__DIR__ . '/../base/header.php');
    ?>
    <!-- end of nav -->
    <main class="page inscription" >
        <section class="contact-container">
            <article>
                <form class="form contact-form" method="post" action="">
                    <div class="form-row">
                        <label html="name" class="form-label">Votre nom</label>
                        <input type="text" name="name" id="name" class="form-input" />
                    </div>
                    <div class="form-row">
                        <label html="email" class="form-label">Votre e-mail</label>
                        <input type="text" name="email" id="email" class="form-input" />
                    </div>
                    <div class="form-row">
                        <label html="Mot de passe" class="form-label">mot de passe</label>
                        <input type="password" id="message" name="password" class="form-input" >
                    </div>
                    <div class="form-row">
                        <label html="Mot de passe" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" id="message" name="password" class="form-input" >
                    </div>
                    <br>
                    <button type="submit" class="btn btn-block">
                        Envoyer
                    </button>
                </form>
            </article>
        </section>
        <!-- featured recipes -->
      
    </main>
    <!-- footer -->
    <?php
    require_once(__DIR__ . '/../base/footer.php');
    ?>
</body>

</html>
<?php
session_start();
require_once(__DIR__ . '/../configuration/databaseconnect.php');
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');
$errors = [];
$photo = [];

if (!empty($_POST)) {
    $errors = validerInscription($_POST);
    $photo = verifPhoto($_FILES);
    if (empty($errors) && empty($photoErrors['errors'])) {
        ModifyUser($_POST, $mysqlClient, $photo);
    }
}
sessionMAJ(getAllUsers($mysqlClient));
$userCourant = $_SESSION['LOGGED_USER'];
?>


<!--Website: wwww.codingdung.com-->
<!DOCTYPE html>
<html lang="fr">

<?php
require_once(__DIR__ . '/../base/link.php');
?>

<body>
    <section class="container ">
        <?php
        require_once(__DIR__ . '/../base/header.php');
        ?>
        <div class="form-row justify-content-center">
            <?php
            if (!empty($errors) || !empty($phootoErrors)) {
                foreach ($errors as $error) {
                    echo '<span style="color: red;">' . htmlspecialchars($error) . '</span><br>';
                }
                foreach ($photo['errors'] as $error) {
                    echo '<span style="color: red;">' . htmlspecialchars($error) . '</span><br>';
                }
            }
            ?>
        </div>
        <div class="container light-style flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                Account settings
            </h4>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="card overflow-hidden">
                    <div class="row no-gutters row-bordered row-border-light">
                        <div class="col-md-3 pt-0">
                            <div class="list-group list-group-flush account-settings-links">
                                <a class="list-group-item list-group-item-action active" data-toggle="list"
                                    href="#account-general">Contact</a>
                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-change-password">Changer de mot de passe</a>
                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-social-links">Mes recettes</a>
                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-info">Informations</a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">

                                <div class="card-body media align-items-center">
                                    <?php echo '<img src="' . $userCourant['photo'] . '" alt
                                        class="d-block ui-w-80">'; ?>

                                    <br>
                                    <div class="media-body ml-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="screenshot" class="btn btn-outline-primary">
                                                    Nouvelle photo
                                                    <input type="file" name="screenshot" id="screenshot"
                                                        class="account-settings-fileinput form-control">
                                                </label> &nbsp;
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="tab-pane fade active show" id="account-general">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label">Nom</label>
                                            <?php echo '<input type="text" class="form-control mb-1" name="nom" value="' . $userCourant["nom"] . '">' ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">E-mail</label>
                                            <?php echo '<input type="text" class="form-control mb-1" name="email" value="' . $userCourant["email"] . '">' ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Telephone</label>
                                            <?php echo '<input type="number" class="form-control mb-1" name="telephone" value="' . $userCourant["telephone"] . '">' ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-change-password">
                                    <div class="card-body pb-2">
                                        <div class="form-group">
                                            <label class="form-label">Nouveau mot de passe</label>
                                            <?php echo '<input type="text" class="form-control mb-1" name="password" value="' . $userCourant["password"] . '">' ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Confirmation</label>
                                            <?php echo '<input type="text" class="form-control mb-1" name="Cpassword" value="' . $userCourant["password"] . '">' ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-social-links">
                                    <div class="card-body pb-2">
                                        <div class="form-group">
                                            <label class="form-label">Twitter</label>
                                            <input type="text" class="form-control" value="https://twitter.com/user">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Facebook</label>
                                            <input type="text" class="form-control"
                                                value="https://www.facebook.com/user">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Google+</label>
                                            <input type="text" class="form-control" value>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">LinkedIn</label>
                                            <input type="text" class="form-control" value>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Instagram</label>
                                            <input type="text" class="form-control"
                                                value="https://www.instagram.com/user">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-info">

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>&nbsp;
                    <a href="/application/deleteAccount.php"><button type="" class="btn btn-danger">Supprimer le
                            compte</button></a>&nbsp;
                </div>
            </form>
        </div>
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript">

        </script>
    </section>
    <br>
    <?php
    require_once(__DIR__ . '/../base/footer.php');
    ?>
</body>

</html>
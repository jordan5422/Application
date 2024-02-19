<?php
session_start();
require_once(__DIR__ . '/../configuration/databaseconnect.php');
require_once(__DIR__ . '/../variables/variables.php');
require_once(__DIR__ . '/../variables/functions.php');
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
        <div class="container light-style flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">
                Account settings
            </h4>
            <form action="" method="post">
                <div class="card overflow-hidden">
                    <div class="row no-gutters row-bordered row-border-light">
                        <div class="col-md-3 pt-0">
                            <div class="list-group list-group-flush account-settings-links">
                                <a class="list-group-item list-group-item-action active" data-toggle="list"
                                    href="#account-general">General</a>
                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-change-password">Change password</a>
                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-info">Info</a>

                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">

                                <div class="card-body media align-items-center">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt
                                        class="d-block ui-w-80">
                                    <br>
                                    <div class="media-body ml-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="btn btn-outline-primary">
                                                    Nouvelle photo
                                                    <input type="file" name="photo" class="account-settings-fileinput">
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
                                            <input type="text" class="form-control mb-1" name="nom">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">E-mail</label>
                                            <input type="text" class="form-control mb-1" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Telephone</label>
                                            <input type="number" class="form-control mb-1" name="telephone">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-change-password">
                                    <div class="card-body pb-2">
                                        <div class="form-group">
                                            <label class="form-label">Mot de passe</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Nouveau mot de passe</label>
                                            <input type="password" name="Npassword" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Confirmation</label>
                                            <input type="password" name="Cpassword" class="form-control">
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
                    <button type="submit" class="btn btn-danger">Supprimer le compte</button>&nbsp;
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
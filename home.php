<?php
session_start();
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/configuration/databaseconnect.php');
require_once(__DIR__ . '/variables/variables.php');
require_once(__DIR__ . '/variables/functions.php');
require_once(__DIR__ . '/application/isConnect.php');
?>
<!-- inclusion des variables et fonctions -->

<!DOCTYPE html>
<html>

<?php
require_once(__DIR__ . '/base/link.php');
?>

<body>
    <section class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/base/header.php'); ?>
        <main class="page">
            <div class="main">
            <?php require_once(__DIR__ . '/application/content.php'); ?>
            </div>
        </main>
    </section>
    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/base/footer.php'); ?>
</body>

</html>
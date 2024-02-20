<?php

function displayAuthor(string $authorEmail, array $users): string
{
    foreach ($users as $user) {
        if ($authorEmail === $user['email']) {
            return $user['full_name'] . '(' . $user['age'] . ' ans)';
        }
    }

    return 'Auteur inconnu';
}

function isValidRecipe(array $recipe): bool
{
    if (array_key_exists('is_enabled', $recipe)) {
        $isEnabled = $recipe['is_enabled'];
    } else {
        $isEnabled = false;
    }

    return $isEnabled;
}

function getRecipes(array $recipes): array
{
    $valid_recipes = [];

    foreach ($recipes as $recipe) {
        if (isValidRecipe($recipe)) {
            $valid_recipes[] = $recipe;
        }
    }

    return $valid_recipes;
}

function redirectToUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}

function validerInscription($formulaire)
{
    // Assignation et nettoyage des données soumises
    $nom = trim($formulaire['nom']);
    $email = trim($formulaire['email']);
    $password = $formulaire['password'];
    $confirmPassword = $formulaire['Cpassword'];

    // Initialisation d'un tableau pour stocker les messages d'erreur
    $errors = [];

    // Validation du nom
    if (empty($nom)) {
        $errors["nom"] = "Le nom est requis.";
    }

    // Validation de l'email
    if (empty($email)) {
        $errors["email"] = "L'e-mail est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'adresse e-mail n'est pas valide.";
    }

    // Validation du mot de passe
    if (empty($password)) {
        $errors["password"] = "Le mot de passe est requis.";
    } elseif (strlen($password) < 8) {
        $errors["password"] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    // Vérification de la correspondance des mots de passe
    if ($password !== $confirmPassword) {
        $errors["Cpassword"] = "Les mots de passe ne correspondent pas.";
    }

    return $errors;
}

function addUser($postData, $mysqlClient)
{
    $insertRecipe = $mysqlClient->prepare('INSERT INTO users(mail, password, telephone, nom, role) VALUES (:mail, :password, :telephone, :nom, :role)');
    $insertRecipe->execute([
        'mail' => $postData['email'],
        'password' => $postData['password'],
        'telephone' => (int)$postData['telephone'],
        'nom' => $postData['nom'],
        'role' => 'user',
    ]);
}

function ModifyUser($postData, $mysqlClient)
{
    $insertRecipe = $mysqlClient->prepare('INSERT INTO users(mail, password, telephone, nom, role) VALUES (:mail, :password, :telephone, :nom, :role)');
    $insertRecipe->execute([
        'mail' => $postData['email'],
        'password' => $postData['password'],
        'telephone' => 0000,
        'nom' => $postData['nom'],
        'role' => 'user',
    ]);
}



function post($data, $url)
{
    $ch = curl_init();
    $queryString = http_build_query($data);
    // Spécifiez l'URL de destination de votre requête cURL
    curl_setopt($ch, CURLOPT_URL, "http://exemple.com/traitement.php");
    // Indiquez à cURL que vous souhaitez effectuer une requête POST
    curl_setopt($ch, CURLOPT_POST, true);
    // Attachez la chaîne de requête en tant que données POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $queryString);
    // Retournez la réponse au lieu de l'afficher
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Exécutez la session cURL
    $response = curl_exec($ch);
    // Fermez la session cURLs
    curl_close($ch);
    // Affichez la réponse du serveur
    echo $response;
}


function addRecette($postData, $mysqlClient, $file)
{
    $recipeId = 0;
    $errors = [];
    if (!empty($postData)) {


        //recupere données du formulaire

        $name = $postData['name'];
        $nbr = $postData['nbr'];
        $type = $postData['type'];
        $temps_prep = $postData['temps_preparation'];
        $temps_cuis = $postData['temps_cuisson'];
        $description = $postData['description'];
        $instruction = $postData['instruction_cuisson'];

        // Traitement de l'image
        $target_dir = "uploads/"; // Assurez-vous que ce dossier existe et est accessible en écriture
        $target_file = $target_dir . basename($file["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifiez si le fichier est une image réelle
        //if(isset($postData["submit"])) {
        $check = getimagesize($file["photo"]["tmp_name"]);
        if ($check !== false) {
            // echo "Le fichier est une image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $errors["type"] =  "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
        //}

        $id = 1;
        //ajout dans BD
        if ($uploadOk == 1) {
            $sql = "INSERT INTO recette (nom, type, nombre_plats, temps_preparation, temps_Cuisson, photo, description, instruction_cuisson,id_users) VALUES (?, ?,?, ?, ?, ?, ?, ?,?)";
            $stmt = $mysqlClient->prepare($sql);

            try {
                $stmt->execute([$name, $nbr, $type, $temps_prep, $temps_cuis, $target_file, $description, $instruction, $id]);
                // echo "Recette ajoutée avec succès.";
            } catch (PDOException $e) {
                $errors["insertion"] =  "Erreur lors de l'insertion des données: " . $e->getMessage();
            }
        } else {
            $errors["telechargement"] =  "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
            $uploadOk = 0; // Marquer le téléchargement comme échoué
        }


        // echo "Ingrédient ajouté avec succès dans la bd";

        // Déplacez le fichier téléchargé vers le nouveau chemin
        if (move_uploaded_file($file["photo"]["tmp_name"], $target_file)) {

            // Utilisation de lastInsertId pour obtenir l'ID de la dernière insertion
            $recipeId = $mysqlClient->lastInsertId();


            // Redirection vers l'autre page en incluant l'ID dans l'URL
            // header('Location: ../AjoutIngredient.php?id=' . $recipeId);

        } else {
            $errors["telechargement"] =  "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }
    return ["id" => $recipeId, "erreur" => $errors];
}

function addIngredient($postData,$mysqlClient)
{
    $errors = [];
    if (!empty($postData)) {
        //recupere données du formulaire
        echo "je recupere mes donnees";
        $name = $postData['name'];
        $origine = $postData['origine'];
        $quantite = $postData['quantite'];
        $description = $postData['message'];


        // Traitement de l'image
        $target_dir = "uploads/"; // Assurez-vous que ce dossier existe et est accessible en écriture
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifiez si le fichier est une image réelle
        //if(isset($postData["submit"])) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $errors["extension"] =  "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
        //}


        if ($uploadOk == 1) {
            $sql = "INSERT INTO ingredients (nom, origine, quantite, photo, description, id_recette) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $mysqlClient->prepare($sql);

            try {
                $stmt->execute([$name, $origine, $quantite, $target_file, $description, 5]);
                redirectToUrl("home.php");
            } catch (PDOException $e) {
                $errors["insertion"] = "Erreur lors de l'insertion des données: " . $e->getMessage();
                redirectToUrl("AjoutIngredient.php");
            }
        } else {
            $errors["telechargement"] =  "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
            $uploadOk = 0; // Marquer le téléchargement comme échoué
        }

        // Déplacez le fichier téléchargé vers le nouveau chemin
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // echo "Le fichier " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " a été téléchargé.";
        } else {
            // echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            $errors["telechargement"] = "Erreur de telechargement de fichier";
        }
        // Utilisation de lastInsertId pour obtenir l'ID de la dernière insertion
    }
    return $errors;
}

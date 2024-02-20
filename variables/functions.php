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

function getAllUsers($mysqlClient)
{
    $usersStatement = $mysqlClient->prepare('SELECT * FROM users');
    $usersStatement->execute();
    $users = $usersStatement->fetchAll();
    return $users;
}

// mise a jour des données de session 
function sessionMAJ($users)
{
    foreach ($users as $user) {
        if (
            $user['mail'] === $_SESSION['LOGGED_USER']['email']
        ) {
            $_SESSION['LOGGED_USER'] = [
                'email' => $user['mail'],
                'id' => $user['id'],
                'nom' => $user['nom'],
                'telephone' => $user['telephone'],
                'role' => $user['role'],
                'photo' => $user['photo'],
                'password' => $user['password'],
            ];
            break;
        }
    }
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
        'telephone' => (int) $postData['telephone'],
        'nom' => $postData['nom'],
        'role' => 'user',
    ]);
}

function deleteUser($postData, $mysqlClient)
{
    // Préparation de la requête de suppression
    $deleteUser = $mysqlClient->prepare('DELETE FROM users WHERE mail = :mail');

    // Exécution de la requête de suppression
    $deleteUser->execute([
        'mail' => $postData['email']
    ]);
}


function ModifyUser($postData, $mysqlClient, $photo)
{
    // Assurez-vous que le champ 'photo' est inclus dans $postData si nécessaire
    $updateUser = $mysqlClient->prepare('UPDATE users SET password = :password, telephone = :telephone, nom = :nom, role = :role, photo = :photo WHERE mail = :mail');

    // Exécution de la requête avec les données passées en paramètre
    $updateUser->execute([
        'mail' => $postData['email'],
        'password' => $postData['password'], // Assurez-vous de hasher le mot de passe avant l'insertion
        'telephone' => $postData['telephone'], // Assurez-vous que 'telephone' est fourni dans $postData
        'nom' => $postData['nom'],
        'role' => $postData['role'] ?? 'user', // Utilisation de l'opérateur null coalescent pour définir une valeur par défaut
        'photo' => $photo['filePath'] // Assurez-vous que 'photo' est fourni dans $postData
    ]);
}




function post($data, $url)
{
    $ch = curl_init();
    $queryString = http_build_query($data);
    // Spécifiez l'URL de destination de votre requête cURL
    curl_setopt($ch, CURLOPT_URL, "http://exemple.com/traitement.php");
    // Indiquez à cURL que vous souhaitez effectuer une requête POST
    curl_setopt($ch, CURLOPTpostData, true);
    // Attachez la chaîne de requête en tant que données POST
    curl_setopt($ch, CURLOPTpostDataFIELDS, $queryString);
    // Retournez la réponse au lieu de l'afficher
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Exécutez la session cURL
    $response = curl_exec($ch);
    // Fermez la session cURLs
    curl_close($ch);
    // Affichez la réponse du serveur
    echo $response;
}

function addPhoto($postData, $mysqlClient, $id)
{
    $insertRecipe = $mysqlClient->prepare('INSERT INTO photo(nom, lien, id_recette) VALUES (:nom, :dossier, :id_recette)');
    $insertRecipe->execute([
        'nom' => $postData['nom'],
        'dossier' => $postData['dossier'],
        'id_recette' => (int) $id,
    ]);
}

function deletePhoto($postData, $mysqlClient)
{
    // Préparation de la requête de suppression
    $deletePhoto = $mysqlClient->prepare('DELETE FROM photo WHERE id = :id ');
    // Exécution de la requête de suppression
    $deletePhoto->execute([
        'id' => $postData['id'],
    ]);
}


function addIngredient($postData, $mysqlClient, $file)
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
        $target_file = $target_dir . basename($file["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifiez si le fichier est une image réelle
        //if(isset($postData["submit"])) {
        $check = getimagesize($file["photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $errors["extension"] = "Le fichier n'est pas une image.";
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
            $errors["telechargement"] = "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
            $uploadOk = 0; // Marquer le téléchargement comme échoué
        }

        // Déplacez le fichier téléchargé vers le nouveau chemin
        if (move_uploaded_file($file["photo"]["tmp_name"], $target_file)) {
            // echo "Le fichier " . htmlspecialchars(basename($file["photo"]["name"])) . " a été téléchargé.";
        } else {
            // echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            $errors["telechargement"] = "Erreur de telechargement de fichier";
        }
        // Utilisation de lastInsertId pour obtenir l'ID de la dernière insertion
    }
    return $errors;
}



function verifPhoto($file)
{
    $photoErrors = [];
    $isFileLoaded = false;
    $newFileName = '1.jpg';
    if (isset($file['screenshot']) && $file['screenshot']['error'] === 0) {
        if ($file['screenshot']['size'] > 5 * 1024 * 1024 * 1024) {
            $photoErrors["volume"] = "Fichier trop volumineux";
        }

        $fileInfo = pathinfo($file['screenshot']['name']);
        $extension = strtolower($fileInfo['extension']);
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        if (!in_array($extension, $allowedExtensions)) {
            $photoErrors["extension"] = "L'extension '{$extension}' n'est pas autorisée";
        }

        $path = __DIR__ . '../final/assets/';
        if (!is_dir($path) && !mkdir($path, 0755, true)) {
            $photoErrors["dossier"] = "Le dossier 'uploads' est manquant et n'a pas pu être créé";
        }

        if (empty($photoErrors)) {
            $newFileName = uniqid('photo_', true) . '.' . $extension;
            if (!move_uploaded_file($file['screenshot']['tmp_name'], $path . $newFileName)) {
                $photoErrors["echec_deplacement"] = "Erreur lors du déplacement du fichier";
            } else {
                $isFileLoaded = true;
            }
        }
    } else {
        $photoErrors["fichier"] = "Aucun fichier envoyé ou erreur inconnue";
    }

    return ['errors' => $photoErrors, 'isFileLoaded' => $isFileLoaded, 'nom' => $newFileName, 'dossier' => "final/assets", 'filePath' => $isFileLoaded ? "/../uploads/" . $newFileName : ''];
}


function addRecette($postData, $mysqlClient, $id)
{
    $errors = [];
    $recipeId = 0;
    if (!empty($postData)) {
        $name = $postData['name'];
        $nbr = $postData['nbr'];
        $type = $postData['type'];
        $temps_prep = $postData['temps_preparation'];
        $temps_cuis = $postData['temps_cuisson'];
        $description = $postData['description'];
        $instruction = $postData['instruction_cuisson'];

        $sql = "INSERT INTO recette (nom, type, nombre_plats, temps_preparation, temps_Cuisson, instruction_cuisson, id_users) VALUES ( ?, ?, ?, ?, ?, ?,?)";
        $stmt = $mysqlClient->prepare($sql);
        $stmt->execute([$name, $type, $nbr, $temps_prep, $temps_cuis, $instruction, $_SESSION['LOGGED_USER']['id']]);
        $recipeId = $mysqlClient->lastInsertId();
    } else {
        $errors['donnees'] = "donnees manquantes";
    }
    return ["erreur" => $errors, "id" => $recipeId];
}


function modifRecette($postData, $mysqlClient, $file)
{
    $errors = [];
    if (!empty($postData) && !empty($file)) {
        // Récupère les données du formulaire
        $name = $postData['name'];
        $nbr = $postData['nbr'];
        $type = $postData['type'];
        $temps_prep = $postData['temps_preparation'];
        $temps_cuis = $postData['temps_cuisson'];
        $description = $postData['description'];
        $instruction = $postData['instruction_cuisson'];

        // Préparation de la requête de mise à jour
        $sql = "UPDATE recette SET nom = ?, type = ?, nombre_plats = ?, temps_preparation = ?, temps_Cuisson = ?, description = ?, instruction_cuisson = ? WHERE id_recette = ?";
        $stmt = $mysqlClient->prepare($sql);
        $stmt->execute([$name, $nbr, $type, $temps_prep, $temps_cuis, $description, $instruction]);
    } else {
        $errors['donnees'] = "Données manquantes";
    }
    return $errors;
}


function validerDonnee($formulaire)
{
    $errors = [];
    foreach ($formulaire as $donnee) {
        if (empty($donnee)) {
            $errors["donnee"] = "Il ya une donnee manquante !";
            break;
        }
    }
    return $errors;
}


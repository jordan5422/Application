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
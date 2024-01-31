<?php
// Vérifie si des données POST ont été envoyées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez quelle action a été demandée (connexion ou nouveau compte)
    $action = $_POST["action"];

    // Récupérez le nom d'utilisateur et le mot de passe soumis
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Si l'action est "login" (connexion)
    if ($action === "login") {
        // Vérifiez si l'utilisateur existe dans le fichier .txt
        $users = file_get_contents("Utilisateurs.txt");
        $user_array = explode("\n", $users);
        foreach ($user_array as $user) {
            $user_details = explode(",", $user);
            if ($user_details[0] === $username && $user_details[1] === $password) {
                // Redirigez l'utilisateur vers une page sécurisée
                header("Location: PremierePageAnnexe.html");
                exit;
            }
        }
        // Affichez un message d'erreur
        echo "<script>alert('Mot de passe ou nom d\\'utilisateur incorrect.');</script>";
    }
    // Si l'action est "new" (nouveau compte)
    elseif ($action === "new") {
        // Vérifiez si le nom d'utilisateur est unique
        $users = file_get_contents("Utilisateurs.txt");
        $user_array = explode("\n", $users);
        $username_exists = false;
        foreach ($user_array as $user) {
            $user_details = explode(",", $user);
            if ($user_details[0] === $username) {
                $username_exists = true;
                break;
            }
        }
        if ($username_exists) {
            // Affichez un message d'erreur
            echo "<script>alert('Ce nom d\\'utilisateur est déjà pris.');</script>";
        } else {
            // Enregistrez le nouvel utilisateur dans le fichier .txt
            $new_user = $username . "," . $password . "\n";
            file_put_contents("Utilisateurs.txt", $new_user, FILE_APPEND);
            // Redirigez l'utilisateur vers une page de confirmation
            header("Location: index.html");
            exit;
        }
    }
}
?>

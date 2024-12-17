<?php
// fonction qui permet de se connecter a une base de donnee
function openconnexion()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "examen";  
    // Create connection
    $conn = mysqli_connect($servername, $username, $password,$db);
    return $conn;
}

//fonction pour afficher la liste des
function listeprof($con)
{
    $sql = "SELECT id,nom, prenom,login,password,sexe,age,matiere FROM users";
    $result = mysqli_query($con, $sql);
    $Tab1 = [];
    if (mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $Tab1[] = $row;
        }
    }
    else
    {
        echo "0 resultats";
    }

    return $Tab1;
}

//fonction pour afficher les professeurs
function afficherProfesseur($email, $motdepasse, $conn) 
{
    // Préparer la requête SQL
    $sql = "SELECT * FROM users WHERE login = ? AND password = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) 
    {
        mysqli_stmt_bind_param($stmt, "ss", $email, $motdepasse);
        
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            mysqli_stmt_close($stmt);
            return $row; // Retourner les données du professeur
        }
        
        mysqli_stmt_close($stmt);
    }
    
    return null; // Retourner null si aucun résultat ou échec
}

//fonction pour ajouter un professeurs dans la base
function ajoutprof($nom,$prenom,$sexe,$age,$motpass,$email,$matiere,$con)
{
    // ajouter un professeur
    $sql = "INSERT INTO users (nom,prenom,sexe,age,password,login,matiere)
            VALUES ('$nom','$prenom','$sexe','$age','$motpass','$email','$matiere')";
    $result = mysqli_query($con, $sql);
    if ($result)
    {
        echo "Professeur ajouté avec success";
    } 
    else
    {
        echo "Erreur: " . $sql . "<br>" . mysqli_error($con);
    }

    return $result;
}

//fonction pour ajouter un cour dans la base
function ajoutcour($titre,$dure,$nomprof,$prenomprof,$con)
{
    // ajouter un cour
    $sql = "INSERT INTO user (titre,dure,nomprof,prenomprof)
            VALUES ('$titre','$dure','$nomprof','$prenomprof')";
    $result = mysqli_query($con, $sql);
    if ($result)
    {
        echo "Cour ajouté avec success";
    } 
    else
    {
        echo "Erreur: " . $sql . "<br>" . mysqli_error($con);
    }

    return $result;
}

//fonction pour afficher la liste des cours
function listecour($con)
{
    $sql = "SELECT id,titre,dure,nomprof,prenomprof FROM user";
    $result = mysqli_query($con, $sql);
    $Tab1 = [];
    if (mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $Tab1[] = $row;
        }
    }
    else
    {
        echo "0 resultats";
    }

    return $Tab1;
}


//ouvrir la connection
$con = openconnexion();
if (!$con)
{
    die("Erreur de connexion " . mysqli_connect_error());
}

//recevoir les valeurs depuis la formulaire
    if(isset($_POST['id']) && isset($_POST['nom']) &&isset($_POST['prenom'])  && isset($_POST['password'])  && isset($_POST['email'])&& isset($_POST['age']) && isset($_POST['sexe']) && isset($_POST['matiere']))
    {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $id = $_POST['id'];
            $sexe = $_POST['sexe'];
            $age = $_POST['age'];
            $matiere = $_POST['matiere'];
            $motpass = $_POST['password'];
            $email = $_POST['email'];
            ajoutprof($id,$nom,$prenom,$sexe,$age,$motpass,$email,$matiere,$con);
    }

//fonction qui permet de verifier si le email et le mot de passe existent dans la base de donnee
function login($email,$motpass,$con)
{
    $sql = "SELECT * FROM users WHERE login = '$email' and password = '$motpass'";
    $result = mysqli_query($con, $sql);
    return $result;
}
mysqli_close($con);


// fonction pour suprimer uu cour au niveau de base de donnee
function supprimerprof($id,$c)
{
    $sql = "DELETE FROM users WHERE id=$id";
    if (mysqli_query($c, $sql)) {
    echo "Etudiant supprimé avec success";
    } else {
    echo "Erreur de suppression: " . mysqli_error($c);
    }
    mysqli_close($c);
}

// fonction pour suprimer uu cour au niveau de base de donnee
function supprimercour($id,$c)
{
    $sql = "DELETE FROM user WHERE id=$id";
    if (mysqli_query($c, $sql)) {
    echo "Cour supprimé avec success";
    } else {
    echo "Erreur de suppression: " . mysqli_error($c);
    }
    mysqli_close($c);
}

function modifierprof($c, $id, $nom, $prenom, $sexe, $age, $mot_de_passe, $email, $matiere) 
{
    $stmt = $c->prepare("UPDATE users SET nom=?, prenom=?, sexe=?, age=?, password=?, login=?, matiere=? WHERE id=?");
    
    // "sssisssi" signifie : chaîne, chaîne, chaîne, entier, chaîne, chaîne, chaîne, entier
    $stmt->bind_param("sssisssi", $nom, $prenom, $sexe, $age, $mot_de_passe, $email, $matiere, $id);

    if ($stmt->execute() === TRUE) {
        echo "Professeur modifié avec succès";
    } else {
        echo "Erreur de modification: " . $c->error;
    }

    // Fermer la déclaration préparée et la connexion
    $stmt->close();
    $c->close();
}


function modifiercour($c, $id, $titre, $nomprof, $prenomprof, $duree) 
{
    $stmt = $c->prepare("UPDATE user SET titre=?, nomprof=?, prenomprof=?, dure=? WHERE id=?");
    
    // "sssii" signifie : chaîne, chaîne, chaîne, entier, entier
    $stmt->bind_param("sssii", $titre, $nomprof, $prenomprof, $duree, $id);

    if ($stmt->execute() === TRUE) {
        echo "Cour modifié avec succès";
    } else {
        echo "Erreur de modification: " . $c->error;
    }

    // Fermer la déclaration préparée et la connexion
    $stmt->close();
    $c->close();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Mon Site</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['REQUEST_URI']) == 'index.php' ? 'active' : ''; ?>" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['REQUEST_URI']) == 'about.php' ? 'active' : ''; ?>" href="about.php">À propos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['REQUEST_URI']) == 'contact.php' ? 'active' : ''; ?>" href="contact.php">Contact</a>
            </li>
        </ul>
    </div>
</nav>

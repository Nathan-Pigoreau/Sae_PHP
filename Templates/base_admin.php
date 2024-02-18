<?php
    if (session_status() == PHP_SESSION_NONE){
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Static/css/base.css">
    <title>Gaitunes</title>
</head>
<body>
    <header>
            <div class="nav">
                <nav>
                    <ul>
                        <li>
                            <!-- <img src="Static/images/home.png" alt="écran d'accueil"/> -->
                            </a>
                        </li>
                        <li>
                            <a href="/">Accueil</a>
                        </li>
                        <li>
                            <a href="/playlists">Playlist</a>
                        </li>
                        <li>
                            <a href="/profil">Profil</a>
                        </li>
                        <li>
                            <a href="/favoris">Favoris</a>
                        </li> 
                        <li>
                            <a href="/admin/albums">gestionAlbums</a>
                        </li>
                        <li>
                            <a href="/admin/musiques">gestionMusiques</a>
                        </li>
                        <li>
                            <a href="/admin/artistes">gestionArtistes</a>
                        </li>    
                    </ul>
                </nav>
            </div>
            <div class="search">
                    <input type="search" id="search" name="search" placeholder="Rechercher un titre, un artiste, un album...">
                    <?php 
                        if(isset($_SESSION['user'])){
                            echo '<p>Bonjour '.$_SESSION['user']->getPseudo().'</p>';
                            echo '<a href="/logout">Déconnexion</a>';
                        }
                        else{
                            echo '<a href="/login">Connexion</a>';
                        }
                    ?>
                    <img id='logo' src='/Static/images/logo.png' alt="Icone gaitunes">
            </div>
    </header>
    
</body>
</html>
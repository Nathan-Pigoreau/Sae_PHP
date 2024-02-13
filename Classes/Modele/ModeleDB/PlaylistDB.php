<?php

declare(strict_types=1);

namespace Modele\ModeleDB;

use PDO;
use Modele\DataBase;
use Modele\Playlist;
use Modele\ModeleDB\MusiqueDB;

final class PlaylistDB
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }
    public function getPlaylists(){
        $query = "SELECT * FROM PLAYLIST";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $playlistData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $playlist = [];
        foreach ($PlaylistsData as $PlaylistData)
        {
            $this->getPlaylist($PlaylistData['idPlaylist']);
        }
    }
    public function displayPlaylist(): String{
        $playlist = $this->getPlaylists();
        $html =  "<div class='playlist'>";
        foreach ($playlistes as $playlist)
        {
            $html .= $playlist->render();
        }
        $html .= "</div>";

        return $html;
    }
    public function getPlaylist(int $idPlaylist)
    {
        
        $query = "SELECT * FROM PLAYLIST WHERE idPlaylist = :idPlaylist";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idPlaylist', $idPlaylist);
        $stmt->execute();
        $playlistData = $stmt->fetch(PDO::FETCH_ASSOC);
        $playlist = new Playlist($playlistData['idPlaylist'], $playlistData['nomPlaylist'], $playlistData['idUser']);
        
        $musiques = $this->getMusiquesPlaylist((int)$idPlaylist);
        foreach ($musiques as $musique)
        {
            $playlist->addMusique($musique);
        }
        return $playlist;
    }

    public function getMusiquesPlaylist(int $idPlaylist)
    {
        $__MUSIQUE__ = new MusiqueDB();

        $query = "SELECT idMusique FROM CONTENIR WHERE idPlaylist = :idPlaylist";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idPlaylist', $idPlaylist);
        $stmt->execute();
        $musiquesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $musiques = [];
        foreach ($musiquesData as $musiqueData)
        {
            $musique = $__MUSIQUE__->getMusique($musiqueData['idMusique']);
            array_push($musiques, $musique);
        }
        return $musiques;
    }

    public function updatePlaylist(Playlist $playlist)
    {
        $query = "UPDATE PLAYLIST SET nomPlaylist = :nomPlaylist, idUser = :idUser WHERE idPlaylist = :idPlaylist";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomPlaylist', $playlist->getNomPlaylist());
        $stmt->bindParam(':idUser', $playlist->getIdUser());
        $stmt->bindParam(':idPlaylist', $playlist->getIdPlaylist());
        $stmt->execute();
    }

    public function addMusiquePlaylist(int $idPlaylist, int $idMusique)
    {
        $query = "INSERT INTO CONTENIR (idPlaylist, idMusique) VALUES (:idPlaylist, :idMusique)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idPlaylist', $idPlaylist);
        $stmt->bindParam(':idMusique', $idMusique);
        $stmt->execute();
    }

    public function removeMusiquePlaylist(int $idPlaylist, int $idMusique)
    {
        $query = "DELETE FROM CONTENIR WHERE idPlaylist = :idPlaylist AND idMusique = :idMusique";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idPlaylist', $idPlaylist);
        $stmt->bindParam(':idMusique', $idMusique);
        $stmt->execute();
    }

    public function ajouterPlaylist(string $nomPlaylist, int $idUser)
    {
        $query = "INSERT INTO PLAYLIST (nomPlaylist, idUser) VALUES (:nomPlaylist, :idUser)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nomPlaylist', $nomPlaylist);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        return true;
    }

    public function getPlaylistId(string $nomPlaylist)
{
    $query = "SELECT idPlaylist FROM PLAYLIST WHERE nomPlaylist = :nomPlaylist";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':nomPlaylist', $nomPlaylist);
    $stmt->execute();
    $playlistData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($playlistData !== false && isset($playlistData['idPlaylist'])) {
        return $playlistData['idPlaylist'];
    } else {
        throw new \Exception("Playlist not found with name: ". $nomPlaylist);
        return null;
    }
}


    public function initPlaylist(int $idPlaylist){
        $playlist = $this->getPlaylist($idPlaylist);
        $_SESSION['playlist'] = $playlist;
    }

}
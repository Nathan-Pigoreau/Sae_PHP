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
        
        $musiques = $this->getMusiquesPlaylist($idPlaylist);
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
}
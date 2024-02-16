document.addEventListener("DOMContentLoaded", function() {
    var selectGenre = document.getElementById('genres');
    var selectYear = document.getElementById('annee');

    selectGenre.addEventListener('change', function() {
        var selectedGenre = this.value;
        var selectedYear = selectYear.value;

        fetch('/Classes/Controller/controllerFiltrageAlbum.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'selectedGenre=' + selectedGenre + '&selectedYear=' + selectedYear,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            var albums = document.getElementById('albums');
            albums.innerHTML = "";
            albums.className = 'albums';
            albums.id = 'albums';
            data.forEach(album => {
                var albumDiv = document.createElement('div');
                albumDiv.className = 'album';

                var albumCover = document.createElement('img');
                albumCover.src = '/Static/images/' + album.image;
                albumCover.alt = album.nomAlbum;
                albumDiv.appendChild(albumCover);

                var albumTitle = document.createElement('h2');
                albumDiv.appendChild(albumTitle);

                var albumLien = document.createElement('a');
                albumLien.href = '/album-details?id=' + album.idAlbum;
                albumLien.textContent = album.nomAlbum;
                albumTitle.appendChild(albumLien);
        
                albums.appendChild(albumDiv); // Ajouter chaque divAlbum dans la div albums
                
            });
        })
        });
        selectYear.addEventListener('change', function() {
            var selectedYear = this.value;
            var selectedGenre = selectGenre.value;
    
            fetch('/Classes/Controller/controllerFiltrageAlbum.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'selectedGenre=' + selectedGenre + '&selectedYear=' + selectedYear,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var albums = document.getElementById('albums');
                albums.innerHTML = "";
                albums.className = 'albums';
                albums.id = 'albums';
                data.forEach(album => {
                    var albumDiv = document.createElement('div');
                    albumDiv.className = 'album';
    
                    var albumCover = document.createElement('img');
                    albumCover.src = '/Static/images/' + album.image;
                    albumCover.alt = album.nomAlbum;
                    albumDiv.appendChild(albumCover);
    
                    var albumTitle = document.createElement('h2');
                    albumDiv.appendChild(albumTitle);
    
                    var albumLien = document.createElement('a');
                    albumLien.href = '/album-details?id=' + album.idAlbum;
                    albumLien.textContent = album.nomAlbum;
                    albumTitle.appendChild(albumLien);
            
                    albums.appendChild(albumDiv); // Ajouter chaque divAlbum dans la div albums
                    
                });
            })
        });

    });

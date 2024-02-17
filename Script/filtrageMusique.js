document.addEventListener("DOMContentLoaded", function() {
    var selectGenre = document.getElementById('genres');
    var selectYear = document.getElementById('annee');

    selectGenre.addEventListener('change', function() {
        var selectedGenre = this.value;
        var selectedYear = selectYear.value;

        fetch('/Classes/Controller/controllerFiltrageMusique.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'selectedGenre=' + selectedGenre + '&selectedYear=' + selectedYear,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            var musiques = document.getElementById('musiques');
            musiques.innerHTML = "";
            musiques.className = 'musiques';
            musiques.id = 'musiques';
            data.forEach(musique => {
                var musiqueDiv = document.createElement('div');
                musiqueDiv.className = 'musique';

                var musiqueCover = document.createElement('img');
                musiqueCover.src = '/Static/images/' + musique.image;
                musiqueCover.alt = musique.nomMusique;
                musiqueDiv.appendChild(musiqueCover);

                var musiqueTitle = document.createElement('h2');
                musiqueDiv.appendChild(musiqueTitle);

                var musiqueLien = document.createElement('a');
                musiqueLien.href = '/musique-details?id=' + musique.idMusique;
                musiqueLien.textContent = musique.nomMusique;
                musiqueTitle.appendChild(musiqueLien);
        
                musiques.appendChild(musiqueDiv); 
                
            });
        })
        });
        selectYear.addEventListener('change', function() {
            var selectedYear = this.value;
            var selectedGenre = selectGenre.value;
    
            fetch('/Classes/Controller/controllerFiltrageMusique.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'selectedGenre=' + selectedGenre + '&selectedYear=' + selectedYear,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var musiques = document.getElementById('musiques');
                musiques.innerHTML = "";
                musiques.className = 'musiques';
                musiques.id = 'musiques';
                data.forEach(musique => {
                    var musiqueDiv = document.createElement('div');
                    musiqueDiv.className = 'musique';
    
                    var musiqueCover = document.createElement('img');
                    musiqueCover.src = '/Static/images/' + musique.image;
                    musiqueCover.alt = musique.nomMusique;
                    musiqueDiv.appendChild(musiqueCover);
    
                    var musiqueTitle = document.createElement('h2');
                    musiqueDiv.appendChild(musiqueTitle);
    
                    var musiqueLien = document.createElement('a');
                    musiqueLien.href = '/musique-details?id=' + musique.idMusique;
                    musiqueLien.textContent = musique.nomMusique;
                    musiqueTitle.appendChild(musiqueLien);
            
                    musiques.appendChild(musiqueDiv); // Ajouter chaque divmusique dans la div musiques
                    
                });
            })
        });

    });


    // Fonction pour effectuer une recherche dans la table des utilisateurs
    function searchUsers() {
      var searchValue = document.getElementById('searchInput').value;
      
      if(searchValue == ""){
        searchValue = "%"
      }
      // Envoyer une requête GET asynchrone au serveur
      fetch('modifies/search_users.php?search=' + searchValue)
        .then(function(response) {
          return response.json();
        })
        .then(function(data) {
          // Manipuler les données de la réponse
          displaySearchResults(data);
        })
        .catch(function(error) {
          console.log('Une erreur s\'est produite:', error);
        });
    }
    
    // Fonction pour afficher les résultats de recherche
    function displaySearchResults(users) {
      var tableBody = document.querySelector('#searchResults');
      
      // Vider le contenu du corps de la table
      tableBody.innerHTML = '';
      
      // Parcourir les utilisateurs et créer les lignes de la table
      for (var i = 0; i < users.length; i++) {
        var user = users[i]; 
        
        var row = document.createElement('tr');
        

        let divisions = Object.values(user)

        for(let i = 0; i < divisions.length / 2;i++){

          var Cell = document.createElement('td');
          Cell.textContent = divisions[i];
          row.appendChild(Cell);

        }
        

        
        tableBody.appendChild(row);
      }
    }
    
    document.getElementById('searchInput').addEventListener('input', searchUsers);

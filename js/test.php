<!DOCTYPE html>
<html>
<head>
  <title>Recherche d'utilisateurs avec affichage dans une table</title>
  <style>
    #searchInput {
      margin-bottom: 10px;
    }
    #searchResults {
      margin-top: 10px;
    }
    #searchResults table {
      width: 100%;
      border-collapse: collapse;
    }
    #searchResults th, #searchResults td {
      padding: 8px;
      border: 1px solid #ddd;
    }
  </style>
</head>
<body>
  <input type="text" id="searchInput" placeholder="Recherche..." />
  
  <div id="searchResults">
    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Âge</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <script>
    // Fonction pour effectuer une recherche dans la table des utilisateurs
    function searchUsers() {
      var searchValue = document.getElementById('searchInput').value;
      
      // Envoyer une requête GET asynchrone au serveur
      fetch('../modifies/search_users.php?search=' + searchValue)
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
      var tableBody = document.querySelector('#searchResults tbody');
      
      // Vider le contenu du corps de la table
      tableBody.innerHTML = '';
      
      // Parcourir les utilisateurs et créer les lignes de la table
      for (var i = 0; i < users.length; i++) {
        var user = users[i]; 
        
        var row = document.createElement('tr');
        
        var nameCell = document.createElement('td');
        nameCell.textContent = user.nom;
        
        var firstNameCell = document.createElement('td');
        firstNameCell.textContent = user.prenom;
        
        var ageCell = document.createElement('td');
        ageCell.textContent = user.age;
        
        row.appendChild(nameCell);
        row.appendChild(firstNameCell);
        row.appendChild(ageCell);
        
        tableBody.appendChild(row);
      }
    }
    
    document.getElementById('searchInput').addEventListener('input', searchUsers);
  </script>
</body>
</html>

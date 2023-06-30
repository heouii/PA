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

    var resultsContainer = document.getElementById('searchResults');
    
    resultsContainer.innerHTML = '';
    
    // Parcourir les utilisateurs et créer les éléments d'affichage
    for (var i = 0; i < users.length; i++) {
      var user = users[i]; 
      
      var listItem = document.createElement('li');
      listItem.textContent = user.nom +" " + user.prenom
      
      resultsContainer.appendChild(listItem);
    }
  }
  
  document.getElementById('searchInput').addEventListener('input', searchUsers);
  
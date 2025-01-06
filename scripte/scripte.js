let searchInput = document.getElementById("searchByName");
let selecteInput = document.getElementById("selectByCat");
let container = document.getElementById('container');
searchInput.addEventListener('input', _ => {
  let searchValue = searchInput.value;
  console.log(searchValue);
  let conn = new XMLHttpRequest;
  conn.open("GET", `../classes/searchByName.php?letHimCoock=${searchValue}`);
  conn.send();
  conn.onload = _ => {
    if (conn.status === 200) {
      let search = JSON.parse(conn.responseText);
      container.innerHTML = "";
      search.forEach(result => {
        container.innerHTML += `
          <div class="bg-white rounded-lg shadow-soft overflow-hidden transition-all hover:shadow-lg">
                        <img src="${result.vehicule_image}" alt="Ferrari SF90" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <span class="text-sm text-blue-600 font-medium">${result.nom}</span>
                            <h3 class="text-xl font-bold text-gray-900 mt-1">${result.modele} ${result.marque}</h3>
                            <p class="text-gray-600">1000 CV - Hybride</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-2xl font-bold text-gray-900">${result.prix} $<span class="text-sm text-gray-600">/jour</span></span>
                                <a href="../pages/reservation.php?vehiculeId=${result.vehicule_id}&clientId=<?php echo $_SESSION['user_id'] ?>" class="bg-gradient-primary text-white px-4 py-2 rounded-lg hover:bg-gradient-primary transition-all">Réserver</a>
                            </div>
                        </div>
                    </div>`;
      });
    }
  }
});

let categoryFilter = document.getElementById('categoryFilter');
let vehiclesContainer = document.getElementById('container');

categoryFilter.addEventListener('change', () => {
  let categoryId = categoryFilter.value;

  let conn = new XMLHttpRequest();

  conn.open('GET', `../classes/vehicle.php?Category_id=${Categorie_id}`);

  conn.send();

  conn.onload = function () {
    if (conn.status === 200) {
      let vehicles = JSON.parse(conn.responseText);

      vehiclesContainer.innerHTML = '';

      vehicles.forEach(vehicle => {
        vehiclesContainer.innerHTML += `
                        <div class="bg-white rounded-lg shadow-soft overflow-hidden transition-all hover:shadow-lg">
                        <img src="${result.vehicule_image}" alt="Ferrari SF90" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <span class="text-sm text-blue-600 font-medium">${result.nom}</span>
                            <h3 class="text-xl font-bold text-gray-900 mt-1">${result.modele} ${result.marque}</h3>
                            <p class="text-gray-600">1000 CV - Hybride</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-2xl font-bold text-gray-900">${result.prix} $<span class="text-sm text-gray-600">/jour</span></span>
                                <a href="../pages/reservation.php?vehiculeId=${result.vehicule_id}&clientId=<?php echo $_SESSION['user_id'] ?>" class="bg-gradient-primary text-white px-4 py-2 rounded-lg hover:bg-gradient-primary transition-all">Réserver</a>
                            </div>
                        </div>
                    </div>`;
      });
    }
  };
});
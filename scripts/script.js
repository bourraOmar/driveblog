let isModalOpen = false;

document.getElementById('user-menu-button').addEventListener('click', function () {
    let dropdown = document.getElementById('user-dropdown');
    
    if (isModalOpen) {
        dropdown.classList.add('hidden');
        isModalOpen = false;
    } else {
        dropdown.classList.remove('hidden'); 
        isModalOpen = true;
    }
});

    let categoryFilter = document.getElementById('categoryFilter');
    let vehiclesContainer = document.querySelector('.grid');

    categoryFilter.addEventListener('change', () => {
        let categoryId = categoryFilter.value;
        
        let conn = new XMLHttpRequest();

        conn.open('GET', `../classes/filter_vehicles.php?category_id=${categoryId}`, true);

        conn.send();

        conn.onload = function () {
            if (conn.status === 200) {
                let vehicles = JSON.parse(conn.responseText);

                vehiclesContainer.innerHTML = '';

                vehicles.forEach(vehicle => {
                    vehiclesContainer.innerHTML += `
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden card-animation">
                            <img src="${vehicle.vehicule_image}" alt="${vehicle.marque}" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="font-bold text-xl">${vehicle.marque}</h3>
                                        <p class="text-gray-600">${vehicle.modele}</p>
                                    </div>
                                    <span class="bg-primary px-3 py-1 rounded-full text-sm">$${vehicle.prix}/day</span>
                                </div>
                                <div class="flex gap-6">
                                    <div class="mb-6">
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                            ${vehicle.status}
                                        </span>
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                            ${vehicle.nom}
                                        </span>
                                    </div>
                                </div>
                                <a href="../pages/reservation_page.php?vehiculeId=${vehicle.vehicule_id}">
                                    <button class="btn-primary w-full py-2 rounded-lg">Reserve Now</button>
                                </a>
                            </div>
                        </div>`;
                });
            }
        };
    });
    let searchInput = document.getElementById('searchInput');
    
        searchInput.addEventListener('input', function() {
        let searchValue = searchInput.value;
        
        let conn = new XMLHttpRequest();
        conn.open("GET", `../classes/search_vehicules.php?carModel=${searchValue}`, true);
        conn.send();
    
        conn.onload = function() {
        if (conn.status === 200) {
        let vehicles = JSON.parse(conn.responseText);

        let vehiclesContainer = document.querySelector('.grid');
        let errorcontain = document.getElementById('errorcontain');

        if(vehicles.length === 0){
            vehiclesContainer.innerHTML = "";
            errorcontain.innerHTML = `<p class='mb-96 text-center text-2xl'>There is no Vehicules with this model name!</p>`;
            return;
        }
        
        vehiclesContainer.innerHTML = '';
        errorcontain.innerHTML = '';
        vehicles.forEach(vehicle => {
            console.log(vehicle);
            vehiclesContainer.innerHTML += `
                <div class="bg-white rounded-lg shadow-lg overflow-hidden card-animation">
                    <img src="${vehicle.vehicule_image}" alt="${vehicle.marque}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="font-bold text-xl">${vehicle.marque}</h3>
                                        <p class="text-gray-600">${vehicle.modele}</p>
                                    </div>
                                        <span class="bg-primary px-3 py-1 rounded-full text-sm">$${vehicle.prix}/day</span>
                                    </div>
                            <div class="flex gap-6">
                                    <div class="mb-6">
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                            ${vehicle.status}
                                        </span>
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                            ${vehicle.nom}
                                            </span>
                                            </div>
                                        </div>
                                    <a href="../pages/reservation_page.php?vehiculeId=${vehicle.vehicule_id}">
                                    <button class="btn-primary w-full py-2 rounded-lg">Reserve Now</button>
                            </a>
                        </div>
                    </div>`;
            });
        }
    }
});
    
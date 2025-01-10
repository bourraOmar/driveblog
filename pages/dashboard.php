<?php
require_once '../classes/Categorie.php';
require_once '../classes/client.php';
require_once '../classes/vehicule_class.php';
require_once '../classes/reservation.php';

$client = new client();
$vehicule = new Vehicule();
$categorie = new Categorie();
$reservation = new Reservation();


if (isset($_POST['Category_submit'])) {
    $categorie_name = $_POST['cat_name'];
    $categorie_desc = $_POST['cat_desc'];
    $categorie->ajouterCategorie($categorie_name, $categorie_desc);
}

if (isset($_POST['Vehicle_submit'])) {
    $modele = $_POST['modele'];
    $marque = $_POST['marque'];
    $Category = $_POST['Category'];
    $price = $_POST['price'];
    $Vehicle_Image = $_FILES['Vehicle_Image'];

    $vehicule->AjouterVehicule($modele, $marque, $price, $Vehicle_Image, $Category);
}

if (isset($_POST['deletevehicule_id'])) {
    $vehicule_id = $_POST['deletevehicule_id'];
    if ($vehicule->removeVehicule($vehicule_id)) {
        header('Location: ../pages/dashboard.php');
        exit();
    }
}

if (isset($_POST['approve_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    if ($reservation->updateReservationStatus($reservation_id, 'accepte')) {
        header('Location: ../pages/dashboard.php');
        exit();
    }
}

if (isset($_POST['refuse_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    if ($reservation->updateReservationStatus($reservation_id, 'refuse')) {
        header('Location: ../pages/dashboard.php');
        exit();
    }
}


if ($_SESSION['role_id'] == 1) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Drive & Loc - Admin Dashboard</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
        <style>
            .bg-primary {
                background-color: #2563eb;
            }
            .bg-gradient-primary{
                background-color: #2563eb;
            }

            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .modal.active {
                display: flex;
            }

            .stat-card {
                transition: transform 0.2s;
            }

            .stat-card:hover {
                transform: translateY(-5px);
            }
        </style>
    </head>

    <body class="bg-gray-50">
        <nav class="bg-gradient-primary shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-white">D&L</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-white"><?php echo $_SESSION['nom'] ?></span>
                        <a href="../profils/log out.php" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="pt-24 bg-gradient-primary text-white mb-4">
            <div class="mx-auto p-4 py-20">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div class="text-center md:text-left">
                        <h4 class="text-2xl font-bold">Admin Space</h4>
                        <h4 class="text-9xl font-bold">Dashboard</h4>
                    </div>
                </div>
            </div>
        </div>


        <!-- Action Buttons -->
        <div class="mb-6 flex space-x-4">
            <button class="bg-primary px-4 py-2 rounded-lg hover:bg-yellow-400 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <a href="../pages/dashboard.php">dashboard vehicles</a>
            </button>
            <button class="bg-primary px-4 py-2 rounded-lg hover:bg-yellow-400 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <a href="../pages/blog_dashboard.php">dashboard artices</a>
            </button>
        </div>

        <!-- Vehicles Table -->
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="flex justify-between p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold">Vehicles Management</h2>
                <button onclick="openModal('addVehicleModal')" class="bg-primary px-4 py-2 rounded-lg hover:bg-yellow-400 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Vehicle
            </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Model</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Marque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price/Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $rows = $vehicule->showAllVehicule();
                        foreach ($rows as $row) {
                            $_SESSION['vehicule_id'] = $row['vehicule_id'];
                        ?>
                            <tr>
                                <td class="px-6 py-4"><?php echo $row['vehicule_id'] ?></td>
                                <td class="px-6 py-4"><?php echo $row['modele'] ?></td>
                                <td class="px-6 py-4"><?php echo $row['marque'] ?></td>
                                <td class="px-6 py-4"><?php echo $row['nom'] ?></td>
                                <td class="px-6 py-4"><?php echo $row['prix'] ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm"><?php echo $row['status'] ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="" method="post">
                                        <input class="editvehicule_id_input" type="hidden" name="editvehicule_id" value="<?php echo $row['vehicule_id'] ?>">
                                        <button class="editbtn text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                                    </form>

                                    <form action="" method="post">
                                        <input type="hidden" name="deletevehicule_id" value="<?php echo $row['vehicule_id'] ?>">
                                        <button class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Showing 1 to 10 of 50 entries</span>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border rounded hover:bg-gray-50">Previous</button>
                        <button class="px-3 py-1 bg-primary rounded">1</button>
                        <button class="px-3 py-1 border rounded hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 border rounded hover:bg-gray-50">3</button>
                        <button class="px-3 py-1 border rounded hover:bg-gray-50">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="flex justify-between p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold">Clients Management</h2>
                <button onclick="openModal('addCategoryModal')" class="bg-primary px-4 py-2 rounded-lg hover:bg-yellow-400 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Category
            </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $rows = $client->ShowAllClients();
                        foreach ($rows as $row) {
                            if ($row['role_id'] == 2) {
                        ?>
                                <tr>
                                    <td class="px-6 py-4"><?php echo $row['user_id'] ?></td>
                                    <td class="px-6 py-4"><?php echo $row['nom'] . " " . $row['prenom'] ?></td>
                                    <td class="px-6 py-4"><?php echo $row['email'] ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Category Table -->
        <div class="bg-white rounded-lg shadow-md mt-6">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold">Categories Management</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $arrays = $categorie->showCategorie();
                        foreach ($arrays as $array) {
                        ?>
                            <tr>
                                <td class="px-6 py-4"><?php echo $array['Categorie_id'] ?></td>
                                <td class="px-6 py-4"><?php echo $array['nom'] ?></td>
                                <td class="px-6 py-4"><?php echo $array['description'] ?></td>
                                <td class="px-6 py-4 flex gap-6">
                                    <button class="text-green-600 hover:text-green-800 mr-2">Edit</button>
                                    <button class="text-red-600 hover:text-red-800">Delete</button>
                                </td>
                            <?php } ?>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Reservations Table -->
        <div class="bg-white rounded-lg shadow-md mt-6">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold">Reservations Management</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehicle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $reservations = $reservation->getAllReservations();
                        foreach ($reservations as $res) {
                            $status_color = '';
                            switch ($res['status']) {
                                case 'waiting':
                                    $status_color = 'bg-yellow-100 text-yellow-800';
                                    break;
                                case 'accepte':
                                    $status_color = 'bg-green-100 text-green-800';
                                    break;
                                case 'refuse':
                                    $status_color = 'bg-red-100 text-red-800';
                                    break;
                            }
                        ?>
                            <tr>
                                <td class="px-6 py-4"><?php echo $res['reservation_id'] ?></td>
                                <td class="px-6 py-4"><?php echo $res['client_name'] ?></td>
                                <td class="px-6 py-4"><?php echo $res['vehicle_name'] ?></td>
                                <td class="px-6 py-4"><?php echo $res['date_debut'] ?></td>
                                <td class="px-6 py-4"><?php echo $res['date_fin'] ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-sm <?php echo $status_color ?>">
                                        <?php echo $res['status'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($res['status'] == 'waiting') { ?>
                                        <form method="POST" class="inline-block">
                                            <input type="hidden" name="reservation_id" value="<?php echo $res['reservation_id'] ?>">
                                            <button type="submit" name="approve_reservation" class="text-green-600 hover:text-green-800 mr-2">
                                                Approve
                                            </button>
                                            <button type="submit" name="refuse_reservation" class="text-red-600 hover:text-red-800">
                                                Refuse
                                            </button>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        </div>

        <!-- Add Vehicle Modal -->
        <div id="addVehicleModal" class="modal z-50">
            <div class="bg-white rounded-lg w-1/2 mx-auto my-auto p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Add New Vehicle</h3>
                    <button onclick="closeModal('addVehicleModal')" class="text-gray-500 hover:text-gray-700">×</button>
                </div>
                <form class="space-y-4" method="post" enctype="multipart/form-data">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Vehicle modele</label>
                            <input type="text" class="w-full border rounded-lg p-2" name="modele">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Vehicle marque</label>
                            <input type="text" class="w-full border rounded-lg p-2" name="marque">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Category</label>
                            <select class="w-full border rounded-lg p-2" name="Category">
                                <?php
                                $arr = $categorie->showCategorie();
                                foreach ($arr as $row) {
                                    echo "<option value='" . $row['Categorie_id'] . "'>" . $row['nom'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Price per Day</label>
                            <input type="number" class="w-full border rounded-lg p-2" name="price">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Vehicle Image</label>
                        <input type="file" class="w-full border rounded-lg p-2" name="Vehicle_Image">
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeModal('addVehicleModal')" class="px-4 py-2 border rounded-lg">Cancel</button>
                        <button type="submit" name="Vehicle_submit" class="px-4 py-2 bg-primary rounded-lg">Add Vehicle</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Vehicle Modal -->
        <div id="editVehicleModal" class="modal z-50">
            <div class="bg-white rounded-lg w-1/2 mx-auto my-auto p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Add New Vehicle</h3>
                    <button onclick="closeModal('editVehicleModal')" class="text-gray-500 hover:text-gray-700">×</button>
                </div>
                <form class="space-y-4" method="post" enctype="multipart/form-data" action="../classes/vehicule_class.php">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Vehicle modele</label>
                            <input type="text" class="w-full border rounded-lg p-2" id="editmodele" name="editmodele">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Vehicle marque</label>
                            <input type="text" class="w-full border rounded-lg p-2" id="editmarque" name="editmarque">
                        </div>
                        <input type="hidden" id="editVehicleId" name="vehiculeId">
                        <div>
                            <label class="block text-sm font-medium mb-1">Category</label>
                            <select class="w-full border rounded-lg p-2" id="editCategory" name="editCategory">
                                <?php
                                $arr = $categorie->showCategorie();
                                foreach ($arr as $row) {
                                    echo "<option value='" . $row['Categorie_id'] . "'>" . $row['nom'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Price per Day</label>
                            <input type="number" class="w-full border rounded-lg p-2" id="editprice" name="editprice">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Vehicle Image</label>
                            <input type="file" class="w-full border rounded-lg p-2" id="editVehicle_Image" name="editVehicle_Image">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Current Vehicle Image</label>
                            <img id="editVehicleImage" src="" alt="Vehicle Image" style="max-width: 200px; margin-bottom: 10px; border: 1px solid #ccc;">
                        </div>
                        <?php
                        $rows = $vehicule->showAllVehicule();
                        foreach ($rows as $row) {
                        ?>

                        <?php } ?>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeModal('editVehicleModal')" class="px-4 py-2 border rounded-lg">Cancel</button>
                        <button type="submit" name="editVehicle_submit" class="px-4 py-2 bg-primary rounded-lg">Edit Vehicule</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Category Modal -->
        <div id="addCategoryModal" class="modal z-50">
            <div class="bg-white rounded-lg w-1/3 mx-auto my-auto p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Add New Category</h3>
                    <button onclick="closeModal('addCategoryModal')" class="text-gray-500 hover:text-gray-700">×</button>
                </div>
                <form class="space-y-4" method="POST">
                    <div>
                        <label class="block text-sm font-medium mb-1">Category Name</label>
                        <input type="text" name="cat_name" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Description</label>
                        <textarea class="w-full border rounded-lg p-2" name="cat_desc" rows="3"></textarea>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeModal('addCategoryModal')" class="px-4 py-2 border rounded-lg">Cancel</button>
                        <button type="submit" name="Category_submit" class="px-4 py-2 bg-primary rounded-lg">Add Category</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openModal(modalId) {
                document.getElementById(modalId).classList.add('active');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.remove('active');
            }

            document.querySelectorAll('.editbtn').forEach(editbtn => {
                editbtn.addEventListener('click', function(e) {

                    e.preventDefault();

                    let vehiculeid = this.parentElement.querySelector('.editvehicule_id_input').value;

                    openModal('editVehicleModal');

                    let conn = new XMLHttpRequest();
                    conn.open('GET', '../classes/getAllVehicules.php?vehicule_id=' + vehiculeid, true);

                    conn.send();

                    conn.onload = function() {
                        if (conn.status === 200) {
                            let vehicles = JSON.parse(conn.responseText);

                            vehicles.forEach(vehicle => {
                                document.getElementById('editmarque').value = vehicle.marque;
                                document.getElementById('editmodele').value = vehicle.modele;
                                document.getElementById('editCategory').value = vehicle.Categorie_id;
                                document.getElementById('editprice').value = vehicle.prix;
                                document.getElementById('editVehicleImage').src = vehicle.vehicule_image;
                                document.getElementById('editVehicleId').value = vehicle.vehicule_id;
                            })
                        }
                    }
                })
            })

            document.querySelector('form')[1].addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                let xhr = new XMLHttpRequest();
                xhr.open('POST', '../classes/vehicule_class.php', true);

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert('Vehicle updated successfully!');
                        closeModal('editVehicleModal');
                        location.reload();
                    }
                };

                xhr.send(formData);
            });
        </script>
    </body>

    </html>
<?php
} else if ($_SESSION['role_id'] == 2) {
    header('location: ../index.php');
    exit();
} else {
    header('location: ../autentification/signup.php');
    exit();
}
?>
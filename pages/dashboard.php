<?php
require_once '../classes/categorie.php';
require_once '../classes/vehicle.php';
require_once '../classes/reserve.php';

$vehicule = new Vehicule();
$categorie = new Categorie();
$reservation = new reservation();

// Handle form submissions
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
    $Vehicle_Image = $_POST['Vehicle_Image'];
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

session_start();
if ($_SESSION['role_id'] == 1) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Drive & Loc - Admin Dashboard</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            .bg-gradient-primary {
                background: linear-gradient(135deg, rgb(37, 99, 235), rgb(37, 143, 235));
            }

            .hover\:bg-gradient-primary:hover {
                background: linear-gradient(135deg, rgb(37, 143, 235), rgb(37, 99, 235));
            }

            .shadow-soft {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .transition-all {
                transition: all 0.3s ease;
            }

            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                justify-content: center;
                align-items: center;
            }

            .modal.active {
                display: flex;
            }
        </style>
    </head>

    <body class="bg-gray-50">
        <!-- Top Navigation -->
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
        <div class="pt-24 bg-gradient-primary text-white">
            <div class="mx-auto p-4 py-20">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div class="text-center md:text-left">
                        <h4 class="text-2xl font-bold">Admin Space</h4>
                        <h4 class="text-9xl font-bold">Dashboard</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 py-6">
            <!-- Category Table -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Categories Management</h2>
                <button onclick="openModal('addCategoryModal')" class="bg-gradient-primary text-white px-4 py-2 rounded-lg hover:bg-gradient-primary transition-all flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Category
                </button>
            </div>
            <div class="bg-white rounded-lg shadow-soft overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-primary">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php
                            $arrays = $categorie->showCategorie();
                            foreach ($arrays as $array) {
                            ?>
                                <tr class="hover:bg-gray-50 transition-all">
                                    <td class="px-6 py-4"><?php echo $array['Categorie_id'] ?></td>
                                    <td class="px-6 py-4"><?php echo $array['nom'] ?></td>
                                    <td class="px-6 py-4"><?php echo $array['description'] ?></td>
                                    <td class="px-6 py-4 flex gap-4">
                                        <button class="text-blue-600 hover:text-blue-800">Edit</button>
                                        <button class="text-red-600 hover:text-red-800">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Vehicles Table -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Vehicles Management</h2>
                <button onclick="openModal('addVehicleModal')" class="bg-gradient-primary text-white px-4 py-2 rounded-lg hover:bg-gradient-primary transition-all flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Vehicle
                </button>
            </div>
            <div class="bg-white rounded-lg shadow-soft overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-primary">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Model</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Marque</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Price/Day</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php
                            $rows = $vehicule->showAllVehicule();
                            foreach ($rows as $row) {
                            ?>
                                <tr class="hover:bg-gray-50 transition-all">
                                    <td class="px-6 py-4"><?php echo $row['vehicule_id'] ?></td>
                                    <td class="px-6 py-4"><?php echo $row['modele'] ?></td>
                                    <td class="px-6 py-4"><?php echo $row['marque'] ?></td>
                                    <td class="px-6 py-4"><?php echo $row['nom'] ?></td>
                                    <td class="px-6 py-4"><?php echo $row['prix'] ?>$</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm"><?php echo $row['status'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 flex gap-4">
                                        <button class="text-blue-600 hover:text-blue-800">Edit</button>
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
            </div>

            <!-- Reservations Table -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Reservations Management</h2>
            </div>
            <div class="bg-white rounded-lg shadow-soft overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-primary">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Vehicle</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Start Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">End Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
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
                                <tr class="hover:bg-gray-50 transition-all">
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
        <div id="addVehicleModal" class="modal">
            <div class="bg-white rounded-lg w-1/2 mx-auto my-auto p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Add New Vehicle</h3>
                    <button onclick="closeModal('addVehicleModal')" class="text-gray-500 hover:text-gray-700">×</button>
                </div>
                <form class="space-y-4" method="post" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Vehicle Model</label>
                            <input type="text" class="w-full border rounded-lg p-2" name="modele">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Vehicle Marque</label>
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
                        <div>
                            <label class="block text-sm font-medium mb-1">Vehicle Image</label>
                            <input type="text" class="w-full border rounded-lg p-2" name="Vehicle_Image">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeModal('addVehicleModal')" class="px-4 py-2 border rounded-lg">Cancel</button>
                        <button type="submit" name="Vehicle_submit" class="px-4 py-2 bg-gradient-primary text-white rounded-lg hover:bg-gradient-primary transition-all">Add Vehicle</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Category Modal -->
        <div id="addCategoryModal" class="modal">
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
                        <button type="submit" name="Category_submit" class="px-4 py-2 bg-gradient-primary text-white rounded-lg hover:bg-gradient-primary transition-all">Add Category</button>
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
        </script>
    </body>

    </html>
<?php
} else if ($_SESSION['role_id'] == 2) {
    header('location:../index.php');
    exit();
} else {
    header('location:../autentification/signUp.php');
    exit();
}
?>
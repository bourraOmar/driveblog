<?php
require_once '../classes/Categorie.php';
require_once '../classes/client.php';
require_once '../classes/vehicule_class.php';
require_once '../classes/reservation.php';
require_once '../blog_class/Theme_class.php';
require_once '../blog_class/artcile_class.php';

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

if (isset($_POST['article_id']) && isset($_POST['approve_article'])) {
    $article_id = $_POST['article_id'];
    Article::ApprouverArticle($article_id);
    header('Location: ../pages/blog_dashboard.php');
    exit();
}

if (isset($_POST['article_id']) && isset($_POST['refuse_article'])) {
    $article_id = $_POST['article_id'];
    Article::RefuseArticle($article_id);
    header('Location: ../pages/blog_dashboard.php');
    exit();
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
            :root {
                --primary: #2563eb;
                /* Blue */
                --secondary: #1e40af;
                /* Darker Blue */
                --accent: #FFD700;
                /* Gold */
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
            }

            .btn-primary {
                background-color: var(--primary);
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                background-color: var(--secondary);
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

    <body class="bg-gray-100">
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
            <button class="bg-blue-500 px-4 py-2 rounded-lg hover:bg-yellow-400 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <a href="../pages/dashboard.php">dashboard vehicles</a>
            </button>
            <button  class="bg-blue-500 px-4 py-2 rounded-lg hover:bg-yellow-400 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <a href="../pages/blog_dashboard.php">dashboard artices</a>
            </button>
        </div>


        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 py-6">

            <!-- Show themes on dashboard table -->
            <div class="bg-white rounded-lg shadow-md mt-6">
                <div class="flex justify-between p-6 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-bold">Themes Management</h2>
                    <button onclick="openModal('addThemeModal')" class="btn-primary px-4 py-2 rounded-lg text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Theme
                </button>
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
                            <?php
                            $arrays = Theme::getAllThemes();
                            foreach ($arrays as $array) {
                            ?>
                                <tr>
                                    <td class="px-6 py-4"><?php echo $array['theme_id'] ?></td>
                                    <td class="px-6 py-4"><?php echo $array['name'] ?></td>
                                    <td class="px-6 py-4"><?php echo $array['description'] ?></td>
                                    <td class="px-6 py-4 flex gap-6">
                                        <button class="text-green-600 hover:text-green-800 mr-2">Edit</button>
                                        <button class="text-red-600 hover:text-red-800">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add theme Modal -->
            <div id="addThemeModal" class="modal z-50">
                <div class="bg-white rounded-lg w-1/3 mx-auto my-auto p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">Add New Category</h3>
                        <button onclick="closeModal('addThemeModal')" class="text-gray-500 hover:text-gray-700">×</button>
                    </div>
                    <form class="space-y-4" method="POST" action="../blog_class/Theme_class.php">
                        <div>
                            <label class="block text-sm font-medium mb-1">Theme Name</label>
                            <input type="text" name="theme_name" class="w-full border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Description</label>
                            <textarea class="w-full border rounded-lg p-2" name="theme_desc" rows="3"></textarea>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="closeModal('addThemeModal')" class="px-4 py-2 border rounded-lg">Cancel</button>
                            <button type="submit" name="Theme_submit" class="px-4 py-2 bg-primary rounded-lg text-white">Add Theme</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Article Management Section -->
            <div class="bg-white rounded-lg shadow-md mt-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold">Article Management</h2>
                    <p class="text-gray-600 mt-1">Review and manage submitted articles</p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php
                        $rows = Article::getallArticles();
                        foreach ($rows as $row) {
                            $tags = Article::gettagsForArticle($row['article_id']);
                        ?>
                            <div class="bg-gray-50 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-lg"><?php echo $row['title'] ?></h3>
                                        <p class="text-gray-600 text-sm mt-1"><?php echo $row['nom'] . " " . $row['prenom'] ?></p>
                                        <div class="flex items-center mt-2">
                                            <span class="text-xs text-gray-500"><?php echo $row['date_creation'] ?></span>
                                            <span class="mx-2 text-gray-300">•</span>
                                            <?php if ($row['Approved'] == 'approved') { ?>
                                                <span class="text-xs text-green-600"><?php echo $row['Approved'] ?></span>
                                            <?php } elseif ($row['Approved'] == 'waiting') { ?>
                                                <span class="text-xs text-yellow-600"><?php echo $row['Approved'] ?></span>
                                            <?php } elseif ($row['Approved'] == 'refused') { ?>
                                                <span class="text-xs text-red-600"><?php echo $row['Approved'] ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-gray-600 mt-3 text-sm line-clamp-3 mb-5">
                                    <?php echo $row['content'] ?>
                                </p>

                                <?php foreach ($tags as $tag) { ?>
                                    <span class='text-sm bg-gray-100 px-2 py-1 rounded'><?php echo $tag['name'] ?></span>
                                <?php } ?>

                                <div class="flex justify-end space-x-3 mt-4">
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="article_id" value="<?php echo $row['article_id'] ?>">
                                        <button type="submit" name="refuse_article" class="px-3 py-1 text-sm text-red-600 border border-red-600 rounded hover:bg-red-50">
                                            Refuse
                                        </button>
                                    </form>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="article_id" value="<?php echo $row['article_id'] ?>">
                                        <button type="submit" name="approve_article" class="px-3 py-1 text-sm text-white bg-green-600 rounded hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
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
                            });
                        }
                    };
                });
            });

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
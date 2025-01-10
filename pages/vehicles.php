<?php
session_start();
require_once '../classes/vehicule_class.php';
require_once '../classes/Categorie.php';

$vehiculs = new Vehicule();
$categorie = new Categorie();

$VehiculesParPage = 6;

$thisPage = isset($_GET['page']) ? $_GET['page'] : 1;
$startIn = ($thisPage - 1) * $VehiculesParPage;

$result = $vehiculs->fetchdataforcurrentpage($startIn, $VehiculesParPage);

if ($_SESSION['role_id'] == 2) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Drive & Loc - Our Vehicles</title>
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

            .bg-primary {
                background-color: var(--primary);
            }

            .bg-secondary {
                background-color: var(--secondary);
            }

            .bg-accent {
                background-color: var(--accent);
            }

            .text-primary {
                color: var(--primary);
            }

            .text-secondary {
                color: var(--secondary);
            }

            .text-accent {
                color: var(--accent);
            }

            .btn-primary {
                background-color: var(--primary);
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
            }

            .card-animation {
                transition: transform 0.3s ease;
            }

            .card-animation:hover {
                transform: translateY(-5px);
            }
        </style>
    </head>

    <body class="bg-gray-50">
        <!-- Navigation Bar -->
        <nav class="bg-primary shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="../index.php" class="text-2xl font-bold w-8 mr-24">
                            <span class="text-2xl font-bold text-white">D&L</span>
                        </a>
                    </div>

                    <div class="flex gap-8">
                        <div class="hidden w-full md:block md:w-auto">
                            <ul class="flex space-x-8">
                                <li><a href="../index.php" class="text-white hover:text-accent">Home</a></li>
                                <li><a href="../pages/vehicles.php" class="text-white border-b-2 border-accent">Cars</a></li>
                                <li><a href="../blog/blog_index.php" class="text-white hover:text-accent">Blog</a></li>
                                <li><a href="../blog/myarticles.php" class="text-white hover:text-accent">My Articles</a></li>
                            </ul>
                        </div>
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                                <button type="button" class="flex text-sm rounded-full md:me-0" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                                    <span class="sr-only">Open user menu</span>
                                    <img width="40px" src="../imgs/profilephoto.png" alt="user photo">
                                </button>
                                <!-- Dropdown menu -->
                                <div class="z-50 hidden absolute top-10 right-40 z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow" id="user-dropdown">
                                    <div class="px-4 py-3">
                                        <span class="block text-sm text-gray-900"><?php echo $_SESSION['nom'] . " " . $_SESSION['prenom'] ?></span>
                                        <span class="block text-sm text-gray-500 truncate"><?php echo $_SESSION['email'] ?></span>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="../pages/reservation_hestorie.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Reservations</a>
                                        </li>
                                        <li>
                                            <a href="../classes/user.php?signout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                                        </li>
                                    </ul>
                                </div>
                                <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-user" aria-expanded="false">
                                    <span class="sr-only">Open main menu</span>
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                                    </svg>
                                </button>
                            </div>
                        <?php } else { ?>
                            <div class="flex items-center space-x-6">
                                <a href="../autentification/login.php" class="text-white hover:text-accent">Login</a>
                                <a href="../autentification/signup.php" class="bg-accent px-6 py-2 rounded-lg hover:bg-yellow-500 text-white">Register</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-primary">Available Vehicles</h1>
                <div class="flex gap-4">
                    <input id="searchInput" type="text" class="border rounded-lg p-2 outline-none" placeholder="Search For Cars..">
                    <select id="categoryFilter" class="border rounded-lg p-2">
                        <option value="all">All Categories</option>
                        <?php
                        $arr = $categorie->showCategorie();
                        foreach ($arr as $row) {
                            echo "<option value='" . $row['Categorie_id'] . "'>" . $row['nom'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p id="errorcontain"></p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php if (count($result) > 0) { ?>
                    <?php foreach ($result as $row) { ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden card-animation">
                            <img src="<?php echo $row['vehicule_image'] ?>" alt="Vehicle Image" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="font-bold text-xl text-primary"><?php echo $row['marque'] ?></h3>
                                        <p class="text-gray-600"><?php echo $row['modele'] ?></p>
                                    </div>
                                    <span class="bg-accent px-3 py-1 rounded-full text-sm">$<?php echo $row['prix'] ?>/day</span>
                                </div>
                                <div class="flex gap-6">
                                    <div class="mb-6">
                                        <?php if ($row['status'] == 'active') { ?>
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                                <?php echo $row['status'] ?>
                                            </span>
                                        <?php } else if ($row['status'] == 'Reserved') { ?>
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                                <?php echo $row['status'] ?>
                                            </span>
                                        <?php } ?>
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                            <?php echo $row['nom'] ?>
                                        </span>
                                    </div>
                                </div>
                                <a href="../pages/reservation_page.php?vehiculeId=<?php echo $row['vehicule_id'] ?>">
                                    <button class="btn-primary w-full py-2 rounded-lg text-white">Reserve Now</button>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <?php
            $totalRecordsRow = $vehiculs->countPagesForPagination();
            $totalPages = ceil($totalRecordsRow / $VehiculesParPage);

            echo "<div class='flex justify-center space-x-2 mt-8'>";
            if ($thisPage > 1) {
                echo "<a href='?page=" . ($thisPage - 1) . "'><button class='px-4 py-2 rounded-lg border hover:bg-gray-100'>Previous</button></a>";
            }

            for ($page = 1; $page <= $totalPages; $page++) {
                if ($page == $thisPage) {
                    echo "<button class='px-4 py-2 rounded-lg border bg-primary text-white'>$page</button>";
                } else {
                    echo "<a href='?page=$page'><button class='px-4 py-2 rounded-lg border hover:bg-gray-100'>$page</button></a>";
                }
            }

            if ($thisPage < $totalPages) {
                echo "<a href='?page=" . ($thisPage + 1) . "'><button class='px-4 py-2 rounded-lg border hover:bg-gray-100'>Next</button></a>";
            }
            echo "</div>";
            ?>
        </main>

        <!-- Footer -->
        <footer class="bg-secondary text-white py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; 2024 Drive & Loc. All rights reserved.</p>
            </div>
        </footer>
        <script src="../scripts/script.js"></script>
    </body>

    </html>
<?php
} else {
    header('location: ../autentification/signup.php');
    exit();
}
?>
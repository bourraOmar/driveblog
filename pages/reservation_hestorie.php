<?php
session_start();

require_once('../classes/reservation.php');

if ($_SESSION['role_id'] == 2) {
    $reservation = new reservation();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Reservations - Drive & Loc</title>
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
                transition: transform 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
            }

            .btn-cancel {
                background-color: #FF4444;
                color: white;
                transition: transform 0.3s ease;
            }

            .btn-cancel:hover {
                transform: translateY(-2px);
                background-color: #FF0000;
            }
        </style>
    </head>

    <body>
        <!-- Navigation -->
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
                            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium rounded-lg md:flex-row md:space-x-8 md:mt-0">
                                <li>
                                    <a href="../index.php" class="block py-2 pl-3 pr-4 text-white hover:text-accent md:p-0">Home</a>
                                </li>
                                <li>
                                    <a href="../pages/vehicles.php" class="block py-2 pl-3 pr-4 text-white hover:text-accent md:p-0">Cars</a>
                                </li>
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
        <main class="py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-3xl font-bold mb-8 text-primary">My Reservations</h1>

                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-secondary">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Vehicle</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">End Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Total Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                $rows = $reservation->showClientReservations();
                                foreach ($rows as $row) {
                                    $reservationPrice = $reservation->reservationPriceCalule($row['date_debut'], $row['date_fin'], $row['vehicule_id']);
                                    $status_accepte = $row['status'] === 'accepte' ? 'text-green-600' : 'text-gray-500';
                                    $status_refuse = $row['status'] === 'refuse' ? 'text-red-600' : 'text-gray-500';
                                ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo $row['marque'] . ' ' . $row['modele']; ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <?php echo date('M d, Y', strtotime($row['date_debut'])); ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <?php echo date('M d, Y', strtotime($row['date_fin'])); ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <?php echo $reservationPrice; ?> $
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $row['status'] === 'accepte' ? $status_accepte : $status_refuse; ?>">
                                                <?php echo $row['status']; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($row['status'] == 'waiting') { ?>
                                                <form action="../classes/client.php" method="POST">
                                                    <input type="hidden" name="reservation_id" value="<?php echo $row['reservation_id']; ?>">
                                                    <input type="hidden" name="action" value="cancel">
                                                    <button type="submit" class="btn-cancel px-4 py-2 rounded-lg text-sm">
                                                        Cancel
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
        </main>

        <!-- Footer -->
        <footer class="bg-secondary text-white py-8 mt-80">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; 2024 Drive & Loc. All rights reserved.</p>
            </div>
        </footer>

        <script>
            let isModalOpen = false;

            document.getElementById('user-menu-button').addEventListener('click', function() {
                let dropdown = document.getElementById('user-dropdown');

                if (isModalOpen) {
                    dropdown.classList.add('hidden');
                    isModalOpen = false;
                } else {
                    dropdown.classList.remove('hidden');
                    isModalOpen = true;
                }
            });
        </script>
    </body>

    </html>
<?php
} else {
    header('location: ../Drive-Loc/autentification/signup.php');
    exit();
}
?>



<a href="../pages/reservation_hestorie.php"></a>
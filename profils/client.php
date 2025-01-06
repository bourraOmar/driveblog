<?php
session_start();

// Redirect if user is not authorized
if ($_SESSION['role_id'] != 2) {
    header('location: ../index.php');
    exit();
}

require_once('../classes/reserve.php');
$reservation = new reservation();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Reservation System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen p-8">
        <!-- Header with Logout -->
        <div class="flex justify-between items-center mb-8 bg-gradient-to-r from-blue-800 to-blue-600 text-white p-4 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold">My Profile</h1>
            <div class="flex gap-4">
                <a href="../index.php" class="px-4 py-2 hover:bg-blue-700 rounded-lg transition duration-300">Home</a>
                <form action="log out.php" method="post">
                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center transition duration-300" name="LogoutBTN">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Column - Profile Card -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition duration-300 hover:shadow-xl">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-32"></div>
                    <div class="relative px-4 pb-6">
                        <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
                            <img src="../img/profile-major.svg" alt="Profile Picture" class="w-32 h-32 rounded-full border-4 border-white bg-white shadow-lg">
                        </div>
                        <div class="pt-16 text-center">
                            <h2 class="text-2xl font-bold text-gray-800"><?php echo htmlspecialchars($_SESSION["nom"] . " " . $_SESSION["prenom"]); ?></h2>
                            <p class="text-blue-600 font-semibold">User</p>
                            <p class="text-gray-500 mt-2"><?php echo htmlspecialchars($_SESSION["email"]); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-lg mt-8 p-6 transition duration-300 hover:shadow-xl">
                    <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <i class="fas fa-phone text-blue-600 w-6"></i>
                            <span class="ml-3">+1 (555) 123-4567</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-blue-600 w-6"></i>
                            <span class="ml-3"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-600 w-6"></i>
                            <span class="ml-3">New York, USA</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Reservations -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6 transition duration-300 hover:shadow-xl">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800">My Reservations</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                $rows = $reservation->showClientReservations();
                                foreach ($rows as $row) {
                                    $statusClass = $row['status'] === 'accepte' ? 'text-green-600' : ($row['status'] === 'refuse' ? 'text-red-600' : 'text-gray-500');
                                ?>
                                    <tr class="hover:bg-gray-50 transition duration-300">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($row['marque'] . ' ' . $row['modele']); ?>
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
                                                <?php echo number_format($row['prix'], 2); ?> $
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusClass; ?>">
                                                <?php echo htmlspecialchars($row['status']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($row['status'] == 'waiting') { ?>
                                                <form action="../classes/user.php" method="POST">
                                                    <input type="hidden" name="reservation_id" value="<?php echo $row['reservation_id']; ?>">
                                                    <input type="hidden" name="action" value="cancel">
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition duration-300">
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
        </div>
    </div>
</body>

</html>
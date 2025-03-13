<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CoffeeCenter Ordering System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="templates/styleTemplate.css">
    <!-- <link rel="stylesheet" href="templates/stylee.css"> -->

</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark coffee-navbar">
        <div class="container">
            <!-- Enhanced Branding with Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://cdn-icons-png.flaticon.com/512/2942/2942873.png" alt="Coffee Logo"
                    class="coffee-logo me-2" style="width: 40px; height: 40px; transition: transform 0.3s ease;">
                <span class="brand-text">Coffee Center</span>
            </a>
            <!-- Toggler for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Navigation Links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link " href="Home.php" data-tooltip="Go to Home"><i
                                class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-tooltip="View Products"><i
                                class="fas fa-coffee me-1"></i>Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="All_Users.php" data-tooltip="Manage Users"><i
                                class="fas fa-users me-1"></i>Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-tooltip="Manual Order Entry"><i
                                class="fas fa-pen me-1"></i>Manual Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Orders/adminOrders.php" data-tooltip="View Checks"><i
                                class="fas fa-receipt me-1"></i>Checks</a>
                    </li>
                </ul>
                <!-- Right Side: Search and User Dropdown -->
                <div class="d-flex align-items-center">
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="resource/man.png" class="rounded-circle me-2 user-avatar" alt="User"
                                style="width: 35px; height: 35px;">
                            <span class="username">Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="#">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
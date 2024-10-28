<?php
session_start();
require_once './AuthController.php';

$authController = new AuthController();
$products = $authController->getProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style type="text/css">
        #sideMenu {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding: 20px;
            padding-top: 40px;
        }

        .mainContentContainer {
            margin-left: 250px;
            padding-top: 56px;
        }

        .fixedNavbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            z-index: 1000;
        }

        .gridProducts {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }

        .cardProduct {
            width: 100%;
            max-width: 300px;
            height: auto;
        }

        .imgProduct {
            width: 100%;
            height: 225px;
            object-fit: cover;
            margin: auto;
        }

        .cardBodyProduct {
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .buttonGroup {
            margin-top: auto;
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            #sideMenu {
                width: 100%;
                height: auto;
                position: relative;
            }

            .mainContentContainer {
                margin-left: 0;
                padding-top: 60px;
            }
        }

        @media (max-width: 768px) {
            #sideMenu {
                display: none;
            }

            .mainContentContainer {
                padding-top: 80px;
            }

            .gridProducts {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div id="sideMenu">
        <h4 class="text-center">Menu</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Customers</a>
            </li>
        </ul>
    </div>

    <div class="mainContentContainer">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixedNavbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Catalog</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Options
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container contentSection">
            <h1 class="mt-4 text-center">Available Products</h1>
            <div class="gridProducts">
                <?php foreach ($products as $product): ?>
                    <div class="card cardProduct">
                        <img src="<?php echo htmlspecialchars($product['cover']) ?>" class="card-img-top imgProduct"
                            alt="<?php echo htmlspecialchars($product['name']) ?>"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($product['name']); ?>';">
                        <div class="card-body cardBodyProduct">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']) ?></h5>
                            <?php if (!empty($product['presentations'])): ?>
                                <p><strong>Price:</strong> $<?= number_format($product['presentations'][0]['price'][0]['amount'], 2) ?></p>
                            <?php else: ?>
                                <p>No prices available for this product.</p>
                            <?php endif; ?>
                            <div class="buttonGroup">
                                <a href="./details.php?slug=<?php echo htmlspecialchars($product['slug']); ?>" class="btn btn-primary">Details</a>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Product details go here.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

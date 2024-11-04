<?php
session_start();
require_once './AuthController.php';

$authController = new AuthController();
$productSlug = isset($_GET['slug']) ? $_GET['slug'] : null;

if ($productSlug === null) {
    echo "Product not found.";
    exit;
}

$productData = $authController->getProductSlug($productSlug);

if ($productData === null) {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        #sideMenu {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #36454f;
            color: #eee;
            padding: 20px 10px;
        }

        .mainContent {
            margin-left: 240px;
            padding-top: 60px;
        }

        .fixedNavbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .card{
            width: 99%;
        }
        @media (max-width: 992px) {
            #sideMenu {
                width: 100%;
                position: relative;
            }

            .mainContent {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            #sideMenu {
                display: none;
            }

            .mainContent {
                padding-top: 80px;
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

    <div class="mainContent">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixedNavbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Options
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><hr class="dropdown-divider"></li>
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

        <div class="mainContent">
            <div class="card">
                <div class="row">
                    <div class="col-md-4">
                        <div id="carouselExampleIndicators" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?= htmlspecialchars($productData['cover']) ?>" alt="<?= htmlspecialchars($productData['name']) ?>" class="d-block w-100"
                                        onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?= urlencode($productData['name']) ?>';">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= htmlspecialchars($productData['cover']) ?>" alt="Slide 1" class="d-block w-100"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?= urlencode($productData['name']) ?>';">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= htmlspecialchars($productData['cover']) ?>" alt="Slide 2" class="d-block w-100"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?= urlencode($productData['name']) ?>';">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-header">
                            <h1><?= htmlspecialchars($productData['name']) ?></h1>
                        </div>
                        <div class="card-body">
                            <p><strong>Description:</strong> <?= htmlspecialchars($productData['description']) ?></p>
                            <p><strong>Brand:</strong> <?= htmlspecialchars($productData['brand']['name']) ?></p>
                            <div class="buttonContainer">
                                <?php
                                $buttonColors = ['btn-primary', 'btn-secondary', 'btn-success', 'btn-danger', 'btn-warning', 'btn-info', 'btn-dark'];
                                ?>
                                <p><strong>Categories:</strong></p>
                                <?php if (!empty($productData['brand']['name'])): ?>
                                    <button class="btn <?= $buttonColors[array_rand($buttonColors)] ?> mb-2">
                                        <?= htmlspecialchars($productData['brand']['name']) ?>
                                    </button>
                                <?php endif; ?>
                                <?php if (!empty($productData['tags'])): ?>
                                    <?php foreach ($productData['tags'] as $tag): ?>
                                        <button class="btn <?= $buttonColors[array_rand($buttonColors)] ?> mb-2">
                                            <?= htmlspecialchars($tag['name']) ?>
                                        </button>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <button class="btn btn-secondary mb-2">Tags: Not available</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

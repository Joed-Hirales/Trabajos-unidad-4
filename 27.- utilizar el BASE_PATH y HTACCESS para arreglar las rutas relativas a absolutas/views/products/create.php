<?php

include "../../app/config.php";
include_once "../../app/ProductsController.php";
include_once "../../app/BrandsController.php";
$productsController = new ProductsController();
$brandsController = new BrandsController();
$productos = $productsController->get();
$brands = $brandsController->get();
?>
<!doctype html>
<html lang="en">
<!-- [Head] start -->

<head>
  <?php include "../layouts/head.php" ?>
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>

  <!-- [ Pre-loader ] End -->
  <?php include "../layouts/sidebar.php" ?>
  <?php include "../layouts/navbar.php" ?>

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/products.php">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                <li class="breadcrumb-item" aria-current="page">Add New Product</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Add New Product</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <form action="products.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Product Name</label>
          <input type="text" name="product_name" class="form-control" placeholder="Enter Product Name" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Brand</label>
          <select class="form-select" name="brand_id" required>
            <?php foreach ($brands as $brand): ?>
              <option value="<?php echo $brand->id; ?>"><?php echo htmlspecialchars($brand->name); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-0">
          <label class="form-label">Product Description</label>
          <textarea class="form-control" name="product_description" placeholder="Enter Product Description" required></textarea>
        </div>
        <div class="card">
          <div class="card-header">
            <h5>Product image</h5>
          </div>
          <div class="card-body">
            <div class="mb-0">
              <p><span class="text-danger">*</span> Recommended resolution is 640*640 with file size</p>
              <label class="btn btn-outline-secondary" for="flupld"><i class="ti ti-upload me-2"></i> Click to Upload</label>
              <input type="file" id="flupld" name="product_image" class="d-none" required />
            </div>
          </div>
        </div>
        <div class="card-body text-end btn-page">
          <button type="submit" class="btn btn-primary mb-0">Save product</button>
          <button type="reset" class="btn btn-outline-secondary mb-0">Reset</button>
        </div>
      </form>

      <!-- [ Main Content ] end -->
    </div>
  </div>

  <?php include "../layouts/footer.php" ?>

  <?php include "../layouts/scripts.php" ?>

  <?php include "../layouts/modals.php" ?>
</body>
<!-- [Body] end -->undefined

</html>
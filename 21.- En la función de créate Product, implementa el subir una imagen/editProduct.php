<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['productName'];
    $slug = $_POST['productSlug'];
    $description = $_POST['productDescription'];
    $features = $_POST['productFeactures'];
    $category_id = $_POST['productCategory'];

    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['productImage']['tmp_name'];
        $imageName = $_FILES['productImage']['name'];
        $cfile = new CURLFile($imageTmpPath, $_FILES['productImage']['type'], $imageName);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'name' => $name,'slug' => $slug,'description' => $description,'features' => $features,
                'category_id' => $category_id,  
                'image' => $cfile
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 308|7HbtmLVx1Bk4E2JLY8g50uP7aHHuRGZfTsbgzM5J',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        echo $response;
    } else {
        echo "<script>alert('Error.');</script>";
    }
}
?>
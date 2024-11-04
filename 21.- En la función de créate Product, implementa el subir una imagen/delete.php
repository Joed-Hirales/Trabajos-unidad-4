<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $id = $_POST['productIdDelete']; 
    echo 'here'.$id;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/' . $id, 
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE', 
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer 308|7HbtmLVx1Bk4E2JLY8g50uP7aHHuRGZfTsbgzM5J',
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    header('Location: home.php'); 
    exit;
}
?>

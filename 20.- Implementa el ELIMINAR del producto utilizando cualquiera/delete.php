<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $id = $_POST['productIdDelete']; // Cambiar a productIdDelete
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
            'Authorization: Bearer 113|i8M5h8KCsgrpaAmUikSw2c3Qm1xFaBsmlpM1b2Lx',
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    exit;
}
?>

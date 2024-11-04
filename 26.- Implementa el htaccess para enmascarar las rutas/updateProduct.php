<?php

if (isset($_POST['name'], $_POST['slug'], $_POST['description'], $_POST['features'])) {
  $name = $_POST['name'];
  $slug = $_POST['slug'];
  $description = $_POST['description'];
  $features = $_POST['features'];
  $image = $_FILES['cover'] ["tmp_name"];

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
      'name' => $name,
      'slug' => $slug,
      'description' => $description,
      'features' => $features,
      'cover' => new CurlFile($image)
    ),
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer 308|7HbtmLVx1Bk4E2JLY8g50uP7aHHuRGZfTsbgzM5J'
    ),
  ));

  $response = curl_exec($curl);
  $error = curl_error($curl);
  curl_close($curl);

  if ($error) {
    echo "cURL Error: " . $error;
} else {
    header("Location: home.php");
    exit();

} } else {
  echo "Error: Faltan datos en el formulario.";
}
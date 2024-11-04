<?php
session_start();

if (!isset($_SESSION['token'])) {
	$_SESSION['token'] = 123;
}

if (isset($_POST['action'])) {

	switch ($_POST['action']) {

		case 'crear_producto':

			$name_var =  $_POST['name'];
			$slug_var = $_POST['slug'];
			$description_var = $_POST['description'];
			$features_var = $_POST['features'];

			$productsController = new ProductsController();

			$productsController->create($name_var, $slug_var, $description_var, $features_var, $product_id, $image_var);

			break;

		case 'update_producto':
			$name_var = $_POST['name'];
			$slug_var = $_POST['slug'];
			$description_var = $_POST['description'];
			$features_var = $_POST['features'];
			$product_id = $_POST['product_id'];
			$image_var = $_FILES['image']; // Captura el archivo de imagen

			$productsController = new ProductsController();
			$productsController->update($name_var, $slug_var, $description_var, $features_var, $product_id, $image_var); // Añade el archivo de imagen aquí

			break;

		case 'delete_producto':

			$product_id = $_POST['product_id'];

			$productsController = new ProductsController();

			$productsController->delete($product_id);

			break;
	}
}

/**
 * 
 */
class ProductsController
{

	public function get()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $_SESSION['user_data']->token
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);

		if (isset($response->code) && $response->code > 0) {

			return $response->data;
		} else {
			return [];
		}
	}

	public function getBySlug($slug)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/slug/' . $slug,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $_SESSION['user_data']->token
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);

		if (isset($response->code) && $response->code > 0) {

			return $response->data;
		} else {
			return [];
		}
	}

	public function create($name_var, $slug_var, $description_var, $features_var, $image_var)
{
    $curl = curl_init();

    // Prepara los datos para la carga, incluyendo la imagen
    $postData = array(
        'name' => $name_var,
        'slug' => $slug_var,
        'description' => $description_var,
        'features' => $features_var,
    );

    if (!empty($image_var['tmp_name'])) {
        $postData['image'] = new CURLFile($image_var['tmp_name'], $image_var['type'], $image_var['name']);
    }

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $_SESSION['user_data']->token
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);

    if (isset($response->code) && $response->code > 0) {
        header("Location: ../home.php?status=ok");
    } else {
        header("Location: ../home.php?status=error");
    }
}

	public function update($name_var, $slug_var, $description_var, $features_var, $product_id)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PUT',
			CURLOPT_POSTFIELDS => 'name=' . $name_var . '&slug=' . $slug_var . '&description=' . $description_var . '&features=' . $features_var . '&id=' . $product_id,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded',
				'Authorization: Bearer ' . $_SESSION['user_data']->token
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);

		if (isset($response->code) && $response->code > 0) {

			header("Location: ../home.php?status=ok");
		} else {

			header("Location: ../home.php?status=error");
		}
	}

	public function delete($product_id)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/' . $product_id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'DELETE',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $_SESSION['user_data']->token
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);

		if (isset($response->code) && $response->code > 0) {

			header("Location: ../home.php?status=ok");
		} else {

			header("Location: ../home.php?status=error");
		}
	}
}

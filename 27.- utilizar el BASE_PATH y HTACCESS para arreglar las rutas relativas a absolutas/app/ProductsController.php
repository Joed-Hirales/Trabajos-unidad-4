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

			$productsController->create($name_var, $slug_var, $description_var, $features_var);

			break;

		case 'update_producto':

			$name_var =  $_POST['name'];
			$slug_var = $_POST['slug'];
			$description_var = $_POST['description'];
			$features_var = $_POST['features'];
			$product_id = $_POST['product_id'];

			$productsController = new ProductsController();

			$productsController->update($name_var, $slug_var, $description_var, $features_var, $product_id);

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

	public function create($name_var, $slug_var, $description_var, $features_var)
	{
		// Verificar si se ha subido una imagen
		if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
			// Definir el directorio donde se guardará la imagen
			$upload_dir = 'uploads/products/';
			$upload_file = $upload_dir . basename($_FILES['image']['name']);

			// Mover la imagen al directorio
			if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
				// La imagen se ha movido exitosamente, guardamos la ruta
				$image_path = $upload_file;
			} else {
				// Si la imagen no se ha movido, podemos mostrar un error
				header("Location: ../home.php?status=error_image");
				return;
			}
		} else {
			// Si no se subió una imagen, usar una imagen por defecto
			$image_path = 'uploads/products/default.jpg';
		}

		// Realizar la solicitud al API con los datos del producto, incluyendo la imagen
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
				'name' => $name_var,
				'slug' => $slug_var,
				'description' => $description_var,
				'features' => $features_var,
				'image' => $image_path // Incluir la imagen en los datos
			),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $_SESSION['user_data']->token
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);

		if (isset($response->code) && $response->code > 0) {
			// Redirigir al index con un mensaje de éxito
			header("Location: ../index.php?status=ok");
		} else {
			// En caso de error, redirigir al home con un error
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

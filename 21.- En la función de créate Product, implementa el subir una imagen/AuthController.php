<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'login':
            $email = $_POST['email'];
            $password = $_POST['password'];

            $authController = new AuthController();
            $authController->login($email, $password);
            break;
    }
}

class AuthController
{
    public function login($email, $password)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => $email, 'password' => $password),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response, true);

        if (isset($response['message']) && $response['message'] === 'Registro obtenido correctamente' && isset($response['data']['token'])) {
            $_SESSION['token'] = $response['data']['token'];
            header('Location: ./home.php');
            exit();
        } else {
            header('Location: ./index.html');
            exit();
        }
    }

    public function getProducts()
{
    if (!isset($_SESSION['token'])) {
        header('Location: ./index.html');
        exit();
    }

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
            'Authorization: Bearer ' . $_SESSION['token']
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $allProducts = json_decode($response, true)['data'] ?? [];

    return $allProducts;
}

    public function getProductSlug($productSlug)
    {
        if (!isset($_SESSION['token'])) {
            header('Location: ../index.html');
            exit();
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/slug/' . urlencode($productSlug),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $_SESSION['token']
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            echo 'Error en la solicitud: ' . curl_error($curl);
            exit;
        }

        curl_close($curl);

        $productData = json_decode($response, true);

        return $productData['data'] ?? null;
    }
}

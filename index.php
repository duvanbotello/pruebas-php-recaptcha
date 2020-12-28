<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';
require dirname(__FILE__) . '/config.php';

$recaptcha = new Recaptcha(2);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require dirname(__FILE__) . '/classes/Validations.php';
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $cell = isset($_POST['cell']) ? $_POST['cell'] : null;
    $recaptchaRequest = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : null;
    $ipRemote = $_SERVER['REMOTE_ADDR'];
    $date = $hoy = getdate();
    $errors = array();


    if (!Validations::validRequired($name)) {
        $errors[] = 'Por favor llena el campo de nombre.';
    }
    if (!Validations::validRequired($last_name)) {
        $errors[] = 'Por favor llena el campo de apellido.';
    }
    if (!Validations::validRequired($email)) {
        $errors[] = 'Por favor llena el campo de email.';
    } else {
        if (!Validations::validateEmail($email)) {
            $errors[] = 'Por favor ingrese un correo valido.';
        }
    }
    if (!Validations::validRequired($cell)) {
        $errors[] = 'Por favor llena el campo de telefono.';
    } else {
        if (!Validations::validateInteger($cell)) {
            $errors[] = 'Por favor un numero de telefono valido.';
        }
    }

    if (!$recaptchaRequest) {
        $errors[] = 'Por favor verifique Captcha.';
    } else {
        $validateCaptcha = $recaptcha->requestAPI($recaptchaRequest, $GLOBALS["secretKeyCaptchaServer"]);
        $validateCaptcha = json_decode($validateCaptcha, true);
        if ($validateCaptcha) {
            if ($validateCaptcha['success'] != true) {
                $errors[] = 'El Captcha es incorrecto.';
            }
            if ($GLOBALS["versionCaptcha"] == 3) {
                if ($validateCaptcha['score'] < $GLOBALS["scoreMin"]) {
                    $errors[] = 'El score minimo es de '.$GLOBALS["scoreMin"].' tu score es de '.$validateCaptcha['score'];
                }
            }
        } else {
            $errors[] = 'Ocurrio un error al consultar Captcha.';
        }
    }

    if (!$errors) {
        $data = array("name" => $name,
            "last_name" => $last_name,
            "email" => $email,
            "cell" => $cell,
            "ip_client" => $ipRemote,
            "date" => date('Y-m-d'),
        );
        $db = MysqliDb::getInstance();
        $id = $db->insert('usuarios', $data);
        if ($id) {
            $smarty->assign(array(
                'recaptcha' => $recaptcha,
                'errors' => '',
                'success_v' => true,
                'secret_client' => $GLOBALS["secretKeyCaptchaClient"],
                'visible' => $GLOBALS["visibleCaptcha"],
                'vCaptcha' => $GLOBALS["versionCaptcha"],
            ));
            $smarty->display('formulario.tpl');
        } else {
            $errors[] = 'Error al registrar envio.';
        }
        $db->disconnect();
        exit;
    } else {
        $smarty->assign(array(
            'recaptcha' => $recaptcha,
            'errors' => $errors,
            'success_v' => '',
            'secret_client' => $GLOBALS["secretKeyCaptchaClient"],
            'visible' => $GLOBALS["visibleCaptcha"],
            'vCaptcha' => $GLOBALS["versionCaptcha"],
        ));
        $smarty->display('formulario.tpl');
    }

} else {
    $smarty->assign(array(
        'recaptcha' => $recaptcha,
        'errors' => '',
        'success_v' => '',
        'secret_client' => $GLOBALS["secretKeyCaptchaClient"],
        'visible' => $GLOBALS["visibleCaptcha"],
        'vCaptcha' => $GLOBALS["versionCaptcha"],
    ));
    $smarty->display('formulario.tpl');
}

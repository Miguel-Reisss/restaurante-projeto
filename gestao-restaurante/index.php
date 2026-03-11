<?php

declare(strict_types=1);

session_start();

// Definição de caminhos básicos
define('BASE_PATH', __DIR__);
define('VIEW_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
define('CONTROLLER_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR);
define('CONFIG_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR);

require_once CONFIG_PATH . 'conexao.php';

/**
 * Roteador simples baseado em parâmetros da URL.
 *
 * Exemplos:
 * - index.php          -> tela de login
 * - index.php?page=login
 * - index.php?controller=produto&action=index
 */

$controller = isset($_GET['controller']) ? strtolower($_GET['controller']) : null;
$action     = isset($_GET['action']) ? strtolower($_GET['action']) : null;
$page       = isset($_GET['page']) ? strtolower($_GET['page']) : 'login';

/**
 * Se foi informado um controller, tenta despachar para ele.
 */
if ($controller !== null) {
    $controllerFile = CONTROLLER_PATH . ucfirst($controller) . 'Controller.php';

    if (!file_exists($controllerFile)) {
        http_response_code(404);
        echo 'Controller não encontrado.';
        exit;
    }

    require_once $controllerFile;

    $controllerClass = ucfirst($controller) . 'Controller';

    if (!class_exists($controllerClass)) {
        http_response_code(500);
        echo 'Classe de controller inválida.';
        exit;
    }

    $controllerInstance = new $controllerClass();
    $action             = $action ?: 'index';

    if (!method_exists($controllerInstance, $action)) {
        http_response_code(404);
        echo 'Ação não encontrada.';
        exit;
    }

    // Executa a ação do controller.
    $controllerInstance->{$action}();
    exit;
}

/**
 * Sem controller: roteamento básico para views "simples".
 */
switch ($page) {
    case 'login':
    default:
        $viewFile = VIEW_PATH . 'login.php';
        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo 'View de login não encontrada.';
            exit;
        }
        require $viewFile;
        break;
}


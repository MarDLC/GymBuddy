<?php

class CFrontController
{


    public function run($requestUri)
    {
        // Parse the request URI
        $requestUri = trim($requestUri, '/');
        $uriParts = explode('/', $requestUri);

        array_shift($uriParts);

        // Extract controller and method names
        $controllerName = !empty($uriParts[0]) ? ucfirst($uriParts[0]) : 'User';
        $methodName = !empty($uriParts[1]) ? $uriParts[1] : 'Home';

        // Load the controller class
        $controllerClass = 'C' . $controllerName;
        $controllerFile = __DIR__ . "/{$controllerClass}.php";

        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            // Check if the method exists in the controller
            if (method_exists($controllerClass, $methodName)) {
                // Call the method
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // If it's a POST request, pass the $_POST array as parameters
                    call_user_func([$controllerClass, $methodName], $_POST);
                } else {
                    // Otherwise, pass the remaining parts of the URI as parameters
                    $params = array_slice($uriParts, 2);
                    call_user_func_array([$controllerClass, $methodName], $params);
                }
            } else {
                // Method not found, handle appropriately (e.g., show 404 page)
                header('Location: /GymBuddy/libs/Smarty/html/Page404');
            }
        } else {
            // Controller not found, handle appropriately (e.g., show 404 page)
            header('Location: /GymBuddy/libs/Smarty/html/Page404');
        }
    }
}
<?php
require_once __DIR__ . '/../bootstrap.php';

$uri = ltrim(strtok($_SERVER["REQUEST_URI"],'?'), '/');
$data = file_get_contents('php://input');

switch($uri) {
    case 'event':
        error_log($data);
        break;
    default:
        $ivr = new \NexmoDemo\Ivr(new \NexmoDemo\Orders($config['database']), $config, $_GET);
        $method = strtolower($uri) . 'Action';

        $ivr->$method(json_decode($data, true));

        header('Content-Type: application/json');
        echo json_encode($ivr->getStack());
}
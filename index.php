<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Weather\Controller\StartPage;

$request = Request::createFromGlobals();

$loader = new FilesystemLoader('View', __DIR__ . '/src/Weather');
$twig = new Environment($loader, ['cache' => __DIR__ . '/cache', 'debug' => true]);

$controller = new StartPage();
$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

switch ($uriSegments[2]) {
    case 'week':
        $renderInfo = $controller->getWeekWeather($uriSegments[3]);
        break;
    case 'today':
        $renderInfo = $controller->getTodayWeather($uriSegments[3]);
        break;
    default: $renderInfo = $controller->getTodayWeather(null);
    break;
}

$renderInfo['context']['resources_dir'] = '/'. $uriSegments[1] .'/src/Weather/Resources';
$renderInfo['context']['path'] =  '/' . $uriSegments[1];


$content = $twig->render($renderInfo['template'], $renderInfo['context']);

$response = new Response(
    $content,
    Response::HTTP_OK,
    array('content-type' => 'text/html')
);
$response->send();

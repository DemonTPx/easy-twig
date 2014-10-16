<?php

use Demontpx\EasyTwig\Controller;
use Demontpx\EasyTwig\TwigFactory;
use Symfony\Component\HttpFoundation\Request;

$root = __DIR__ . '/../';
require_once $root . 'config.php';
require_once $root . 'vendor/autoload.php';

$twigFactory = new TwigFactory();
$twig = $twigFactory->create($templatesFolder, $cache ? $cacheFolder : null);

$controller = new Controller($twig);

$request = Request::createFromGlobals();
$response = $controller->page($request);
$response->send();

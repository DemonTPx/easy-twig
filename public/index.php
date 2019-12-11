<?php declare(strict_types=1);

use Demontpx\EasyTwig\Asset\AssetExtension;
use Demontpx\EasyTwig\Asset\JsonManifestAssetVersion;
use Demontpx\EasyTwig\Asset\NoAssetVersion;
use Demontpx\EasyTwig\Cache\HashContentHttpCache;
use Demontpx\EasyTwig\Cache\NoHttpCache;
use Demontpx\EasyTwig\Controller;
use Demontpx\EasyTwig\TwigFactory;
use Symfony\Component\HttpFoundation\Request;

$root = dirname(__DIR__);
require $root . '/config/bootstrap.php';

$twigFactory = new TwigFactory();
$twig = $twigFactory->create($root . '/templates', $root . '/cache', (bool) $_SERVER['APP_DEBUG']);

$version = new NoAssetVersion();
if ($_SERVER['ASSET_MANIFEST']) {
    $version = new JsonManifestAssetVersion($root . '/' . $_SERVER['ASSET_MANIFEST']);
}
$twig->addExtension(new AssetExtension($version));

$httpCache = new NoHttpCache();
if ($_SERVER['HTTP_CACHE'] === 'hash') {
    $httpCache = new HashContentHttpCache();
}

$controller = new Controller($twig);

$request = Request::createFromGlobals();
$response = $httpCache->apply($controller->page($request), $request);
$response->send();

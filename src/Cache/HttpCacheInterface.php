<?php declare(strict_types=1);

namespace Demontpx\EasyTwig\Cache;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @copyright 2019 Bert Hekman
 */
interface HttpCacheInterface
{
    public function apply(Response $response, Request $request): Response;
}

<?php declare(strict_types=1);

namespace Demontpx\EasyTwig\Cache;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @copyright 2019 Bert Hekman
 */
class HashContentHttpCache implements HttpCacheInterface
{
    public function apply(Response $response, Request $request): Response
    {
        $response->setEtag(md5($response->getContent()), true);
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }
}

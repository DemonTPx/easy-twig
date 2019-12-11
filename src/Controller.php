<?php declare(strict_types=1);

namespace Demontpx\EasyTwig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;

/**
 * @copyright 2014 Bert Hekman
 */
class Controller
{
    /** @var Environment */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function page(Request $request): Response
    {
        $path = $request->getPathInfo();
        if (substr($path, -1) === '/') {
            $path .= 'index';
        }
        $path = ltrim($path, '/');

        $context = [
            'request' => $request,
        ];

        try {
            return new Response($this->twig->render('page/' . $path . '.html.twig', $context));
        } catch (LoaderError $e) {
            return new Response($this->twig->render('error/404.html.twig', $context), Response::HTTP_NOT_FOUND);
        }
    }
}

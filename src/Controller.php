<?php

namespace Demontpx\EasyTwig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Twig_Error_Loader;

/**
 * Class Controller
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class Controller
{
    /** @var Twig_Environment */
    private $twig;

    /**
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function page(Request $request)
    {
        $path = $request->getPathInfo();
        if (substr($path, -1) == '/') {
            $path .= 'index';
        }

        try {
            return new Response($this->twig->render('page/' . $path . '.html.twig'));
        } catch (Twig_Error_Loader $e) {
            return new Response($this->twig->render('error/404.html.twig'), Response::HTTP_NOT_FOUND);
        }
    }
}

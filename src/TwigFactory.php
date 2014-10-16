<?php

namespace Demontpx\EasyTwig;

use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

/**
 * Class TwigFactory
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class TwigFactory
{
    /**
     * @param string      $templatePath
     * @param bool|string $cachePath
     * @param bool        $debug
     *
     * @return Twig_Environment
     */
    public function create($templatePath, $cachePath = false, $debug = false)
    {
        $twigLoader = new Twig_Loader_Filesystem(array($templatePath));

        $options = array(
            'debug' => $debug,
            'cache' => $cachePath,
        );

        $twig = new Twig_Environment($twigLoader, $options);

        if ($debug) {
            $twig->addExtension(new Twig_Extension_Debug());
        }

        return $twig;
    }
}

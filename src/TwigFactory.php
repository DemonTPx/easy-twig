<?php

namespace Demontpx\EasyTwig;

use Twig_Environment;
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
     * @param string $templatePath
     * @param string $cachePath
     *
     * @return Twig_Environment
     */
    public function create($templatePath, $cachePath = null)
    {
        $twigLoader = new Twig_Loader_Filesystem(array($templatePath));

        $options = array();
        if ($cachePath) {
            $options['cache'] = $cachePath;
        }

        return new Twig_Environment($twigLoader, $options);
    }
}

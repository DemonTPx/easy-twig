<?php declare(strict_types=1);

namespace Demontpx\EasyTwig;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * @copyright 2014 Bert Hekman
 */
class TwigFactory
{
    public function create(string $templatePath, ?string $cachePath = null, bool $debug = false): Environment
    {
        $twigLoader = new FilesystemLoader([$templatePath]);

        $options = [
            'debug' => $debug,
            'cache' => $cachePath ?? false,
        ];

        $twig = new Environment($twigLoader, $options);

        if ($debug) {
            $twig->addExtension(new DebugExtension());
        }

        return $twig;
    }
}

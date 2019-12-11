<?php declare(strict_types=1);

namespace Demontpx\EasyTwig\Asset;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @copyright 2019 PB Web Media B.V.
 */
class AssetExtension extends AbstractExtension
{
    /** @var AssetVersionInterface */
    private $version;

    public function __construct(AssetVersionInterface $version)
    {
        $this->version = $version;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('asset', [$this->version, 'apply']),
        ];
    }
}

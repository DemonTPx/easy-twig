<?php declare(strict_types=1);

namespace Demontpx\EasyTwig\Asset;

/**
 * @copyright 2019 PB Web Media B.V.
 */
class NoAssetVersion implements AssetVersionInterface
{
    public function apply(string $path): string
    {
        return $path;
    }
}

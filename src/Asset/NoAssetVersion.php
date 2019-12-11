<?php declare(strict_types=1);

namespace Demontpx\EasyTwig\Asset;

/**
 * @copyright 2019 Bert Hekman
 */
class NoAssetVersion implements AssetVersionInterface
{
    public function apply(string $path): string
    {
        return $path;
    }
}

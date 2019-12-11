<?php declare(strict_types=1);

namespace Demontpx\EasyTwig\Asset;

/**
 * @copyright 2019 Bert Hekman
 */
interface AssetVersionInterface
{
    public function apply(string $path): string;
}

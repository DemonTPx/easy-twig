<?php declare(strict_types=1);

namespace Demontpx\EasyTwig\Asset;

/**
 * @copyright 2019 PB Web Media B.V.
 */
class JsonManifestAssetVersion implements AssetVersionInterface
{
    /** @var string */
    private $path;
    /** @var array|null */
    private $data = null;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function apply(string $path): string
    {
        $this->loadManifest();

        return $this->data[$path] ?? $path;
    }

    private function loadManifest(): void
    {
        if ( ! is_null($this->data)) {
            return;
        }

        if ( ! file_exists($this->path)) {
            throw new \RuntimeException(sprintf('Manifest file "%s" does not exist', $this->path));
        }

        $this->data = json_decode(file_get_contents($this->path), true);
        if (json_last_error()) {
            throw new \RuntimeException(sprintf('Error parsing JSON from asset manifest file "%s" - %s', $this->path, json_last_error_msg()));
        }
    }
}

<?php

declare(strict_types = 1);

namespace Antares\ComponentPlugin;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use InvalidArgumentException;

abstract class ExtensionInstaller extends LibraryInstaller
{

    const VENDOR_TYPE = 'antaresproject';

    /**
     * Returns a subtype of the Antares Platform extension.
     *
     * @return string
     */
    public abstract function getPackageSubType();

    /**
     * Returns a directory name for this extension type.
     *
     * @return string
     */
    public abstract function getPackageDirectory();

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {


        var_dump('support', $packageType, $this->support($packageType));
        return $this->support($packageType);
    }

    protected function support($packageType)
    {
        $subTypes = $this->getPackageSubType();
        if (is_array($subTypes)) {
            foreach ($subTypes as $subType) {
                if ($packageType === (self::VENDOR_TYPE . '-' . $subType)) {
                    return true;
                }
            }
            return false;
        }
        return $packageType === (self::VENDOR_TYPE . '-' . $subTypes);
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     */
    public function getInstallPath(PackageInterface $package)
    {
        $name = $package->getName();

        if (strpos($name, '/') === false) {
            $message = sprintf('The package pretty name is invalid. Should be in <type>/<name> format. The [%s] Given.', $name);
            throw new InvalidArgumentException($message);
        }

        list(, $name) = explode('/', $name);

        $baseDir      = __DIR__ . '/../../../../src/';
        $srcDirectory = $baseDir . (strpos($package->getType(), 'component') ? 'core/src/modules/' : 'modules/');

        $name = trim(str_replace('-', '_', $name));
        $name = str_replace(['component_', 'module_'], '', $name);
        var_dump('getInstallPath', $name, $package->getType(), $srcDirectory);

        return $srcDirectory . '/' . $name;
    }

}

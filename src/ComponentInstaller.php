<?php

declare(strict_types = 1);

namespace Antares\ComponentPlugin;

class ComponentInstaller extends ExtensionInstaller
{

    /**
     * {@inheritDoc}
     */
    public function getPackageSubType()
    {
        return ['module', 'component'];
    }

    /**
     * {@inheritDoc}
     */
    public function getPackageDirectory()
    {
        return ['modules', 'components'];
    }

}

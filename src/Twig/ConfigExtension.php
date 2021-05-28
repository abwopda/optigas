<?php

namespace App\Twig;

use App\Gateway\ConfigGateway;

class ConfigExtension extends \Twig\Extension\AbstractExtension implements \Twig\Extension\GlobalsInterface
{
    private ConfigGateway $configGateway;

    public function __construct(ConfigGateway $configGateway)
    {
        $this->configGateway = $configGateway;
    }

    public function getGlobals(): array
    {
        $logoConfig = $this->configGateway->findAll();
        $result = [];
        foreach ($logoConfig as $cf) {
            $result[$cf->getTheKey()] = $cf->getTheValue();
        }
        return array(
        'app_config' => $result,
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'config_extension';
    }
}

<?php

namespace App\UseCase;

use App\Entity\Config;
use App\Gateway\ConfigGateway;
use Assert\Assert;

/**
 * Class ShowConfig
 * @package App\UseCase
 */
class ShowConfig
{
    /**
     * @var ConfigGateway
     */
    private ConfigGateway $configGateway;

    /**
     * ShowConfig constructor.
     * @param ConfigGateway $configGateway
     */
    public function __construct(ConfigGateway $configGateway)
    {
        $this->configGateway = $configGateway;
    }


    /**
     * @param Config|null $config
     * @return Config|null
     */
    public function execute(?Config $config): ?Config
    {
        return $config;
    }
}

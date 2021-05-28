<?php

namespace App\UseCase;

use App\Entity\Config;
use App\Gateway\ConfigGateway;
use Assert\Assert;

/**
 * Class UpdateConfig
 * @package App\UseCase
 */
class UpdateConfig
{
    /**
     * @var ConfigGateway
     */
    private ConfigGateway $configGateway;

    /**
     * UpdateConfig constructor.
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
        $this->configGateway->updateBy($config->getTheKey(), $config->getTheValue());
        return $config;
    }
}

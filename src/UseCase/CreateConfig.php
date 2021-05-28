<?php

namespace App\UseCase;

use App\Entity\Config;
use App\Gateway\ConfigGateway;
use Assert\Assert;

/**
 * Class CreateConfig
 * @package App\UseCase
 */
class CreateConfig
{
    /**
     * @var ConfigGateway
     */
    private ConfigGateway $configGateway;

    /**
     * CreateConfig constructor.
     * @param ConfigGateway $configGateway
     */
    public function __construct(ConfigGateway $configGateway)
    {
        $this->configGateway = $configGateway;
    }


    /**
     * @param Config $config
     * @return Config
     */
    public function execute(Config $config): Config
    {
        //var_export($config);
        Assert::lazy()
            ->that($config->getTheKey(), "thekey")->notBlank()
            ->that($config->getTheValue(), "thevalue")->notBlank()
            ->verifyNow()
        ;

        $this->configGateway->create($config);
        return $config;
    }
}

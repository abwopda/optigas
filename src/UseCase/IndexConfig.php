<?php

namespace App\UseCase;

use App\Entity\Config;
use App\Gateway\ConfigGateway;
use Assert\Assert;

/**
 * Class IndexConfig
 * @package App\UseCase
 */
class IndexConfig
{
    /**
     * @var ConfigGateway
     */
    private ConfigGateway $configGateway;

    /**
     * IndexConfig constructor.
     * @param ConfigGateway $configGateway
     */
    public function __construct(ConfigGateway $configGateway)
    {
        $this->configGateway = $configGateway;
    }


    /**
     * @return Config[]|null
     */
    public function execute(): ?array
    {
        return $this->configGateway->findAll();
    }
}

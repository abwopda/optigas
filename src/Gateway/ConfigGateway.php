<?php

namespace App\Gateway;

use App\Entity\Config;

/**
 * Interface ConfigGateway
 * @package App\Gateway
 */
interface ConfigGateway
{
    /**
     * @param Config $config
     */
    public function create(Config $config): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param $key
     * @param $value
     */
    public function updateBy($key, $value): int;

    /**
     * @param Config $config
     */
    public function delete(Config $config): void;

    /**
     * @param int $id
     * @return Config|null
     */
    public function findOneById(int $id): ?Config;

    /**
     * @return Config[]|null
     */
    public function findAll(): ?array;
}

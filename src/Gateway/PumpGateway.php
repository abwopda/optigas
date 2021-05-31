<?php

namespace App\Gateway;

use App\Entity\Pos;
use App\Entity\Pump;

/**
 * Interface PumpGateway
 * @package App\Gateway
 */
interface PumpGateway
{
    /**
     * @param Pump $pump
     */
    public function create(Pump $pump): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param int $id
     * @return Pump|null
     */
    public function findOneById(int $id): ?Pump;

    /**
     * @return Pump[]|null
     */
    public function findAll(): ?array;

    /**
     * @param $searchParam
     */
    public function search($searchParam);

    /**
     * @return mixed
     */
    public function counter();

    /**
     * @param Pump $pump
     */
    public function update(Pump $pump): void;

    /**
     * @param Pump $pump
     */
    public function remove(Pump $pump): void;

    /**
     * @param Pump $pump
     * @param bool $status
     */
    public function activate(Pump $pump, bool $status): void;

    /**
     * @param Pump $pump
     * @param bool $status
     */
    public function validate(Pump $pump, bool $status): void;
}

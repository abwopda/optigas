<?php

namespace App\UseCase;

use App\Entity\Store;
use App\Gateway\StoreGateway;
use Assert\Assert;

/**
 * Class UseStore
 * @package App\UseCase
 */
class UseStore
{
    /**
     * @var StoreGateway
     */
    private StoreGateway $storeGateway;

    /**
     * UseStore constructor.
     * @param StoreGateway $storeGateway
     */
    public function __construct(StoreGateway $storeGateway)
    {
        $this->storeGateway = $storeGateway;
    }


    /**
     * @param Store $store
     * @return Store
     */
    public function create(Store $store): Store
    {
        //var_export($store);
        Assert::lazy()
            ->that($store->getCode(), "code")->notBlank()
            ->that($store->getName(), "name")->notBlank()
            ->that($store->getDescription(), "description")->notBlank()
            ->that($store->getAddress(), "address")->notBlank()
            ->that($store->getTown(), "town")->notBlank()
            ->verifyNow()
        ;

        $this->storeGateway->create($store);
        return $store;
    }

    /**
     * @param Store|null $store
     * @return Store|null
     */
    public function show(?Store $store): ?Store
    {
        return $store;
    }

    /**
     * @return Store[]|null
     */
    public function findAll(): ?array
    {
        return $this->storeGateway->findAll();
    }

    /**
     * @param Store|null $store
     * @return Store|null
     */
    public function update(?Store $store): ?Store
    {
        $this->storeGateway->update($store);
        return $store;
    }

    /**
     * @param Store|null $store
     * @param bool $status
     * @return Store|null
     */
    public function activate(?Store $store, bool $status): ?Store
    {
        $this->storeGateway->activate($store, $status);

        return $store;
    }

    /**
     * @param Store|null $store
     * @param bool $status
     * @return Store|null
     */
    public function validate(?Store $store, bool $status): ?Store
    {
        $this->storeGateway->validate($store, $status);

        return $store;
    }

    /**
     * @param Store|null $store
     */
    public function delete(?Store $store)
    {
        $this->storeGateway->remove($store);
    }
}

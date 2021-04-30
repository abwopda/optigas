<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Contact;
use App\Gateway\ContactGateway;

/**
 * Class ContactRepository
 * @package App\Adapter\InMemory\Repository
 */
class ContactRepository extends UserRepository implements ContactGateway
{
    public function register(Contact $contact): void
    {
        // TODO: Implement register() method.
    }
}

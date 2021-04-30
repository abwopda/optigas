<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Contact;
use App\Gateway\ContactGateway;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ContactRepository
 * @package App\Adapter\Doctrine\Repository
 */
class ContactRepository extends UserRepository implements ContactGateway
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function register(Contact $contact): void
    {
        $this->_em->persist($contact);
        $this->_em->flush();
    }
}

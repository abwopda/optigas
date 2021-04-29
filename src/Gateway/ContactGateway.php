<?php


namespace App\Gateway;

use App\Entity\Contact;

/**
 * Interface ContactGateway
 * @package App\Gateway
 */
interface ContactGateway extends UserGateway
{
    /**
     * @param Contact $contact
     */
    public function register(Contact $contact): void;
}
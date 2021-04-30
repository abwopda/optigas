<?php

namespace App\UseCase;

use App\Entity\Contact;
use App\Gateway\ContactGateway;
use Assert\Assert;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegisterContact
 * @package App\UseCase
 */
class RegisterContact
{
    /**
     * @var ContactGateway
     */
    private ContactGateway $contactGateway;


    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;

    /**
     * RegisterContact constructor.
     * @param ContactGateway $contactGateway
     */
    public function __construct(ContactGateway $contactGateway, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->contactGateway = $contactGateway;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param Contact $contact
     * @return Contact
     */
    public function execute(Contact $contact): Contact
    {
        //var_export($contact);
        Assert::lazy()
            ->that($contact->getFirstName(), "firstName")->notBlank()
            ->that($contact->getLastName(), "lastName")->notBlank()
            ->that($contact->getCompanyName(), "companyName")->notBlank()
            ->that($contact->getPlainPassword(), "plainPassword")
                ->notBlank()
                ->regex(
                    "/^(?:(?=.*[a-z])(?:(?=.*[A-Z])(?=.*[\d\W])|(?=.*\W)(?=.*\d))|(?=.*\W)(?=.*[A-Z])(?=.*\d)).{8,}$/"
                )
            ->that($contact->getEmail(), "email")
                ->notBlank()
                ->email()
            ->verifyNow()
        ;

        $contact->setPassword(
            $this->userPasswordEncoder->encodePassword($contact, $contact->getPlainPassword())
        );

        $this->contactGateway->register($contact);

        return $contact;
    }
}

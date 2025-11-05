<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\MappedSuperclass()
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
abstract class User implements UserInterface
{
    /**
     * @var UuidInterface
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $password;

    public function __construct(
        UuidInterface $id,
        string $email,
        string $plaintextPassword,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->id = $id;
        $this->setEmail($email);
        $this->setPassword($plaintextPassword, $passwordEncoder);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $emailValidator = new EmailValidator();
        if (!$emailValidator->isValid($email, new RFCValidation())) {
            throw new \UnexpectedValueException();
        }

        $this->email = $email;
    }

    public function setPassword(string $plaintextPassword, UserPasswordEncoderInterface $passwordEncoder): void
    {
        $this->password = $passwordEncoder->encodePassword($this, $plaintextPassword);
    }

    // UserInterface

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}

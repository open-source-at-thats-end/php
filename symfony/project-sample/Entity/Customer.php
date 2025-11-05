<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap({"diasporan" = Diasporan::class, "service_provider" = ServiceProvider::class})
 */
abstract class Customer extends User
{

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return ['ROLE_CUSTOMER'];
    }
    
}

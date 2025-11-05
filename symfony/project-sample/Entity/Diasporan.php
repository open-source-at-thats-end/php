<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiasporanRepository")
 */
class Diasporan extends Customer
{
    public function getRoles(): array
    {
        return array_merge(parent::getRoles(), ['ROLE_DIASPORAN']);
    }
}

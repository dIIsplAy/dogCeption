<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin extends User
{
    public function getRoles(): array
    {
        $roles = parent::getRoles();
        
        return array_merge($roles, [
            'ROLE_ADMIN',
        ]);
    }
}

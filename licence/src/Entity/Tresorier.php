<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TresorierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      routePrefix="/admin",
 *      attributes={
 *         "security"="is_granted('ROLE_ADMIN')", 
 *         "security_message"="Vous n'avez pas access à cette Ressource",
 *     },
 *     collectionOperations={"POST","GET"},
 *     itemOperations={"PUT", "GET", "DELETE"},
 *     normalizationContext={"groups"={"Tresorier:read"}},
 *     denormalizationContext={"groups"={"Tresorier:write"}}
 * )
 * @ORM\Entity(repositoryClass=TresorierRepository::class)
 */
class Tresorier extends User
{
    
}

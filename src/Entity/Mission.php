<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;


    /**
     * @ORM\OneToOne(targetEntity=Plateau::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Plateau $plateau;

    /**
     * @ORM\OneToOne(targetEntity=RoverSquad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private RoverSquad $roverSquad;

    public function __construct(Plateau $plateau, RoverSquad $roverSquad)
    {
        $this->plateau = $plateau;
        $this->roverSquad = $roverSquad;
    }

    public function serialize(): string
    {
        return $this->roverSquad->serialize();
    }

    /**
     * Getter of plateau
     *
     * @return Plateau
     */
    public function getPlateau(): Plateau
    {
        return $this->plateau;
    }

    /**
     * Getter of roverSquad
     * @return RoverSquad
     */
    public function getRoverSquad(): RoverSquad
    {
        return $this->roverSquad;
    }

}

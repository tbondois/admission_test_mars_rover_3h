<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Rover;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class RoverSquad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var ArrayCollection|Rover[]
     * @Assert\Count(min = 1)
     */
    private ArrayCollection $rovers;


    public function __construct(ArrayCollection $rovers)
    {
        $this->rovers = $rovers;
    }

    public function serialize(): string
    {
        $str = "";
        foreach($this->getRovers() as $rover) {
            $str.= $rover->serialize()."\n";
        }
        return $str;
    }

    /**
     * Getter of rovers
     * @return ArrayCollection|Rover[]
     */
    public function getRovers(): ArrayCollection
    {
        return $this->rovers;
    }

}

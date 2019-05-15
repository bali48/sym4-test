<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Department
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ticket", mappedBy="Department", cascade={"persist", "remove"})
     */
    private $ticket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        // set (or unset) the owning side of the relation if necessary
        $newDepartment = $ticket === null ? null : $this;
        if ($newDepartment !== $ticket->getDepartment()) {
            $ticket->setDepartment($newDepartment);
        }

        return $this;
    }
}

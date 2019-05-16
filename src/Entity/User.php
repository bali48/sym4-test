<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dob", type="datetime", nullable=true)
     */
    private $dob;

    /**
     * @var string|null
     *
     * @ORM\Column(name="guid", type="guid", length=36, nullable=true, options={"fixed"=true})
     */
    private $guid;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdat", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="createdby", type="text", length=0, nullable=true)
     */
    private $createdby;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updatedat", type="datetime", nullable=true)
     */
    private $updatedat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="updatedby", type="text", length=0, nullable=true)
     */
    private $updatedby;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="UserLogs_backup.php", mappedBy="user", orphanRemoval=true)
     */
    private $userLogs;

    public function __construct()
    {
        $this->userLogs = new ArrayCollection();
    }

    /**
     * @return Collection|UserLogsBackup[]
     */
    public function getUserLogs(): Collection
    {
        return $this->userLogs;
    }

    public function addUserLog(UserLogsBackup $userLog): self
    {
        if (!$this->userLogs->contains($userLog)) {
            $this->userLogs[] = $userLog;
            $userLog->setUser($this);
        }

        return $this;
    }

    public function removeUserLog(UserLogsBackup $userLog): self
    {
        if ($this->userLogs->contains($userLog)) {
            $this->userLogs->removeElement($userLog);
            // set the owning side to null (unless already changed)
            if ($userLog->getUser() === $this) {
                $userLog->setUser(null);
            }
        }

        return $this;
    }


}

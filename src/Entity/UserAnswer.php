<?php

namespace App\Entity;

use App\Repository\UserAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserAnswerRepository::class)
 */
class UserAnswer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Answer::class, inversedBy="userAnswers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Answer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userAnswers")
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?Answer
    {
        return $this->Answer;
    }

    public function setAnswer(?Answer $Answer): self
    {
        $this->Answer = $Answer;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}

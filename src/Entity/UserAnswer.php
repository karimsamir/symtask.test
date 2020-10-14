<?php

namespace App\Entity;

use App\Repository\UserAnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToMany(targetEntity=Question::class, inversedBy="userAnswers")
     */
    private $question;

    public function __construct()
    {
        $this->question = new ArrayCollection();
    }

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

    /**
     * @return Collection|Question[]
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->question->contains($question)) {
            $this->question[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->question->contains($question)) {
            $this->question->removeElement($question);
        }

        return $this;
    }
}

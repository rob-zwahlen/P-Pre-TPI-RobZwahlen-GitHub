<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Regex(
        '/^[a-z ,.\'-]+$/i',
        message: 'La saisie n\'est pas valide.'
    ),
    Assert\Length(
        max: 50,
        maxMessage: 'Le prénom que vous avez saisi est trop long. La limite est de {{ limit }} caractères.'
    )]
    #[ORM\Column(type: 'string', length: 60)]
    private $firstname;

    #[Assert\Regex(
        '/^[a-z ,.\'-]+$/i',
        message: 'La saisie n\'est pas valide.'
    )]
    #[ORM\Column(type: 'string', length: 60)]
    private $lastname;

    #[Assert\Regex('/^m|w|o$/')]
    #[ORM\Column(type: 'string', length: 1)]
    private $gender;

    #[ORM\Column(type: 'string', length: 60)]
    private $nickname;

    #[ORM\Column(type: 'text')]
    private $nickname_origin;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'teachers')]
    #[ORM\JoinColumn(nullable: false)]
    private $section;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->firstname . ' ' . $this->lastname;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getNicknameOrigin(): ?string
    {
        return $this->nickname_origin;
    }

    public function setNicknameOrigin(string $nickname_origin): self
    {
        $this->nickname_origin = $nickname_origin;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }
}

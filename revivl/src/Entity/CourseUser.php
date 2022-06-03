<?php

namespace App\Entity;

use App\Helper\Status\CourseUserStatus;
use App\Helper\Status\StatusTrait;
use App\Repository\CourseUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseUserRepository::class)]
#[ORM\Table(name: 'course_user')]
class CourseUser
{
    use StatusTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private readonly int $id;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'patient')]
    private $course;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'courses')]
    private $patient;

    public function __construct()
    {
        $this->setStatus(CourseUserStatus::NOT_PAY->value);
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function setCourse($course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}

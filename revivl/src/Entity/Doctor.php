<?php

namespace App\Entity;

use App\Entity\Traits\FioTrait;
use App\Entity\Traits\PhotoTrait;
use App\Entity\Traits\SexTrait;
use App\Repository\DoctorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\Enum\Role;

#[ORM\Entity(repositoryClass: DoctorRepository::class)]
#[ORM\Table(name: 'doctor')]
class Doctor extends AbstractUser
{
    use FioTrait;
    use SexTrait;
    use PhotoTrait;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: Course::class)]
    private $courses;

    public function __construct()
    {
        parent::__construct();
        $this->addDoctorRole();
        $this->courses = new ArrayCollection();
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setDoctor($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getDoctor() === $this) {
                $course->setDoctor(null);
            }
        }

        return $this;
    }
}

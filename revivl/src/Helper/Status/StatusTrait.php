<?php


namespace App\Helper\Status;


use Doctrine\ORM\Mapping as ORM;
use ReflectionException;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Trait StatusTrait
 * @package App\Helper\Status
 */
trait StatusTrait
{
    #[ORM\Column(type: 'integer')]
    protected $status;

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    protected function getStatusClass(): mixed
    {
        $function = new \ReflectionClass($this);
        $statusClassName = 'App\Helper\Status\\' . $function->getShortName() . "Status";
        $statusClass = new $statusClassName;
        return $statusClass;
    }

    public function getStatusName() :string
    {
        $statusClass = $this->getStatusClass();
        return $statusClass::getName($this->getStatus());
    }

    public function getStatusType(): mixed
    {
        return $this->getStatusClass()->getType($this->getStatus());
    }
}
<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Fields
{
    protected $name;
	protected $age;
    protected $actDate;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
	 public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getactDate()
    {
        return $this->actDate;
    }

    public function setactDate(\DateTime $actDate = null)
    {
        $this->actDate = $actDate;
    }
	
	
	public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
         $metadata->addPropertyConstraint('name', new Assert\NotBlank());
		 
		 $metadata->addPropertyConstraint('name', new Assert\Regex(array(
		 'pattern' => '/^[A-ZА-ЯЁ][a-zа-яё]+\s[A-ZА-ЯЁ][a-zа-яё]+\b/u',
		 'htmlPattern' => '^[A-ZА-ЯЁ][a-zа-яё]+\s[A-ZА-ЯЁ][a-zа-яё]+\b',
		 'message' => 'Вы должны написать фамилию и имя с заглавной буквы',
		 )));
		 
         $metadata->addPropertyConstraint('age', new Assert\Range(array(
            'min'        => 17,
            'max'        => 65,
            'minMessage' => 'Ваш возвраст должен быть не менее {{ limit }} лет',
            'maxMessage' => 'Ваш возвраст должен быть не более {{ limit }} лет',
        )));
		$metadata->addPropertyConstraint('file', new Assert\File(array(
            'maxSize' => 6000000,
        )));
         
    }
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    public $filename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
	 /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
}
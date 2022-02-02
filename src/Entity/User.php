<?php

namespace App\Entity;

/* Nos permite deovlvcer un array de colecciones de objetos de doctrine */
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

// Para poder cifrar contraseñas
use Symfony\Component\Security\Core\User\UserInterface;

// VALIDACIONES
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User implements UserInterface
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
     * @var string|null
     *
     * @ORM\Column(name="role", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $role = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z]+/")
     */
    private $name = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="surname", type="string", length=200, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z]+/")
     */
    private $surname = 'NULL';



    //---------------------------------------------------------------------
    //El checkMX de la validación del email hace más precisa la validación
    //---------------------------------------------------------------------



    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank
     * @Assert\Email(
     *          message = "El email '{{ value }}' no es válido")
     */
    private $email = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank
     */
    private $password = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $createdAt = 'NULL';

    /* Hacemos esto para que doctrine posteriormente pueda rellenar dicho array */
    //Un usuario puede tener muhcas tareas (OneToMany), le indicamos la entidad que es
    //el modelo de Task y le indicamos que está mapeado por el modelo User
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task",mappedBy="user")
     */
    private $tasks;

    public function __construct(){
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    //Añadimos el método que devuelve las tareas
    /**
     * @return Collection|Task[]
     */
    public function getTasks():Collection{
        return $this->tasks;
    }

    public function getUsername(){
        return $this->email;
    }

    public function getSalt(){
        return null;
    }

    public function getRoles(){
        return array('ROLE_USER');
    }

    public function eraseCredentials(){

    }

}

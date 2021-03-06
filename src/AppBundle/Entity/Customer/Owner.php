<?php

namespace AppBundle\Entity\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use \DateTime;

/**
 * Class Gender
 * @package AppBundle\Entity\Customer
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Customer\OwnerRepository")
 * @ORM\Table(name="owner")
 */
class Owner
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(name="id", type="integer")
	 *
	 * @var int
	 */
	private $id;

	/**
	 * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
	 *
	 * @Assert\Type(type="string")
	 *
	 * @var string
	 */
	private $firstName;

	/**
	 * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Type(type="string")
	 *
	 * @var string
	 */
	private $lastName;

	/**
	 * @ORM\Column(name="birth_date", type="date", nullable=true)
	 *
	 * @Assert\Date()
	 *
	 * @var DateTime
	 */
	private $birthDate;

	/**
	 * @ORM\Column(name="gender", type="string", length=6, nullable=true)
	 *
	 * @Assert\Choice(choices={"male", "female"}, message="Choose a valid gender")
	 *
	 * @var string
	 */
	private $gender;

	/**
	 * @ORM\Column(name="job", type="string", length=255, nullable=true)
	 *
	 * @Assert\Type(type="string")
	 *
	 * @var string
	 */
	private $job;

	/**
	 * @ORM\Column(name="phone", type="string", length=10, nullable=false)
	 *
	 * @Assert\Regex("~(\+\d{2,3}|0)\d{9}~")
	 * @Assert\Type(type="string")
	 *
	 * @var string
	 */
	private $phone;

	/**
	 * @ORM\Column(name="email", type="string", length=255, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 *
	 * @var string
	 */
	private $email;

	/**
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Customer\LifeStyle", fetch="EAGER")
	 * @ORM\JoinTable(name="l__owner_life_style",
	 *     joinColumns={@ORM\JoinColumn(name="owner_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="life_style_id", referencedColumnName="id")}
	 * )
	 *
	 * @var LifeStyle[]
	 */
	private $lifeStyle;

	/**
	 * @ORM\Column(name="comments", type="text", nullable=true)
	 *
	 * @Assert\Type(type="string")
	 *
	 * @var string
	 */
	private $comments;

	/**
	 * @ORM\ManyToOne(
	 *     targetEntity="AppBundle\Entity\Customer\Customer",
	 *     inversedBy="owners",
	 *     fetch="EAGER",
	 *     cascade={"persist"}
	 *	 )
	 * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
	 *
	 * @var Customer
	 */
	private $customer;

	public static $genders = [
		'male'   => 'entity.owner.gender.male',
		'female' => 'entity.owner.gender.female',
	];

	public function __construct()
	{
		$this->lifeStyle = new ArrayCollection();
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 *
	 * @return Owner
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 *
	 * @return Owner
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 *
	 * @return Owner
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;

		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getBirthDate()
	{
		return $this->birthDate;
	}

	/**
	 * @param DateTime $birthDate
	 *
	 * @return Owner
	 */
	public function setBirthDate(DateTime $birthDate = null)
	{
		$this->birthDate = $birthDate;

		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getAge()
	{
		return $this->getBirthDate()->diff(new DateTime('now'))->y;
	}

	/**
	 * @return int
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * @param int|string $gender
	 *
	 * @return Owner
	 */
	public function setGender($gender)
	{
		if (!is_string($gender) || !array_key_exists($gender, static::$genders)) {
			throw new \InvalidArgumentException(
				sprintf(
					'The given gender value must be one of the valid string : "%s".',
					join(', ', array_flip(static::$genders))
				)
			);
		}

		$this->gender = $gender;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getJob()
	{
		return $this->job;
	}

	/**
	 * @param string $job
	 *
	 * @return Owner
	 */
	public function setJob($job)
	{
		$this->job = $job;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 *
	 * @return Owner
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 *
	 * @return Owner
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getLifeStyle()
	{
		return $this->lifeStyle;
	}

	/**
	 * @param ArrayCollection $lifeStyle
	 *
	 * @return Owner
	 */
	public function setLifeStyle($lifeStyle)
	{
		$this->lifeStyle = $lifeStyle;

		return $this;
	}

	/**
	 * @param LifeStyle $lifeStyle
	 *
	 * @return Owner
	 */
	public function addLifeStyle(LifeStyle $lifeStyle)
	{
		$this->lifeStyle->add($lifeStyle);

		return $this;
	}

	/**
	 * @param LifeStyle $lifeStyle
	 *
	 * @return Owner
	 */
	public function removeLifeStyle(LifeStyle $lifeStyle)
	{
		$this->lifeStyle->removeElement($lifeStyle);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getComments()
	{
		return $this->comments;
	}

	/**
	 * @param string $comments
	 *
	 * @return Owner
	 */
	public function setComments($comments)
	{
		$this->comments = $comments;

		return $this;
	}

	/**
	 * @return Customer
	 */
	public function getCustomer()
	{
		return $this->customer;
	}

	/**
	 * @param Customer $customer
	 *
	 * @return Owner
	 */
	public function setCustomer(Customer $customer)
	{
		$this->customer = $customer;

		return $this;
	}

	public function __toString()
	{
		return sprintf(
			'%s %s',
			strtoupper($this->lastName),
			ucfirst(strtolower($this->firstName))
		);
	}
}
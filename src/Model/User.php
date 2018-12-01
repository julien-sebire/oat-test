<?php
namespace App\Model;

/**
 * Data object for user.
 */
class User
{
    const MAPPED_FIELDS = [
        'login' => 'userId',
    ];

    /**
     * @var string
     */
    private $userId = '';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $lastname = '';

    /**
     * @var string
     */
    private $firstname = '';

    /**
     * @var string
     */
    private $gender = '';

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $picture = '';

    /**
     * @var string
     */
    private $address = '';

    ////////////////////////////////////////////////////////////////////////////
    /// Constructor and object to array conversion.

    /**
     * User constructor.
     * Allows property population from array of fields.
     *
     * @param array $fields array of fields corresponding to User properties
     */
    public function __construct(array $fields = [])
    {
        foreach ($fields as $name => $value) {
            // Finds the property name from field name (most are equivalent, some are mapped.
            $property = self::MAPPED_FIELDS[$name] ?? $name;

            // Checks for valid setter function.
            $setter = 'set' . ucfirst($property);
            if (!is_callable([$this, $setter])) {
                throw new \RuntimeException('Unable to handle unknown field "' . $name . '"');
            }

            $this->$setter($value);
        }
    }

    public function toArray(): array
    {
        return [
            'Login' => $this->getUserId(),
            'Password' => $this->getPassword(),
            'Title' => $this->getTitle(),
            'Last name' => $this->getLastname(),
            'First name' => $this->getFirstname(),
            'Gender' => $this->getGender(),
            'e-mail' => $this->getEmail(),
            'Picture' => $this->getPicture(),
            'Address' => $this->getAddress(),
        ];
    }

    ////////////////////////////////////////////////////////////////////////////
    /// User selection.

    /**
     * Does the user have the given name in first name, last name, email or user id?
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasName(string $name): bool
    {
        return strpos($this->getFirstname(), $name) !== false
            || strpos($this->getLastname(), $name) !== false
            || strpos($this->getEmail(), $name) !== false
            || strpos($this->getUserId(), $name) !== false;
    }

    /**
     * Does the user have the given id?
     *
     * @param string $id
     *
     * @return bool
     */
    public function hasUserId(string $id): bool
    {
        return $this->getUserId() === $id;
    }

    ////////////////////////////////////////////////////////////////////////////
    /// Trivial accessors.

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     *
     * @return User
     */
    public function setUserId(string $userId): User
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return User
     */
    public function setTitle(string $title): User
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return User
     */
    public function setGender(string $gender): User
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     *
     * @return User
     */
    public function setPicture(string $picture): User
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return User
     */
    public function setAddress(string $address): User
    {
        $this->address = $address;
        return $this;
    }
}

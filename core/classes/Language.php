<?php

/**
 * Simple class that is used for one language.
 */
class Language
{

    /**
     * Constructor.
     *
     * @param string $id Language ID
     * @param string $short Short name of this language
     * @param string $name Full name of this language
     * @throws InvalidArgumentException If arguments are invalid
     * @since 1.0
     */
    public function __construct($id, $short, $name)
    {
        if ((int) $id < 0)
            throw new InvalidArgumentException("ID is not valid.");

        if (!is_string($short))
            throw new InvalidArgumentException("Short name must be string.");

        if (!is_string($name))
            throw new InvalidArgumentException("Name must be string.");


        $this->short = $short;
        $this->name = $name;
        $this->id = (int) $id;
    }

    /**
     * Returns full name.
     *
     * @return string Full name
     * @since 1.0
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns short name.
     *
     * @return string short name
     * @since 1.0
     */
    public function getShort()
    {
        return $this->short;
    }

    /**
     * Returns ID.
     *
     * @return int ID
     * @since 1.0
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Short name.
     *
     * @var string
     * @since 1.0
     */
    private $short;

    /**
     * Full name.
     *
     * @var string
     * @since 1.0
     */
    private $name;

    /**
     * ID.
     *
     * @var int
     * @since 1.0
     */
    private $id;
}
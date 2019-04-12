<?php

namespace App;

class Algorithm
{
    public $firstUser;
    public $secondUser;

    /**
     * Constructor
     *
     * @param int $firstUser id of the first user
     * @param int $secondUser id of the second user
     */
    public function __construct($firstUser, $secondUser)
    {
        $this->firstUser = $firstUser;
        $this->secondUser = $secondUser;
    }

    /**
     * Vergelijk data van beide users
     *
     * @param int $firstUser id of the first user
     * @param int $secondUser id of the second user
     *
     * @return Comparison
     */
    public static function compare($firstUser, $secondUser)
    {
        return new Comparison($firstUser, $secondUser);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 19/10/2017
 * Time: 16:29
 */

namespace CitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package CitiesBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


}
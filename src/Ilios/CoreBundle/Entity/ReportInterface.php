<?php

namespace Ilios\CoreBundle\Entity;

use Ilios\CoreBundle\Traits\DeletableEntityInterface;
use Ilios\CoreBundle\Traits\IdentifiableEntityInterface;
use Ilios\CoreBundle\Traits\TitledEntityInterface;

/**
 * Interface ReportInterface
 * @package Ilios\CoreBundle\Entity
 */
interface ReportInterface extends
    IdentifiableEntityInterface,
    TitledEntityInterface,
    LoggableEntityInterface,
    DeletableEntityInterface
{

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param string $subject
     */
    public function setSubject($subject);

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @param string $prepositionalObject
     */
    public function setPrepositionalObject($prepositionalObject);

    /**
     * @return string
     */
    public function getPrepositionalObject();

    /**
     * @param string $prepositionalObjectTableRowId
     */
    public function setPrepositionalObjectTableRowId($prepositionalObjectTableRowId);

    /**
     * @return string
     */
    public function getPrepositionalObjectTableRowId();

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();
}

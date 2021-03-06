<?php

namespace Ilios\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Ilios\CoreBundle\Traits\IdentifiableEntityInterface;
use Ilios\CoreBundle\Traits\TitledEntityInterface;
use Ilios\CoreBundle\Traits\StringableEntityInterface;
use Ilios\CoreBundle\Traits\OfferingsEntityInterface;

/**
 * Interface GroupInterface
 * @package Ilios\CoreBundle\Entity
 */
interface LearnerGroupInterface extends
    IdentifiableEntityInterface,
    TitledEntityInterface,
    StringableEntityInterface,
    OfferingsEntityInterface,
    LoggableEntityInterface
{
    /**
     * @param string $location
     */
    public function setLocation($location);

    /**
     * @return string
     */
    public function getLocation();

    /**
     * @param CohortInterface $cohort
     */
    public function setCohort(CohortInterface $cohort);

    /**
     * @return CohortInterface
     */
    public function getCohort();

    /**
     * @param string $instructors
     */
    public function setInstructors($instructors);

    /**
     * @return string
     */
    public function getInstructors();

    /**
     * @param Collection $users
     */
    public function setUsers(Collection $users);

    /**
     * @param UserInterface $user
     */
    public function addUser(UserInterface $user);

    /**
     * @return ArrayCollection|UserInterface[]
     */
    public function getUsers();

    /**
     * @param Collection $ilmSessions
     */
    public function setIlmSessions(Collection $ilmSessions);

    /**
     * @param IlmSessionInterface $ilmSession
     */
    public function addIlmSession(IlmSessionInterface $ilmSession);

    /**
     * @return ArrayCollection|IlmSessionInterface[]
     */
    public function getIlmSessions();

    /**
     * @param LearnerGroupInterface $parent
     */
    public function setParent(LearnerGroupInterface $parent);

    /**
     * @return LearnerGroupInterface
     */
    public function getParent();

    /**
     * @param Collection $children
     */
    public function setChildren(Collection $children);

    /**
     * @param LearnerGroupInterface $child
     */
    public function addChild(LearnerGroupInterface $child);

    /**
     * @return ArrayCollection|LearnerGroupInterface[]
     */
    public function getChildren();

    /**
     * @param Collection $instructorGroups
     */
    public function setInstructorGroups(Collection $instructorGroups);

    /**
     * @param InstructorGroupInterface $instructorGroup
     */
    public function addInstructorGroup(InstructorGroupInterface $instructorGroup);

    /**
     * @return ArrayCollection|InstructorGroupInterface[]
     */
    public function getInstructorGroups();

    /**
     * @param Collection $instructorUsers
     */
    public function setInstructorUsers(Collection $instructorUsers);

    /**
     * @param UserInterface $instructorUser
     */
    public function addInstructorUser(UserInterface $instructorUser);

    /**
     * @return ArrayCollection|UserInterface[]
     */
    public function getInstructorUsers();
}

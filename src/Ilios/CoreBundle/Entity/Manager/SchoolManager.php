<?php

namespace Ilios\CoreBundle\Entity\Manager;

use Doctrine\ORM\Id\AssignedGenerator;
use Ilios\CoreBundle\Entity\SchoolInterface;

/**
 * Class SchoolManager
 * @package Ilios\CoreBundle\Entity\Manager
 */
class SchoolManager extends AbstractManager implements SchoolManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function findSchoolBy(
        array $criteria,
        array $orderBy = null
    ) {
        $criteria['deleted'] = false;
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * {@inheritdoc}
     */
    public function findSchoolsBy(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null
    ) {
        $criteria['deleted'] = false;
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function updateSchool(
        SchoolInterface $school,
        $andFlush = true,
        $forceId = false
    ) {
        $this->em->persist($school);

        if ($forceId) {
            $metadata = $this->em->getClassMetaData(get_class($school));
            $metadata->setIdGenerator(new AssignedGenerator());
        }

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteSchool(
        SchoolInterface $school
    ) {
        $school->setDeleted(true);
        $this->updateSchool($school);
    }

    /**
     * {@inheritdoc}
     */
    public function createSchool()
    {
        $class = $this->getClass();
        return new $class();
    }

    /**
     * {@inheritdoc}
     */
    public function findEventsForSchool(
        $schoolId,
        \DateTime $from,
        \DateTime $to
    ) {
        return $this->getRepository()->findEventsForSchool($schoolId, $from, $to);
    }
}

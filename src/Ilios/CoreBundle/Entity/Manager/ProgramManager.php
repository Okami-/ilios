<?php

namespace Ilios\CoreBundle\Entity\Manager;

use Doctrine\ORM\Id\AssignedGenerator;
use Ilios\CoreBundle\Entity\ProgramInterface;

/**
 * Class ProgramManager
 * @package Ilios\CoreBundle\Entity\Manager
 */
class ProgramManager extends AbstractManager implements ProgramManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function findProgramBy(
        array $criteria,
        array $orderBy = null
    ) {
        $criteria['deleted'] = false;
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * {@inheritdoc}
     */
    public function findProgramsBy(
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
    public function updateProgram(
        ProgramInterface $program,
        $andFlush = true,
        $forceId = false
    ) {
        $this->em->persist($program);

        if ($forceId) {
            $metadata = $this->em->getClassMetaData(get_class($program));
            $metadata->setIdGenerator(new AssignedGenerator());
        }

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteProgram(
        ProgramInterface $program
    ) {
        $program->setDeleted(true);
        $this->updateProgram($program);
    }

    /**
     * {@inheritdoc}
     */
    public function createProgram()
    {
        $class = $this->getClass();
        return new $class();
    }
}

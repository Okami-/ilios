<?php

namespace Ilios\CoreBundle\Traits;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Ilios\CoreBundle\Entity\ProgramYearInterface;

/**
 * Class ProgramYearsEntity
 * @package Ilios\CoreBundle\Traits
 */
trait ProgramYearsEntity
{
    /**
     * @param Collection $programYears
     */
    public function setProgramYears(Collection $programYears)
    {
        $this->programYears = new ArrayCollection();

        foreach ($programYears as $programYear) {
            $this->addProgramYear($programYear);
        }
    }

    /**
     * @param ProgramYearInterface $programYear
     */
    public function addProgramYear(ProgramYearInterface $programYear)
    {
        $this->programYears->add($programYear);
    }

    /**
    * @return ProgramYearInterface[]|ArrayCollection
    */
    public function getProgramYears()
    {
        //criteria not 100% reliale on many to many relationships
        //fix in https://github.com/doctrine/doctrine2/pull/1399
        // $criteria = Criteria::create()->where(Criteria::expr()->eq("deleted", false));
        // return new ArrayCollection($this->programYears->matching($criteria)->getValues());
        
        $arr = $this->programYears->filter(function ($entity) {
            return !$entity->isDeleted();
        })->toArray();
        
        $reIndexed = array_values($arr);
        
        return new ArrayCollection($reIndexed);
    }
}

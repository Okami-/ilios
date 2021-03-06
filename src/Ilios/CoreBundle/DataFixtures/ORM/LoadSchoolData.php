<?php

namespace Ilios\CoreBundle\DataFixtures\ORM;

use Ilios\CoreBundle\Entity\School;
use Ilios\CoreBundle\Entity\SchoolInterface;

/**
 * Class LoadSchoolData
 * @package Ilios\CoreBundle\DataFixtures\ORM
 */
class LoadSchoolData extends AbstractFixture
{
    public function __construct()
    {
        parent::__construct('school');
    }

    /**
     * @return SchoolInterface
     *
     * @see AbstractFixture::createEntity()
     */
    protected function createEntity()
    {
        return new School();
    }


    /**
     * @param SchoolInterface $entity
     * @param array $data
     * @return SchoolInterface
     *
     * @see AbstractFixture::populateEntity()
     */
    protected function populateEntity($entity, array $data)
    {
        // `school_id`,`template_prefix`,`title`,`ilios_administrator_email`,`deleted`,`change_alert_recipients`
        $entity->setId($data[0]);
        $entity->setTemplatePrefix($data[1]);
        $entity->setTitle($data[2]);
        $entity->setIliosAdministratorEmail($data[3]);
        $entity->setDeleted((boolean) $data[4]);
        $entity->setChangeAlertRecipients($data[5]);
        return $entity;
    }
}

<?php

namespace Ilios\CoreBundle\Tests\Fixture;

use Ilios\CoreBundle\Entity\Session;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSessionData extends AbstractFixture implements
    FixtureInterface,
    DependentFixtureInterface,
    ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $data = $this->container
            ->get('ilioscore.dataloader.session')
            ->getAll();
        foreach ($data as $arr) {
            $entity = new Session();
            $entity->setId($arr['id']);
            $entity->setTitle($arr['title']);
            $entity->setDeleted($arr['deleted']);
            if (!empty($arr['sessionType'])) {
                $entity->setSessionType($this->getReference('sessionTypes' . $arr['sessionType']));
            }
            if (!empty($arr['course'])) {
                $entity->setCourse($this->getReference('courses' . $arr['course']));
            }
            if (!empty($arr['publishEvent'])) {
                $entity->setPublishEvent($this->getReference('publishEvents' . $arr['publishEvent']));
            }
            $related = array(
                'topics' => 'addTopic',
                'objectives' => 'addObjective'
            );
            foreach ($related as $key => $method) {
                foreach ($arr[$key] as $id) {
                    $entity->$method($this->getReference($key . $id));
                }
            }
            $manager->persist($entity);

            $this->addReference('sessions' . $arr['id'], $entity);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            'Ilios\CoreBundle\Tests\Fixture\LoadSessionTypeData',
            'Ilios\CoreBundle\Tests\Fixture\LoadCourseData',
            'Ilios\CoreBundle\Tests\Fixture\LoadObjectiveData',
            'Ilios\CoreBundle\Tests\Fixture\LoadPublishEventData',
        );
    }
}

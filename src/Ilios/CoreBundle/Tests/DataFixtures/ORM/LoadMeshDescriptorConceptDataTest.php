<?php

namespace Ilios\CoreBundle\Tests\DataFixtures\ORM;

use Ilios\CoreBundle\Entity\Manager\MeshDescriptorManagerInterface;
use Ilios\CoreBundle\Entity\MeshDescriptorInterface;
use Ilios\CoreBundle\Entity\MeshConceptInterface;

/**
 * Class LoadMeshDescriptorConceptDataTest
 * @package Ilios\CoreBundle\Tests\DataFixtures\ORM
 */
class LoadMeshDescriptorConceptDataTest extends AbstractDataFixtureTest
{
    /**
     * {@inheritdoc}
     */
    public function getEntityManagerServiceKey()
    {
        return 'ilioscore.meshdescriptor.manager';
    }

    /**
     * {@inheritdoc}
     */
    public function getFixtures()
    {
        return [
          'Ilios\CoreBundle\DataFixtures\ORM\LoadMeshDescriptorConceptData',
        ];
    }

    /**
     * @covers Ilios\CoreBundle\DataFixtures\ORM\LoadMeshDescriptorConceptData::load
     * @group mesh_data_import
     */
    public function testLoad()
    {
        $this->runTestLoad('mesh_descriptor_x_concept.csv', 10);
    }

    /**
     * @param array $data
     * @param MeshDescriptorInterface $entity
     */
    protected function assertDataEquals(array $data, $entity)
    {
        // `mesh_concept_uid`,`mesh_descriptor_uid`
        $this->assertEquals($data[1], $entity->getId());
        // find the concept
        $conceptId = $data[0];
        $concept = $entity->getConcepts()->filter(function (MeshConceptInterface $concept) use ($conceptId) {
            return $concept->getId() === $conceptId;
        })->first();
        $this->assertNotEmpty($concept);
    }

    /**
     * @param array $data
     * @return MeshDescriptorInterface
     * @override
     */
    protected function getEntity(array $data)
    {
        /**
         * @var MeshDescriptorManagerInterface $em
         */
        $em = $this->em;
        return $em->findMeshDescriptorBy(['id' => $data[1]]);
    }
}

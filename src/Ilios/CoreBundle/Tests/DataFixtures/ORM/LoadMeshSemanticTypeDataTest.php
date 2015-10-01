<?php

namespace Ilios\CoreBundle\Tests\DataFixtures\ORM;

use Ilios\CoreBundle\Entity\Manager\MeshSemanticTypeManagerInterface;
use Ilios\CoreBundle\Entity\MeshSemanticTypeInterface;

/**
 * Class LoadMeshSemanticTypeDataTest
 * @package Ilios\CoreBundle\Tests\DataFixtures\ORM
 */
class LoadMeshSemanticTypeDataTest extends AbstractDataFixtureTest
{
    /**
     * {@inheritdoc}
     */
    public function getEntityManagerServiceKey()
    {
        return 'ilioscore.meshsemantictype.manager';
    }

    /**
     * {@inheritdoc}
     */
    public function getFixtures()
    {
        return [
          'Ilios\CoreBundle\DataFixtures\ORM\LoadMeshSemanticTypeData',
        ];
    }

    /**
     * @covers Ilios\CoreBundle\DataFixtures\ORM\LoadMeshSemanticTypeData::load
     * @group mesh_data_import
     */
    public function testLoad()
    {
        $this->runTestLoad('mesh_semantic_type.csv', 10);
    }

    /**
     * @param array $data
     * @param MeshSemanticTypeInterface $entity
     */
    protected function assertDataEquals(array $data, $entity)
    {
        // `mesh_semantic_type_uid`,`name`,`created_at`,`updated_at`
        $this->assertEquals($data[0], $entity->getId());
        $this->assertEquals($data[1], $entity->getName());
        $this->assertEquals(new \DateTime($data[2], new \DateTimeZone('UTC')), $entity->getCreatedAt());
        $this->assertEquals(new \DateTime($data[3], new \DateTimeZone('UTC')), $entity->getUpdatedAt());
    }

    /**
     * @param array $data
     * @return MeshSemanticTypeInterface
     * @override
     */
    protected function getEntity(array $data)
    {
        /**
         * @var MeshSemanticTypeManagerInterface $em
         */
        $em = $this->em;
        return $em->findMeshSemanticTypeBy(['id' => $data[0]]);
    }
}
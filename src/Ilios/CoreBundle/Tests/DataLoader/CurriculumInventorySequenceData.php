<?php

namespace Ilios\CoreBundle\Tests\DataLoader;

class CurriculumInventorySequenceData extends AbstractDataLoader
{
    protected function getData()
    {
        $arr = array();

        $arr[] = array(
            'id' => 1,
            'report' => '1',
            'description' => $this->faker->text(100),
        );

        $arr[] = array(
            'id' => 2,
            'report' => '2',
            'description' => $this->faker->text(100),
        );


        return $arr;
    }

    public function create()
    {
        return array(
            'id' => 3,
            'report' => '3',
            'description' => $this->faker->text(100),
        );
    }

    public function createInvalid()
    {
        return [];
    }
}

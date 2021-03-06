<?php

namespace Ilios\CoreBundle\Tests\DataLoader;

class ProgramData extends AbstractDataLoader
{
    protected function getData()
    {
        $arr = array();

        $arr[] = array(
            'id' => 1,
            'title' => $this->faker->title(15),
            'shortTitle' => $this->faker->title(5),
            'duration' => 4,
            'deleted' => false,
            'publishedAsTbd' => false,
            'publishEvent' => '1',
            'school' => "1",
            'programYears' => ["1", "2"],
            'curriculumInventoryReports' => ["1", "2", "3"]
        );

        $arr[] = array(
            'id' => 2,
            'title' => $this->faker->title(15),
            'shortTitle' => $this->faker->title(5),
            'duration' => 4,
            'deleted' => false,
            'publishedAsTbd' => true,
            'school' => "1",
            'programYears' => [],
            'curriculumInventoryReports' => []
        );


        return $arr;
    }

    public function create()
    {
        return array(
            'id' => 3,
            'title' => $this->faker->title(15),
            'shortTitle' => $this->faker->title(5),
            'duration' => 4,
            'deleted' => false,
            'publishedAsTbd' => true,

            'school' => "1",
            'programYears' => ['1'],
            'curriculumInventoryReports' => []
        );
    }

    public function createInvalid()
    {
        return [];
    }
}

<?php

namespace Ilios\CoreBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;

/**
 * ProgramYearSteward controller Test.
 * @package Ilios\CoreBundle\Test\Controller;
 */
class ProgramYearStewardControllerTest extends AbstractControllerTest
{
    /**
     * @return array|string
     */
    protected function getFixtures()
    {
        $fixtures = parent::getFixtures();
        return array_merge($fixtures, [
            'Ilios\CoreBundle\Tests\Fixture\LoadProgramYearStewardData',
            'Ilios\CoreBundle\Tests\Fixture\LoadDepartmentData',
            'Ilios\CoreBundle\Tests\Fixture\LoadProgramYearData',
            'Ilios\CoreBundle\Tests\Fixture\LoadSchoolData'
        ]);
    }

    /**
     * @return array|string
     */
    protected function getPrivateFields()
    {
        return [
        ];
    }

    public function testGetProgramYearSteward()
    {
        $programYearSteward = $this->container
            ->get('ilioscore.dataloader.programyearsteward')
            ->getOne()
        ;

        $this->createJsonRequest(
            'GET',
            $this->getUrl(
                'get_programyearstewards',
                ['id' => $programYearSteward['id']]
            ),
            null,
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $this->assertEquals(
            $this->mockSerialize($programYearSteward),
            json_decode($response->getContent(), true)['programYearStewards'][0]
        );
    }

    public function testGetAllProgramYearStewards()
    {
        $this->createJsonRequest(
            'GET',
            $this->getUrl('cget_programyearstewards'),
            null,
            $this->getAuthenticatedUserToken()
        );
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $this->assertEquals(
            $this->mockSerialize(
                $this->container
                    ->get('ilioscore.dataloader.programyearsteward')
                    ->getAll()
            ),
            json_decode($response->getContent(), true)['programYearStewards']
        );
    }

    public function testPostProgramYearSteward()
    {
        $data = $this->container->get('ilioscore.dataloader.programyearsteward')
            ->create();
        $postData = $data;
        //unset any parameters which should not be POSTed
        unset($postData['id']);

        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_programyearstewards'),
            json_encode(['programYearSteward' => $postData]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Codes::HTTP_CREATED, $response->getStatusCode(), $response->getContent());
        $this->assertEquals(
            $data,
            json_decode($response->getContent(), true)['programYearStewards'][0],
            $response->getContent()
        );
    }

    public function testPostBadProgramYearSteward()
    {
        $invalidProgramYearSteward = $this->container
            ->get('ilioscore.dataloader.programyearsteward')
            ->createInvalid()
        ;

        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_programyearstewards'),
            json_encode(['programYearSteward' => $invalidProgramYearSteward]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutProgramYearSteward()
    {
        $data = $this->container
            ->get('ilioscore.dataloader.programyearsteward')
            ->getOne();

        $postData = $data;
        //unset any parameters which should not be POSTed
        unset($postData['id']);

        $this->createJsonRequest(
            'PUT',
            $this->getUrl(
                'put_programyearstewards',
                ['id' => $data['id']]
            ),
            json_encode(['programYearSteward' => $postData]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $this->assertEquals(
            $this->mockSerialize($data),
            json_decode($response->getContent(), true)['programYearSteward']
        );
    }

    public function testDeleteProgramYearSteward()
    {
        $programYearSteward = $this->container
            ->get('ilioscore.dataloader.programyearsteward')
            ->getOne()
        ;

        $this->createJsonRequest(
            'DELETE',
            $this->getUrl(
                'delete_programyearstewards',
                ['id' => $programYearSteward['id']]
            ),
            null,
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->createJsonRequest(
            'GET',
            $this->getUrl(
                'get_programyearstewards',
                ['id' => $programYearSteward['id']]
            ),
            null,
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testProgramYearStewardNotFound()
    {
        $this->createJsonRequest(
            'GET',
            $this->getUrl('get_programyearstewards', ['id' => '0']),
            null,
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_NOT_FOUND);
    }
}

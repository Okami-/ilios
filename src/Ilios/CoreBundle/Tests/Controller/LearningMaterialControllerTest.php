<?php

namespace Ilios\CoreBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;
use DateTime;

/**
 * LearningMaterial controller Test.
 * @package Ilios\CoreBundle\Test\Controller;
 */
class LearningMaterialControllerTest extends AbstractControllerTest
{
    /**
     * @return array|string
     */
    protected function getFixtures()
    {
        $fixtures = parent::getFixtures();
        return array_merge($fixtures, [
            'Ilios\CoreBundle\Tests\Fixture\LoadLearningMaterialData',
            'Ilios\CoreBundle\Tests\Fixture\LoadSessionLearningMaterialData',
            'Ilios\CoreBundle\Tests\Fixture\LoadCourseLearningMaterialData'
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

    public function testGetLearningMaterial()
    {
        $learningMaterial = $this->container
            ->get('ilioscore.dataloader.learningmaterial')
            ->getOne()
        ;

        $this->createJsonRequest(
            'GET',
            $this->getUrl(
                'get_learningmaterials',
                ['id' => $learningMaterial['id']]
            ),
            null,
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $data = json_decode($response->getContent(), true)['learningMaterials'][0];
        $uploadDate = new DateTime($data['uploadDate']);
        unset($data['uploadDate']);
        $this->assertEquals(
            $this->mockSerialize($learningMaterial),
            $data
        );
        $now = new DateTime();
        $diff = $now->diff($uploadDate);
        $this->assertTrue($diff->i < 10, 'The uploadDate timestamp is within the last 10 minutes');
    }

    public function testGetAllLearningMaterials()
    {
        $this->createJsonRequest(
            'GET',
            $this->getUrl('cget_learningmaterials'),
            null,
            $this->getAuthenticatedUserToken()
        );
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $data = [];
        $responses = json_decode($response->getContent(), true)['learningMaterials'];
        $now = new DateTime();
        foreach ($responses as $response) {
            $uploadDate = new DateTime($response['uploadDate']);
            unset($response['uploadDate']);
            $diff = $now->diff($uploadDate);
            $this->assertTrue($diff->i < 10, 'The uploadDate timestamp is within the last 10 minutes');
            $data[] = $response;
        }
        $this->assertEquals(
            $this->mockSerialize(
                $this->container
                    ->get('ilioscore.dataloader.learningmaterial')
                    ->getAll()
            ),
            $data
        );
    }

    public function testPostLearningMaterial()
    {
        $data = $this->container->get('ilioscore.dataloader.learningmaterial')
            ->create();
        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_learningmaterials'),
            json_encode(['learningMaterial' => $data]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Codes::HTTP_CREATED, $response->getStatusCode(), $response->getContent());
        $responseData = json_decode($response->getContent(), true)['learningMaterials'][0];
        $uploadDate = new DateTime($responseData['uploadDate']);
        unset($responseData['id']);
        unset($responseData['uploadDate']);
        $this->assertEquals(64, strlen($responseData['token']));
        unset($responseData['token']);
        $this->assertEquals(
            $data,
            $responseData,
            $response->getContent()
        );
        $now = new DateTime();
        $diff = $now->diff($uploadDate);
        $this->assertTrue($diff->i < 10, 'The uploadDate timestamp is within the last 10 minutes');
    }

    public function testPostLearningMaterialCitation()
    {
        $data = $this->container->get('ilioscore.dataloader.learningmaterial')
          ->createCitation();
        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_learningmaterials'),
            json_encode(['learningMaterial' => $data]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Codes::HTTP_CREATED, $response->getStatusCode(), $response->getContent());
        $responseData = json_decode($response->getContent(), true)['learningMaterials'][0];
        $uploadDate = new DateTime($responseData['uploadDate']);
        unset($responseData['id']);
        unset($responseData['uploadDate']);
        unset($responseData['copyrightPermission']);
        $this->assertEquals(64, strlen($responseData['token']));
        unset($responseData['token']);
        $this->assertEquals(
            $data,
            $responseData,
            $response->getContent()
        );
        $now = new DateTime();
        $diff = $now->diff($uploadDate);
        $this->assertTrue($diff->i < 10, 'The uploadDate timestamp is within the last 10 minutes');
    }

    public function testPostLearningMaterialLink()
    {
        $data = $this->container->get('ilioscore.dataloader.learningmaterial')
          ->createLink();
        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_learningmaterials'),
            json_encode(['learningMaterial' => $data]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Codes::HTTP_CREATED, $response->getStatusCode(), $response->getContent());
        $responseData = json_decode($response->getContent(), true)['learningMaterials'][0];
        $uploadDate = new DateTime($responseData['uploadDate']);
        unset($responseData['id']);
        unset($responseData['uploadDate']);
        unset($responseData['copyrightPermission']);
        $this->assertEquals(64, strlen($responseData['token']));
        unset($responseData['token']);
        $this->assertEquals(
            $data,
            $responseData,
            $response->getContent()
        );
        $now = new DateTime();
        $diff = $now->diff($uploadDate);
        $this->assertTrue($diff->i < 10, 'The uploadDate timestamp is within the last 10 minutes');
    }

    public function testPostLearningMaterialFile()
    {
        $data = $this->container->get('ilioscore.dataloader.learningmaterial')
          ->createFile();
        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_learningmaterials'),
            json_encode(['learningMaterial' => $data]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Codes::HTTP_CREATED, $response->getStatusCode(), $response->getContent());
        $responseData = json_decode($response->getContent(), true)['learningMaterials'][0];
        $uploadDate = new DateTime($responseData['uploadDate']);
        unset($responseData['id']);
        unset($responseData['uploadDate']);
        $this->assertEquals(64, strlen($responseData['token']));
        unset($responseData['token']);
        $this->assertEquals(
            $data,
            $responseData,
            $response->getContent()
        );
        $now = new DateTime();
        $diff = $now->diff($uploadDate);
        $this->assertTrue($diff->i < 10, 'The uploadDate timestamp is within the last 10 minutes');
    }

    public function testPostBadLearningMaterial()
    {
        $invalidLearningMaterial = $this->container
            ->get('ilioscore.dataloader.learningmaterial')
            ->createInvalid()
        ;

        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_learningmaterials'),
            json_encode(['learningMaterial' => $invalidLearningMaterial]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostBadLearningMaterialCitation()
    {
        $invalidLearningMaterial = $this->container
          ->get('ilioscore.dataloader.learningmaterial')
          ->createInvalidCitation()
        ;

        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_learningmaterials'),
            json_encode(['learningMaterial' => $invalidLearningMaterial]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostBadLearningMaterialLink()
    {
        $invalidLearningMaterial = $this->container
          ->get('ilioscore.dataloader.learningmaterial')
          ->createInvalidLink()
        ;

        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_learningmaterials'),
            json_encode(['learningMaterial' => $invalidLearningMaterial]),
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutLearningMaterial()
    {
        $data = $this->container
            ->get('ilioscore.dataloader.learningmaterial')
            ->getOne();

        $postData = $data;
        //unset any parameters which should not be POSTed
        unset($postData['id']);

        $this->createJsonRequest(
            'PUT',
            $this->getUrl(
                'put_learningmaterials',
                ['id' => $data['id']]
            ),
            json_encode(['learningMaterial' => $postData]),
            $this->getAuthenticatedUserToken()
        );
        

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $responseData = json_decode($response->getContent(), true)['learningMaterial'];
        $uploadDate = new DateTime($responseData['uploadDate']);
        unset($responseData['uploadDate']);
        $this->assertEquals(
            $data,
            $responseData,
            $response->getContent()
        );
        $now = new DateTime();
        $diff = $now->diff($uploadDate);
        $this->assertTrue($diff->i < 10, 'The uploadDate timestamp is within the last 10 minutes');
    }

    public function testDeleteLearningMaterial()
    {
        $learningMaterial = $this->container
            ->get('ilioscore.dataloader.learningmaterial')
            ->getOne()
        ;

        $this->createJsonRequest(
            'DELETE',
            $this->getUrl(
                'delete_learningmaterials',
                ['id' => $learningMaterial['id']]
            ),
            null,
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->createJsonRequest(
            'GET',
            $this->getUrl(
                'get_learningmaterials',
                ['id' => $learningMaterial['id']]
            ),
            null,
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testLearningMaterialNotFound()
    {
        $this->createJsonRequest(
            'GET',
            $this->getUrl('get_learningmaterials', ['id' => '0']),
            null,
            $this->getAuthenticatedUserToken()
        );

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_NOT_FOUND);
    }
}

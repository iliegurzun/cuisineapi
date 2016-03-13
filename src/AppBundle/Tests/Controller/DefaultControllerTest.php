<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Model\Recipe;
use AppBundle\Service\AbstractRecipeService;
use AppBundle\Service\CsvDataProvider;
use AppBundle\Service\RecipeService;
use AppBundle\Tests\AbstractTest;
use Doctrine\Common\Collections\ArrayCollection;

class DefaultControllerTest extends AbstractTest
{
    private $testingData =
<<<EOT
id,created_at,updated_at,box_type,title,slug,short_title,marketing_description,calories_kcal,protein_grams,fat_grams,carbs_grams,bulletpoint1,bulletpoint2,bulletpoint3,recipe_diet_type_id,season,base,protein_source,preparation_time_minutes,shelf_life_days,equipment_needed,origin_country,recipe_cuisine,in_your_box,gousto_reference \n
1,01-01-2016,01-01-2016,,foo title,foo-title,,,,,,,,,,,,,,,,,,,,
EOT;
    public function setUp()
    {
        parent::setUp();
        $dataProvider = $this->mockCsvDataProvider();
        $dataProvider->setSerializer($this->container->get('jms_serializer'));
        $this->container->set(CsvDataProvider::SERVICE_NAME, $dataProvider);
        $service = $this->container->get(RecipeService::SERVICE_NAME);
        $service->setDataProvider($dataProvider);
        $this->container->set(RecipeService::SERVICE_NAME, $service);
        file_put_contents('web/testingdata.csv', $this->testingData);
    }

    public function testFindAction()
    {
        $this->client->request(
            'get',
            '/api/1/find.json'
        );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(
            '{"id":1,"created_at":"01\/01\/2016 00:00:00","updated_at":"01\/01\/2016 00:00:00","title":"foobar","recipe_cuisine":"italian"}',
            $this->client->getResponse()->getContent()
        );
    }

    public function testFindRecipesAction()
    {
        $this->client->request(
            'post',
            '/api/recipes/romanian/find.json',
            array(
                'offset'    => 0,
                'limit'     => 1
            )
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(
            '[{"id":2,"created_at":"01\/01\/2016 00:00:00","updated_at":"01\/01\/2016 00:00:00","title":"foo bar recipe","recipe_cuisine":"romanian"}]',
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateRecipeAction()
    {
        $this->client->request(
            'post',
            '/api/recipes/create.json',
            array(
                'recipe'    => array(
                    'title' => 'foo bar recipe created'
                )
            )
        );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertNotEmpty($this->client->getResponse()->getContent());
    }

    public function testUpdateRecipeAction()
    {
        $this->client->request(
            'patch',
            '/api/recipes/1/update.json',
            array(
                'recipe'    => array(
                    'title' => 'foo bar recipe updated'
                )
            )
        );
        $this->assertNotEmpty($this->client->getResponse()->getContent());
        $recipeData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(
            'foo bar recipe updated',
            $recipeData['title']
        );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testRateRecipeAction()
    {
        $this->client->request(
            'post',
            '/api/recipes/1/rate.json',
            array(
                'rating'    => array(
                    'score' => 12
                )
            )
        );
        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
        $this->assertContains('This value should be 5 or less', $this->client->getResponse()->getContent());
    }

    protected function mockCsvDataProvider()
    {
        $recipe1 = new Recipe();
        $recipe1
            ->setId(1)
            ->setRecipeCuisine('italian')
            ->setTitle('foobar')
            ->setCreatedAt(new \DateTime('01-01-2016 00:00:00'))
            ->setUpdatedAt(new \DateTime('01-01-2016 00:00:00'));
        $mockData[] = $recipe1;
        $recipe2 = new Recipe();
        $recipe2
            ->setId(2)
            ->setRecipeCuisine('romanian')
            ->setTitle('foo bar recipe')
            ->setCreatedAt(new \DateTime('01-01-2016 00:00:00'))
            ->setUpdatedAt(new \DateTime('01-01-2016 00:00:00'));
        $mockData[] = $recipe2;
        $mock = $this->getMockBuilder(CsvDataProvider::class)
            ->setMethods(array(
                'init',
                'getData',
                'getHeader',
                'saveRecipe',
                'getFilename'
            ))
            ->getMock();
        $mock->expects($this->any())
            ->method('init')
            ->will($this->returnValue(null));
        $mock->expects($this->any())
            ->method('getData')
            ->will($this->returnValue(new ArrayCollection($mockData)));
        $mock->expects($this->any())
            ->method('saveRecipe')
            ->will($this->returnValue(true));
        $mock->expects($this->any())
            ->method('getFilename')
            ->will($this->returnValue('web/testingdata.csv'));
        $mock->expects($this->any())
            ->method('getHeader')
            ->will($this->returnValue(
                json_decode(
                    '["id","created_at","updated_at","box_type","title","slug","short_title","marketing_description","calories_kcal","protein_grams","fat_grams","carbs_grams","bulletpoint1","bulletpoint2","bulletpoint3","recipe_diet_type_id","season","base","protein_source","preparation_time_minutes","shelf_life_days","equipment_needed","origin_country","recipe_cuisine","in_your_box","gousto_reference"]',
                    true
                )
            ));
        return $mock;
    }
}

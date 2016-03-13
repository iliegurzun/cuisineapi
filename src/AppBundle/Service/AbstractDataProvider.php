<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 11/3/2016
 * Time: 4:00 PM
 */

namespace AppBundle\Service;


use AppBundle\Model\Rating;
use AppBundle\Model\Recipe;
use JMS\Serializer\Serializer;

abstract class AbstractDataProvider
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @param Serializer $serializer
     * @return AbstractDataProvider
     */
    public function setSerializer($serializer)
    {
        $this->serializer = $serializer;

        return $this;
    }

    abstract public function getRecipeById($id);

    abstract public function getRecipes($key = null, $value = null);

    abstract public function addRecipe(Recipe $recipe);

    abstract public function rateRecipe(Rating $rating);

    abstract public function updateRecipe(Recipe $recipe);
}
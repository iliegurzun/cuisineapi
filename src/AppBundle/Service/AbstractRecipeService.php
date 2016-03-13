<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 11/3/2016
 * Time: 4:00 PM
 */

namespace AppBundle\Service;

use AppBundle\Model\Recipe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractRecipeService
{
    /** @const string */
    const ID_FIELD = 'id';

    /** @const string */
    const CUISINE_FIELD = 'recipeCuisine';

    /** @const string */
    const KEY = 'key';

    /** @const string */
    const VALUE = 'value';

    /** @const string */
    const OFFSET = 'offset';

    /** @const string */
    const LIMIT = 'limit';

    /** @var  AbstractDataProvider */
    protected $dataProvider;

    /**
     * @return AbstractDataProvider
     */
    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    /**
     * @param AbstractDataProvider $dataProvider
     * @return AbstractRecipeService
     */
    public function setDataProvider(AbstractDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;

        return $this;
    }

    /**
     * @param string $key
     * @param string|int $value
     * @return array|Recipe[]
     */
    public function find($key, $value)
    {
        $recipes = $this->getDataProvider()->getRecipes($key, $value);

        return $recipes;
    }

    /**
     * @param int $id
     * @return Recipe
     */
    public function findById($id)
    {
        $recipe = $this->getDataProvider()->getRecipeById($id);
        if (!$recipe instanceof Recipe) {
            throw new NotFoundHttpException(sprintf('Recipe with id %s does not exist!', $id));
        }

        return $recipe;
    }

    /**
     * @param Recipe $recipe
     */
    public function saveRecipe(Recipe $recipe)
    {
        $this->getDataProvider()->addRecipe($recipe);
    }

    /**
     * @param Recipe $recipe
     */
    public function updateRecipe(Recipe $recipe)
    {
        $this->getDataProvider()->updateRecipe($recipe);
    }
}
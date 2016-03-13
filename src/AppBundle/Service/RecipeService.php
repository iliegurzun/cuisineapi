<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 11/3/2016
 * Time: 4:00 PM
 */

namespace AppBundle\Service;

use AppBundle\Model\Recipe;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipeService extends AbstractRecipeService
{
    /** @const string */
    const SERVICE_NAME = 'app.recipe_service';

    /**
     * @param array $params
     * @return ArrayCollection
     */
    public function findPaginated($params)
    {
        /** @var ArrayCollection $recipes */
        $recipes = $this->getDataProvider()->getRecipes($params[self::KEY], $params[self::VALUE]);
        $recipes = $recipes->slice($params[self::OFFSET], $params[self::LIMIT]);

        return $recipes;
    }
}
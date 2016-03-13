<?php

namespace AppBundle\Controller;

use AppBundle\Form\RecipeType;
use AppBundle\Model\Recipe;
use AppBundle\Service\RecipeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Rest\Get
     */
    public function findAction($id)
    {
        /** @var RecipeService $service */
        $service = $this->get(RecipeService::SERVICE_NAME);
        $recipe = $service->findById($id);

        return $recipe;
    }

    /**
     * @param string  $cuisine
     * @param Request $request
     * @return array|Recipe[]
     * @Rest\Post
     */
    public function findByCuisineAction($cuisine, Request $request)
    {
        /** @var RecipeService $service */
        $service = $this->get(RecipeService::SERVICE_NAME);
        $recipes = $service->findPaginated(array(
            RecipeService::KEY      => RecipeService::CUISINE_FIELD,
            RecipeService::VALUE    => $cuisine,
            RecipeService::OFFSET   => $request->get(RecipeService::OFFSET, 0),
            RecipeService::LIMIT    => $request->get(RecipeService::LIMIT, 5)
        ));

        return $recipes;
    }

    /**
     * @param Request $request
     * @return Recipe|\Symfony\Component\Form\Form
     * @Rest\Post
     */
    public function createRecipeAction(Request $request)
    {
        /** @var RecipeService $service */
        $service = $this->get(RecipeService::SERVICE_NAME);
        $recipe = new Recipe();
        $form = $this->createForm(new RecipeType(), $recipe);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $service->saveRecipe($recipe);

            return $recipe;
        }

        return $form;
    }

    /**
     * @param int     $id
     * @param Request $request
     * @return Recipe|\Symfony\Component\Form\Form
     * @Rest\Post
     */
    public function updateRecipeAction($id, Request $request)
    {
        /** @var RecipeService $service */
        $service = $this->get(RecipeService::SERVICE_NAME);
        $recipe = $service->findById($id);
        if (!$recipe instanceof Recipe) {
            throw $this->createNotFoundException(sprintf('Recipe with id "%s" does not exist!', $id));
        }
        $form = $this->createForm(new RecipeType(), $recipe);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $service->updateRecipe($recipe);

            return $recipe;
        }

        return $form;
    }

    public function rateRecipeAction($id)
    {

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 11/3/2016
 * Time: 5:59 PM
 */

namespace AppBundle\Model;


class Rating
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Recipe
     */
    protected $recipe;

    /**
     * @var int
     */
    protected $score;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Rating
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @param Recipe $recipe
     * @return Rating
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param int $score
     * @return Rating
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }
}
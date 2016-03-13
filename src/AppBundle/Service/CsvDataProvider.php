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

class CsvDataProvider extends AbstractDataProvider
{
    /** @var string */
    const ID_FIELD = 'id';

    /** @var string */
    protected $filename;

    /** @var ArrayCollection */
    protected $data;

    /** @var array */
    protected $header;

    /** @var int */
    protected $lastId;

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     * @return CsvDataProvider
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function init()
    {
        $file = realpath($this->filename);
        if (false === $file) {
            throw new NotFoundHttpException(sprintf('The file "%s" does not exist!', $this->filename));
        }
        $allRows = array();
        $handle = fopen($file, 'r');
        while ($row = fgetcsv($handle)) {
            if (null === $this->header) {
                $this->header = $row;
                continue;
            }
            $data = array_combine($this->header, $row);
            $this->lastId = $data[self::ID_FIELD];
            $allRows[] = $this->getSerializer()->deserialize(
                $this->getSerializer()->serialize($data, 'json'),
                'AppBundle\Model\Recipe',
                'json'
            );
        }
        fclose($handle);
        $this->data = new ArrayCollection($allRows);
    }

    public function getRecipeById($id)
    {
        $recipe = $this->data->filter(function (Recipe $item) use ($id) {
            return $item->getId() == $id;
        });

        return $recipe->first();
    }

    public function getRecipes($key = null, $value = null)
    {
        $recipes = $this->data->filter(function (Recipe $item) use ($key, $value) {
            $getter = 'get' . ucwords($key);
            return $item->$getter() == $value;
        });

        return new ArrayCollection($recipes->toArray());
    }

    /**
     * @param Recipe $recipe
     * @return Recipe
     */
    public function addRecipe(Recipe $recipe)
    {
        $recipe->setId($this->lastId + 1);
        $slug = preg_replace('~[^\pL\d]+~u', '-', $recipe->getTitle()) . '-' . time();
        $recipe->setSlug($slug);
        $data = $this->getSerializer()->deserialize(
            $this->getSerializer()->serialize($recipe, 'json'),
            'array',
            'json'
        );
        $combined = array();
        foreach ($this->header as $index => $key) {
            $combined[$key] = isset($data[$key]) ? $data[$key] : null;
        }
        $file = realpath($this->filename);
        $handle = fopen($file, 'a');
        fputcsv($handle, $combined);
        fclose($handle);

        return $recipe;
    }

    public function updateRecipe(Recipe $recipe)
    {
        $file = realpath($this->filename);
        $handle = fopen($file, 'w');
        fputcsv($handle, $this->header);
        foreach ($this->data as $item) {
            if ($item->getId() == $recipe->getId()) {
                $slug = preg_replace('~[^\pL\d]+~u', '-', $recipe->getTitle()) . '-' . time();
                $recipe->setSlug($slug);
                $recipe->setUpdatedAt(new \DateTime());
                $item = $recipe;
            }
            $data = $this->getSerializer()->deserialize(
                $this->getSerializer()->serialize($item, 'json'),
                'array',
                'json'
            );
            $combined = array();
            foreach ($this->header as $index => $key) {
                $combined[$key] = isset($data[$key]) ? $data[$key] : null;
            }
            fputcsv($handle, $combined);
        }
        fclose($handle);

        return $recipe;
    }

    public function rateRecipe(Recipe $recipe, $score)
    {
        // TODO: Implement rateRecipe() method.
    }
}
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
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CsvDataProvider extends AbstractDataProvider
{
    /** @var string */
    const SERVICE_NAME = 'app.csv_data_provider';

    /** @var string */
    const ID_FIELD = 'id';

    /** @var string */
    protected $filename;

    protected $ratingFilename;

    /** @var ArrayCollection */
    protected $data;

    /** @var array */
    protected $header;

    /** @var int */
    protected $lastId;

    public function init()
    {
        $file = realpath($this->filename);
        if (false === $file) {
            throw new NotFoundHttpException(sprintf('The file "%s" does not exist!', $this->filename));
        }
        $allRows = array();
        $handle = fopen($file, 'r');
        while ($row = fgetcsv($handle)) {
            if (null === $this->getHeader()) {
                $this->setHeader($row);
                continue;
            }
            $data = array_combine($this->getHeader(), $row);
            $this->lastId = $data[self::ID_FIELD];
            $allRows[] = $this->getSerializer()->deserialize(
                $this->getSerializer()->serialize($data, 'json'),
                'AppBundle\Model\Recipe',
                'json'
            );
        }
        fclose($handle);
        $this->setData(new ArrayCollection($allRows));
    }

    public function getRecipeById($id)
    {
        $recipe = $this->getData()->filter(function (Recipe $item) use ($id) {
            return $item->getId() == $id;
        });

        return $recipe->first();
    }

    public function getRecipes($key = null, $value = null)
    {
        $recipes = $this->getData()->filter(function (Recipe $item) use ($key, $value) {
            $getter = 'get' . ucwords($key);
            return $item->$getter() == $value;
        });

        return new ArrayCollection(array_values($recipes->toArray()));
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
        foreach ($this->getHeader() as $index => $key) {
            $combined[$key] = isset($data[$key]) ? $data[$key] : null;
        }
        $this->saveRecipe($combined);

        return $recipe;
    }

    public function saveRecipe(array $recipeData)
    {
        $file = realpath($this->getFilename());
        $handle = fopen($file, 'a');
        fputcsv($handle, $recipeData);
        fclose($handle);
    }

    public function updateRecipe(Recipe $recipe)
    {
        $file = realpath($this->getFilename());
        $handle = fopen($file, 'w');
        fputcsv($handle, $this->getHeader());
        foreach ($this->getData() as $item) {
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
            foreach ($this->getHeader() as $index => $key) {
                $combined[$key] = isset($data[$key]) ? $data[$key] : null;
            }
            fputcsv($handle, $combined);
        }
        fclose($handle);

        return $recipe;
    }

    public function rateRecipe(Rating $rating)
    {
        $filename = $this->getRatingFilename();
        $ratingFile = realpath($filename);
        if (false === $ratingFile) {
            $headers = array(
                'recipe_id',
                'score'
            );
            $header = implode($headers, ',') . "\n";
            file_put_contents($filename, $header);
        }
        $handle = fopen($filename, 'a');
        fputcsv($handle, array($rating->getRecipe()->getId(), $rating->getScore()));
        fclose($handle);
    }

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

    /**
     * @return mixed
     */
    public function getRatingFilename()
    {
        return $this->ratingFilename;
    }

    /**
     * @param mixed $ratingFilename
     * @return CsvDataProvider
     */
    public function setRatingFilename($ratingFilename)
    {
        $this->ratingFilename = $ratingFilename;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param ArrayCollection $data
     * @return CsvDataProvider
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param array $header
     * @return CsvDataProvider
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 11/3/2016
 * Time: 5:41 PM
 */

namespace AppBundle\Model;

use JMS\Serializer\Annotation\Type;

class Recipe
{
    /**
     * @var int
     * @Type("integer")
     */
    protected $id;

    /**
     * @var \DateTime
     * @Type("DateTime<'d/m/Y H:i:s'>")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Type("DateTime<'d/m/Y H:i:s'>")
     */
    protected $updatedAt;

    /**
     * @var string
     * @Type("string")
     */
    protected $boxType;

    /**
     * @var string
     * @Type("string")
     */
    protected $title;

    /**
     * @var string
     * @Type("string")
     */
    protected $slug;

    /**
     * @var string
     * @Type("string")
     */
    protected $shortTitle;

    /**
     * @var text
     * @Type("string")
     */
    protected $marketingDescription;

    /**
     * @var integer
     * @Type("integer")
     */
    protected $caloriesKcal;

    /**
     * @var integer
     * @Type("integer")
     */
    protected $proteinGrams;

    /**
     * @var integer
     * @Type("integer")
     */
    protected $fatGrams;

    /**
     * @var int
     * @Type("integer")
     */
    protected $carbsGrams;

    /**
     * @var string
     * @Type("string")
     */
    protected $bulletPoint1;

    /**
     * @var string
     * @Type("string")
     */
    protected $bulletPoint2;

    /**
     * @var string
     * @Type("string")
     */
    protected $bulletPoint3;

    /**
     * @var string
     * @Type("string")
     */
    protected $recipeDietTypeId;

    /**
     * @var string
     * @Type("string")
     */
    protected $season;

    /**
     * @var string
     * @Type("string")
     */
    protected $base;

    /**
     * @var string
     * @Type("string")
     */
    protected $proteinSource;

    /**
     * @var int
     * @Type("integer")
     */
    protected $preparationTimeMinutes;

    /**
     * @var int
     * @Type("integer")
     */
    protected $shelfLifeDays;

    /**
     * @var string
     * @Type("string")
     */
    protected $equipmentNeeded;

    /**
     * @var string
     * @Type("string")
     */
    protected $originCountry;

    /**
     * @var string
     * @Type("string")
     */
    protected $recipeCuisine;

    /**
     * @var string
     * @Type("string")
     */
    protected $inYourBox;

    /**
     * @var integer
     * @Type("integer")
     */
    protected $goustoReference;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        if (!$this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime());
        }
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @param int $id
     * @return Recipe
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Recipe
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Recipe
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getBoxType()
    {
        return $this->boxType;
    }

    /**
     * @param string $boxType
     * @return Recipe
     */
    public function setBoxType($boxType)
    {
        $this->boxType = $boxType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Recipe
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Recipe
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    /**
     * @param string $shortTitle
     * @return Recipe
     */
    public function setShortTitle($shortTitle)
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    /**
     * @return text
     */
    public function getMarketingDescription()
    {
        return $this->marketingDescription;
    }

    /**
     * @param text $marketingDescription
     * @return Recipe
     */
    public function setMarketingDescription($marketingDescription)
    {
        $this->marketingDescription = $marketingDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getCaloriesKcal()
    {
        return $this->caloriesKcal;
    }

    /**
     * @param string $caloriesKcal
     * @return Recipe
     */
    public function setCaloriesKcal($caloriesKcal)
    {
        $this->caloriesKcal = $caloriesKcal;

        return $this;
    }

    /**
     * @return string
     */
    public function getProteinGrams()
    {
        return $this->proteinGrams;
    }

    /**
     * @param string $proteinGrams
     * @return Recipe
     */
    public function setProteinGrams($proteinGrams)
    {
        $this->proteinGrams = $proteinGrams;

        return $this;
    }

    /**
     * @return string
     */
    public function getFatGrams()
    {
        return $this->fatGrams;
    }

    /**
     * @param string $fatGrams
     * @return Recipe
     */
    public function setFatGrams($fatGrams)
    {
        $this->fatGrams = $fatGrams;

        return $this;
    }

    /**
     * @return int
     */
    public function getCarbsGrams()
    {
        return $this->carbsGrams;
    }

    /**
     * @param int $carbsGrams
     * @return Recipe
     */
    public function setCarbsGrams($carbsGrams)
    {
        $this->carbsGrams = $carbsGrams;

        return $this;
    }

    /**
     * @return string
     */
    public function getRecipeDietTypeId()
    {
        return $this->recipeDietTypeId;
    }

    /**
     * @param string $recipeDietTypeId
     * @return Recipe
     */
    public function setRecipeDietTypeId($recipeDietTypeId)
    {
        $this->recipeDietTypeId = $recipeDietTypeId;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param string $season
     * @return Recipe
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param string $base
     * @return Recipe
     */
    public function setBase($base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * @return string
     */
    public function getProteinSource()
    {
        return $this->proteinSource;
    }

    /**
     * @param string $proteinSource
     * @return Recipe
     */
    public function setProteinSource($proteinSource)
    {
        $this->proteinSource = $proteinSource;

        return $this;
    }

    /**
     * @return string
     */
    public function getPreparationTimeMinutes()
    {
        return $this->preparationTimeMinutes;
    }

    /**
     * @param string $preparationTimeMinutes
     * @return Recipe
     */
    public function setPreparationTimeMinutes($preparationTimeMinutes)
    {
        $this->preparationTimeMinutes = $preparationTimeMinutes;

        return $this;
    }

    /**
     * @return string
     */
    public function getShelfLifeDays()
    {
        return $this->shelfLifeDays;
    }

    /**
     * @param string $shelfLifeDays
     * @return Recipe
     */
    public function setShelfLifeDays($shelfLifeDays)
    {
        $this->shelfLifeDays = $shelfLifeDays;

        return $this;
    }

    /**
     * @return string
     */
    public function getEquipmentNeeded()
    {
        return $this->equipmentNeeded;
    }

    /**
     * @param string $equipmentNeeded
     * @return Recipe
     */
    public function setEquipmentNeeded($equipmentNeeded)
    {
        $this->equipmentNeeded = $equipmentNeeded;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginCountry()
    {
        return $this->originCountry;
    }

    /**
     * @param string $originCountry
     * @return Recipe
     */
    public function setOriginCountry($originCountry)
    {
        $this->originCountry = $originCountry;

        return $this;
    }

    /**
     * @return string
     */
    public function getRecipeCuisine()
    {
        return $this->recipeCuisine;
    }

    /**
     * @param string $recipeCuisine
     * @return Recipe
     */
    public function setRecipeCuisine($recipeCuisine)
    {
        $this->recipeCuisine = $recipeCuisine;

        return $this;
    }

    /**
     * @return string
     */
    public function getInYourBox()
    {
        return $this->inYourBox;
    }

    /**
     * @param string $inYourBox
     * @return Recipe
     */
    public function setInYourBox($inYourBox)
    {
        $this->inYourBox = $inYourBox;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoustoReference()
    {
        return $this->goustoReference;
    }

    /**
     * @param string $goustoReference
     * @return Recipe
     */
    public function setGoustoReference($goustoReference)
    {
        $this->goustoReference = $goustoReference;

        return $this;
    }

    /**
     * @return string
     */
    public function getBulletPoint1()
    {
        return $this->bulletPoint1;
    }

    /**
     * @param string $bulletPoint1
     * @return Recipe
     */
    public function setBulletPoint1($bulletPoint1)
    {
        $this->bulletPoint1 = $bulletPoint1;

        return $this;
    }

    /**
     * @return string
     */
    public function getBulletPoint2()
    {
        return $this->bulletPoint2;
    }

    /**
     * @param string $bulletPoint2
     * @return Recipe
     */
    public function setBulletPoint2($bulletPoint2)
    {
        $this->bulletPoint2 = $bulletPoint2;

        return $this;
    }

    /**
     * @return string
     */
    public function getBulletPoint3()
    {
        return $this->bulletPoint3;
    }

    /**
     * @param string $bulletPoint3
     * @return Recipe
     */
    public function setBulletPoint3($bulletPoint3)
    {
        $this->bulletPoint3 = $bulletPoint3;

        return $this;
    }
}
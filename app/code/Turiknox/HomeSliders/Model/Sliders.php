<?php
namespace Turiknox\HomeSliders\Model;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Turiknox\HomeSliders\Api\Data\SlidersInterface;

class Sliders extends AbstractModel
    implements SlidersInterface
{

    /**
     * Cache tag
     */
    const CACHE_TAG = 'turiknox_homesliders_sliders';

    /**
     * filter model
     *
     * @var \Magento\Framework\Filter\FilterManager
     */
    protected $filter;

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * Sliders constructor.
     * @param Context $context
     * @param Registry $registry
     * @param UploaderPool $uploaderPool
     * @param FilterManager $filter
     * @param array $optionProviders
     * @param array $data
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     */
    public function __construct(
        Context $context,
        Registry $registry,
        UploaderPool $uploaderPool,
        FilterManager $filter,
        array $optionProviders = [],
        array $data = [],
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->uploaderPool    = $uploaderPool;
        $this->filter          = $filter;
        $this->optionProviders = $optionProviders;
    }


    /**
     * Initialise resource model
     */
    protected function _construct()
    {
        $this->_init('Turiknox\HomeSliders\Model\ResourceModel\Sliders');
    }

    /**
     * Get cache identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(SlidersInterface::TITLE);
    }

    /**
     * Set title
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData(SlidersInterface::TITLE, $title);
    }

    /**
     * Get slider image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getData(SlidersInterface::IMAGE);
    }

    /**
     * Get slidr image URL
     *
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getImage();
        if ($image) {
            if (is_string($image)) {
                $uploader = $this->uploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$image;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * Set image
     *
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(SlidersInterface::IMAGE, $image);
    }

    /**
     * Get slider image label
     *
     * @return string
     */
    public function getImageLabel()
    {
        return $this->getData(SlidersInterface::IMAGE_LABEL);
    }

    /**
     * Set slider image label
     *
     * @param $imageLabel
     * @return $this
     */
    public function setImageLabel($imageLabel)
    {
        return $this->setData(SlidersInterface::IMAGE_LABEL, $imageLabel);
    }

    /**
     * Get slider URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getData(SlidersInterface::URL);
    }

    /**
     * Set slider URL
     *
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        return $this->setData(SlidersInterface::URL, $url);
    }

    /**
     * Get slider HTML
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->getData(SlidersInterface::HTML);
    }

    /**
     * Set slider HTML
     *
     * @param $html
     * @return $this
     */
    public function setHtml($html)
    {
        return $this->setData(SlidersInterface::HTML, $html);
    }

    /**
     * Get slider sort order
     *
     * @return string
     */
    public function getSortOrder()
    {
        return $this->getData(SlidersInterface::SORT_ORDER);
    }

    /**
     * Set slider sort order
     *
     * @param $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(SlidersInterface::SORT_ORDER, $sortOrder);
    }

    /**
     * Get is enabled
     *
     * @return bool|int
     */
    public function getIsEnabled()
    {
        return $this->getData(SlidersInterface::IS_ENABLED);
    }

    /**
     * Set is enabled
     *
     * @param $isEnabled
     * @return $this
     */
    public function setIsEnabled($isEnabled)
    {
        return $this->setData(SlidersInterface::IS_ENABLED, $isEnabled);
    }
}
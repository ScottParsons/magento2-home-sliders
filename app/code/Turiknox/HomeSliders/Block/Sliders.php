<?php
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\HomeSliders\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Turiknox\HomeSliders\Model\SlidersFactory;
use Turiknox\HomeSliders\Model\UploaderPool;

class Sliders extends Template
{
    const XML_PATH_SLIDERS_ENABLE    = 'homesliders/general/enable';
    const XML_PATH_SLIDERS_AUTOMATE  = 'homesliders/general/automate';
    const XML_PATH_SLIDERS_SPEED     = 'homesliders/general/speed';
    const XML_PATH_SLIDERS_DIRECTION = 'homesliders/general/direction';
    const XML_PATH_SLIDERS_CONTROL   = 'homesliders/general/paging';
    const XML_PATH_SLIDERS_PAUSE     = 'homesliders/general/pause';
    const XML_PATH_SLIDERS_LINK      = 'homesliders/general/link';

    /**
     * @var SlidersFactory
     */
    protected $slidersFactory;

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * Sliders constructor.
     *
     * @param Context $context
     * @param SlidersFactory $slidersFactory
     * @param UploaderPool $uploaderPool
     * @param array $data
     */
    public function __construct(
        Context $context,
        SlidersFactory $slidersFactory,
        UploaderPool $uploaderPool,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->slidersFactory = $slidersFactory;
        $this->uploaderPool = $uploaderPool;
    }

    /**
     * Check the module is enabled in the admin
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_SLIDERS_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the sliders should be automated
     *
     * @return bool
     */
    public function getSlideshow()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_SLIDERS_AUTOMATE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the slideshow speed
     *
     * @return mixed
     */
    public function getSlideshowSpeed()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_SLIDERS_SPEED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the directional navigation should be shown
     *
     * @return bool
     */
    public function getDirectionNav()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_SLIDERS_DIRECTION, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the control navigation should be shown
     *
     * @return bool
     */
    public function getControlNav()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_SLIDERS_CONTROL, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the slideshow should be paused on hover
     *
     * @return bool
     */
    public function getPauseOnHover()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_SLIDERS_PAUSE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the slider URLs should be opened in a separate tab
     *
     * @return bool
     */
    public function getLinkTarget()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_SLIDERS_LINK, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Retrieve the sliders collection
     *
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function getSlidersCollection()
    {
        return $this->slidersFactory->create()->getCollection()
            ->addFieldToFilter('is_enabled', 1)
            ->setOrder('sort_order', 'ASC');
    }

    /**
     * Get the slider image URL
     *
     * @param $image
     * @return bool|string
     */
    public function getImageUrl($image)
    {
        $url = '';
        if ($image) {
            if (is_string($image)) {
                $uploader = $this->uploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$image;
            }
        }
        return $url;
    }
}

<?php
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\HomeSliders\Ui\DataProvider\Sliders\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Turiknox\HomeSliders\Model\ResourceModel\Sliders\CollectionFactory;

class SliderData implements ModifierInterface
{
    /**
     * @var \Turiknox\HomeSliders\Model\ResourceModel\Sliders\Collection
     */
    protected $collection;

    /**
     * @param CollectionFactory $sliderCollectionFactory
     */
    public function __construct(
        CollectionFactory $sliderCollectionFactory
    ) {
        $this->collection = $sliderCollectionFactory->create();
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    /**
     * @param array $data
     * @return array|mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function modifyData(array $data)
    {
        $items = $this->collection->getItems();
        /** @var $slider \Turiknox\HomeSliders\Model\Sliders */
        foreach ($items as $slider) {
            $_data = $slider->getData();
            if (isset($_data['image'])) {
                $image = [];
                $image[0]['name'] = $slider->getImage();
                $image[0]['url'] = $slider->getImageUrl();
                $_data['image'] = $image;
            }
            $slider->setData($_data);
            $data[$slider->getId()] = $_data;
        }
        return $data;
    }
}

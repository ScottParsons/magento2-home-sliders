<?php
namespace Turiknox\HomeSliders\Controller\Adminhtml\Sliders;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Turiknox\HomeSliders\Model\Sliders;

class MassDisable extends MassAction
{
    /**
     * @var bool
     */
    protected $_isEnabled = false;

    /**
     * @param Sliders $slider
     * @return $this
     */
    protected function massAction(Sliders $slider)
    {
        $slider->setIsEnabled($this->_isEnabled);
        $this->_sliderRepository->save($slider);
        return $this;
    }
}
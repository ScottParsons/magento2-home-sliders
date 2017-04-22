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

class MassDelete extends MassAction
{
    /**
     * @param Sliders $slider
     * @return $this
     */
    protected function massAction(Sliders $slider)
    {
        $this->_sliderRepository->delete($slider);
        return $this;
    }
}

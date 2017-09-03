<?php
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\HomeSliders\Controller\Adminhtml\Sliders;

use Turiknox\HomeSliders\Model\Sliders;

class MassDisable extends MassAction
{
    /**
     * @var bool
     */
    protected $isEnabled = false;

    /**
     * @param Sliders $slider
     * @return $this
     */
    protected function massAction(Sliders $slider)
    {
        $slider->setIsEnabled($this->isEnabled);
        $this->sliderRepository->save($slider);
        return $this;
    }
}

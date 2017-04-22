<?php
namespace Turiknox\HomeSliders\Model\ResourceModel;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Sliders extends AbstractDb
{
    /**
     * Resource initialisation
     */
    protected function _construct()
    {
        $this->_init('turiknox_homesliders_sliders', 'slider_id');
    }
}
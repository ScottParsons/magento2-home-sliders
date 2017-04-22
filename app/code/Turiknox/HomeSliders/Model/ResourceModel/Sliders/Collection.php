<?php
namespace Turiknox\HomeSliders\Model\ResourceModel\Sliders;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'slider_id';

    /**
     * Collection initialisation
     */
    protected function _construct()
    {
        $this->_init('Turiknox\HomeSliders\Model\Sliders','Turiknox\HomeSliders\Model\ResourceModel\Sliders');
    }
}
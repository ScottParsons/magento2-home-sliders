<?php
namespace Turiknox\HomeSliders\Api\Data;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Framework\Api\SearchResultsInterface;

interface SlidersSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get sliders list.
     *
     * @return \Turiknox\HomeSliders\Api\Data\SlidersInterface[]
     */
    public function getItems();

    /**
     * Set sliders list.
     *
     * @param \Turiknox\HomeSliders\Api\Data\SlidersInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
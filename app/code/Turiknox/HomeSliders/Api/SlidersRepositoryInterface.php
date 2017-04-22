<?php
namespace Turiknox\HomeSliders\Api;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Framework\Api\SearchCriteriaInterface;
use Turiknox\HomeSliders\Api\Data\SlidersInterface;

interface SlidersRepositoryInterface
{
    /**
     * Save Slider.
     *
     * @param SlidersInterface $slider
     * @return SlidersInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(SlidersInterface $slider);

    /**
     * Retrieve Slider.
     *
     * @param int $sliderId
     * @return SlidersInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sliderId);

    /**
     * Retrieve Sliders matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Turiknox\HomeSliders\Api\Data\SlidersSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Slider.
     *
     * @param SlidersInterface $slider
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(SlidersInterface $slider);

    /**
     * Delete Slider by ID.
     *
     * @param int $sliderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($sliderId);
}
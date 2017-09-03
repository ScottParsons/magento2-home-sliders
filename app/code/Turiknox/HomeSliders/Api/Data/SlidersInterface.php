<?php
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\HomeSliders\Api\Data;

interface SlidersInterface
{
    /**
     * Constants for keys of data array
     */
    const SLIDER_ID   = 'slider_id';
    const TITLE       = 'title';
    const IMAGE       = 'image';
    const IMAGE_LABEL = 'image_label';
    const URL         = 'url';
    const HTML        = 'html';
    const SORT_ORDER  = 'sort_order';
    const IS_ENABLED  = 'is_enabled';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param $id
     * @return SlidersInterface
     */
    public function setId($id);

    /**
     * Get Slider Title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set Slider Title
     *
     * @param $title
     * @return mixed
     */
    public function setTitle($title);

    /**
     * Get Slider Image
     *
     * @return mixed
     */
    public function getImage();

    /**
     * Set Data Description
     *
     * @param $image
     * @return mixed
     */
    public function setImage($image);

    /**
     * Get Slider Image label
     *
     * @return mixed
     */
    public function getImageLabel();

    /**
     * Set Slider Image label
     *
     * @param $imageLabel
     * @return mixed
     */
    public function setImageLabel($imageLabel);

    /**
     * Get Slider URL
     *
     * @return mixed
     */
    public function getUrl();

    /**
     * Set Slider URL
     *
     * @param $url
     * @return mixed
     */
    public function setUrl($url);

    /**
     * Get Slider HTML
     *
     * @return mixed
     */
    public function getHtml();

    /**
     * Set Slider HTML
     *
     * @param $html
     * @return mixed
     */
    public function setHtml($html);

    /**
     * Get Slider sort order
     *
     * @return mixed
     */
    public function getSortOrder();

    /**
     * Set Slider sort order
     *
     * @param $sortOrder
     * @return mixed
     */
    public function setSortOrder($sortOrder);

    /**
     * Get is enabled
     *
     * @return bool|int
     */
    public function getIsEnabled();

    /**
     * Set is enabled
     *
     * @param $isEnabled
     * @return SlidersInterface
     */
    public function setIsEnabled($isEnabled);
}

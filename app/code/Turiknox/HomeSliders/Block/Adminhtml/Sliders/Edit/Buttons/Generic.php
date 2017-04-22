<?php
namespace Turiknox\HomeSliders\Block\Adminhtml\Sliders\Edit\Buttons;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Turiknox\HomeSliders\Api\SlidersRepositoryInterface;

class Generic
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var SlidersRepositoryInterface
     */
    protected $slidersRepository;

    /**
     * @param Context $context
     * @param SlidersRepositoryInterface $slidersRepository
     */
    public function __construct(
        Context $context,
        SlidersRepositoryInterface $slidersRepository
    ) {
        $this->context = $context;
        $this->slidersRepository = $slidersRepository;
    }

    /**
     * Return slider ID
     *
     * @return int|null
     */
    public function getSliderId()
    {
        try {
            return $this->slidersRepository->getById(
                $this->context->getRequest()->getParam('slider_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
<?php
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\HomeSliders\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Turiknox\HomeSliders\Api\SlidersRepositoryInterface;

abstract class Sliders extends Action
{
    /**
     * @var string
     */
    const ACTION_RESOURCE = 'Turiknox_HomeSliders::sliders';

    /**
     * Slider repository
     *
     * @var SlidersRepositoryInterface
     */
    protected $sliderRepository;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Result Page Factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Date filter
     *
     * @var Date
     */
    protected $dateFilter;

    /**
     * Sliders constructor.
     *
     * @param Registry $registry
     * @param SlidersRepositoryInterface $dataRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        SlidersRepositoryInterface $dataRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Context $context
    ) {
        $this->coreRegistry         = $registry;
        $this->sliderRepository     = $dataRepository;
        $this->resultPageFactory    = $resultPageFactory;
        $this->dateFilter = $dateFilter;
        parent::__construct($context);
    }
}

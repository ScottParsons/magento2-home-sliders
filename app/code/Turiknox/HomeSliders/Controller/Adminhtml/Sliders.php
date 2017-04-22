<?php
namespace Turiknox\HomeSliders\Controller\Adminhtml;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
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
    protected $_sliderRepository;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Result Page Factory
     *
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Date filter
     *
     * @var Date
     */
    protected $_dateFilter;

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
        $this->_coreRegistry         = $registry;
        $this->_sliderRepository     = $dataRepository;
        $this->_resultPageFactory    = $resultPageFactory;
        $this->_dateFilter = $dateFilter;
        parent::__construct($context);
    }
}
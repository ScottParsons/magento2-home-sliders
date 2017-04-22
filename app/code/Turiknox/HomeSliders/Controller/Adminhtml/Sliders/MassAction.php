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
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Turiknox\HomeSliders\Api\SlidersRepositoryInterface;
use Turiknox\HomeSliders\Controller\Adminhtml\Sliders;
use Turiknox\HomeSliders\Model\Sliders as SlidersModel;
use Turiknox\HomeSliders\Model\ResourceModel\Sliders\CollectionFactory;

abstract class MassAction extends Sliders
{
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var string
     */
    protected $_successMessage;

    /**
     * @var string
     */
    protected $_errorMessage;

    /**
     * MassAction constructor.
     *
     * @param Registry $registry
     * @param SlidersRepositoryInterface $slidersRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param $successMessage
     * @param $errorMessage
     */
    public function __construct(
        Registry $registry,
        SlidersRepositoryInterface $slidersRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        $successMessage,
        $errorMessage
    ) {
        parent::__construct($registry, $slidersRepository, $resultPageFactory, $dateFilter, $context);
        $this->_filter            = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->_successMessage    = $successMessage;
        $this->_errorMessage      = $errorMessage;
    }

    /**
     * @param SlidersModel $sliders
     * @return mixed
     */
    protected abstract function massAction(SlidersModel $sliders);

    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->_filter->getCollection($this->_collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $slider) {
                $this->massAction($slider);
            }
            $this->messageManager->addSuccessMessage(__($this->_successMessage, $collectionSize));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __($this->_errorMessage));
        }
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectResult->setPath('homesliders/sliders');
        return $redirectResult;
    }
}

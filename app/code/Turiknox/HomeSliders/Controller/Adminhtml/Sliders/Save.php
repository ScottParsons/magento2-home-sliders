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

use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Message\Manager;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Turiknox\HomeSliders\Api\SlidersRepositoryInterface;
use Turiknox\HomeSliders\Api\Data\SlidersInterface;
use Turiknox\HomeSliders\Api\Data\SlidersInterfaceFactory;
use Turiknox\HomeSliders\Controller\Adminhtml\Sliders;
use Turiknox\HomeSliders\Model\Uploader;
use Turiknox\HomeSliders\Model\UploaderPool;

class Save extends Sliders
{
    /**
     * @var Manager
     */
    protected $messageManager;

    /**
     * @var SlidersRepositoryInterface
     */
    protected $sliderRepository;

    /**
     * @var SlidersInterfaceFactory
     */
    protected $sliderFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * Save constructor.
     *
     * @param Registry $registry
     * @param SlidersRepositoryInterface $sliderRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Manager $messageManager
     * @param SlidersInterfaceFactory $sliderFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param UploaderPool $uploaderPool
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        SlidersRepositoryInterface $sliderRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Manager $messageManager,
        SlidersInterfaceFactory $sliderFactory,
        DataObjectHelper $dataObjectHelper,
        UploaderPool $uploaderPool,
        Context $context
    ) {
        parent::__construct($registry, $sliderRepository, $resultPageFactory, $dateFilter, $context);
        $this->messageManager   = $messageManager;
        $this->sliderFactory      = $sliderFactory;
        $this->sliderRepository   = $sliderRepository;
        $this->dataObjectHelper  = $dataObjectHelper;
        $this->uploaderPool = $uploaderPool;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = $this->getRequest()->getParam('slider_id');
            if ($id) {
                $model = $this->sliderRepository->getById($id);
            } else {
                unset($data['slider_id']);
                $model = $this->sliderFactory->create();
            }

            try {
                $image = $this->getUploader('image')->uploadFileAndGetName('image', $data);
                $data['image'] = $image;

                $this->dataObjectHelper->populateWithArray($model, $data, SlidersInterface::class);
                $this->sliderRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved this slider.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['slider_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the slider.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['slider_id' => $this->getRequest()->getParam('slider_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
}

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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Turiknox\HomeSliders\Controller\Adminhtml\Sliders;

class Delete extends Sliders
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $sliderId = $this->getRequest()->getParam('slider_id');
        if ($sliderId) {
            try {
                $this->_sliderRepository->deleteById($sliderId);
                $this->messageManager->addSuccessMessage(__('The slider has been deleted.'));
                $resultRedirect->setPath('homesliders/sliders/index');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The slider no longer exists.'));
                return $resultRedirect->setPath('homesliders/sliders/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('homesliders/sliders/index', ['slider_id' => $sliderId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the slider'));
                return $resultRedirect->setPath('homesliders/sliders/edit', ['slider_id' => $sliderId]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find the slider to delete.'));
        $resultRedirect->setPath('homesliders/sliders/index');
        return $resultRedirect;
    }
}
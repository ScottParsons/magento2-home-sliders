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

use Turiknox\HomeSliders\Controller\Adminhtml\Sliders;

class Edit extends Sliders
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $sliderId = $this->getRequest()->getParam('slider_id');
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Turiknox_HomeSliders::sliders')
            ->addBreadcrumb(__('Sliders'), __('Sliders'))
            ->addBreadcrumb(__('Manage Sliders'), __('Manage Sliders'));

        if ($sliderId === null) {
            $resultPage->addBreadcrumb(__('New Slider'), __('New Slider'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Slider'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Slider'), __('Edit Slider'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->sliderRepository->getById($sliderId)->getTitle()
            );
        }
        return $resultPage;
    }
}

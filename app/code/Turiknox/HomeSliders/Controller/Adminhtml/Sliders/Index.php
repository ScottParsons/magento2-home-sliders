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

class Index extends Sliders
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Turiknox_HomeSliders::sliders');
        $resultPage->getConfig()->getTitle()->prepend(__('Sliders'));
        $resultPage->addBreadcrumb(__('Sliders'), __('Sliders'));
        return $resultPage;
    }
}

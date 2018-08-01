<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Robin\Bai1\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Robin\Bai1\Model\BannerFactory;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Robin_Bai1::save';
    protected $jsonFactory;
    protected $bannerFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
       JsonFactory $jsonFactory,
        BannerFactory $bannerFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->bannerFactory =$bannerFactory;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */


    /**
     * Edit CMS page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // Init result Json
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        // Get POST data
        $postItems = $this->getRequest()->getParam('items', []);
        // Check request
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        // Save data to database
        foreach (array_keys($postItems) as $bannerId) {
            try {
                $banner = $this->bannerFactory->create();
                $banner->load($bannerId);
                $banner->setData($postItems[(string)$bannerId]);
                $banner->save();
            } catch (\Exception $e) {
                $messages[] = __('Something went wrong while saving the image.');
                $error = true;
            }
        }
        // Return result Json
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 03/07/2018
 * Time: 23:26
 */

namespace Robin\Bai1\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\Context;
use \Robin\Bai1\Model\BannerFactory;

class Index extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory;
    protected $_registry;
    protected $bannerFactory;
    public function __construct(Context $context,
                                \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                                \Magento\Framework\Registry $registry
    , BannerFactory $bannerFactory)
    {
        $this->bannerFactory =$bannerFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_registry = $registry;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Robin_Bai1::banner_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Banner'));
        return $resultPage;
    }
}
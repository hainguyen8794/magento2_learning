<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 03/07/2018
 * Time: 23:26
 */

namespace Robin\Bai1\Controller\View;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_registry;

    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $registry)
    {

        $this->_resultPageFactory = $resultPageFactory;
        $this->_registry = $registry;
        parent::__construct($context);
    }


    public function execute()
    {
        $this->_registry->register('custom_var', 'Test Value123aaaaaaaaaa');
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
        /*     $debugBackTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
             foreach ($debugBackTrace as $item)
             {    echo @$item['class'] . @$item['type'] . @$item['function'] . "\n";
             echo "<pre>";}
             die();*/
    }
}
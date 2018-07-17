<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 03/07/2018
 * Time: 23:26
 */

namespace Robin\Bai1\Controller\View;

use Magento\Framework\App\Action\Context;
use \Robin\Bai1\Model\BannerFactory;

class Index extends \Magento\Framework\App\Action\Action
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
        /*$this->_registry->register('custom_var', 'Test Value123aaaaaaaaaa');
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;*/
        /*     $debugBackTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
             foreach ($debugBackTrace as $item)
             {    echo @$item['class'] . @$item['type'] . @$item['function'] . "\n";
             echo "<pre>";}
             die();*/
       /* $banner = $this->_objectManager->create('Robin\Bai1\Model\Banner');*/
       /* $banner->addData([
            'link'=>'banner link',
            'image'=>'avatar.png',
            'sort_order'=>1,
            'status'=>true
        ])->save();*/
      /* $data =$banner->load(1)->getData();
       var_dump($data);*/
       //update data
      /*  $data = $banner->load(1);
        $data->setImage('logo.png')->save();
        $data1 = $banner->load(1)->getData();*/
        /*var_dump($data1);*/
      /*  echo  "done";*/
        //getSelect để lấy câu lênh query
        // addfield to Select
      /* $collection = $banner->getCollection();
        $data2= $collection->addFieldToSelect('image')->addFieldToFilter('id',['gt'=>0])->getData();
        var_dump($data2);*/

    $banner = $this->bannerFactory->create();
    /* $data = $banner->load(1)->getData();
     print_r(json_encode($data));*/
    $collection = $banner->getCollection();
    $data = $collection->addFieldToFilter('id',['gt'=>2])->getData();
        print_r(json_encode($data));
    }
}
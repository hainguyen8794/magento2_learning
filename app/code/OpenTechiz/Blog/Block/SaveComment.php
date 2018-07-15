<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 05/07/2018
 * Time: 23:25
 */

namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\PostInterface;
use OpenTechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;
use Magento\Framework\View\Element\Template;
class SaveComment extends Template
{
    protected $_request;
    protected $_customerSession;
    public function __construct(Template\Context $context,
                                \Magento\Framework\App\RequestInterface $request,
                                \Magento\Customer\Model\Session $customerSession,
                                array $data = [])
    {
        $this->_request = $request;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }
    public function getFormAction(){
        return '/magento2.2/blog/comment/save';
    }
    public function getPostID()
    {
        return $this->_request->getParam('post_id', false);
    }
    public function getAjaxUrl()
    {
        return '/magento2.2/blog/comment/load';
    }
    public function getAjaxNotificationLoadUrl()
    {
        return '/magento2.2/blog/notification/load';
    }
    public function isLoggedIn()
    {
        return $this->_customerSession->isLoggedIn();
    }
}
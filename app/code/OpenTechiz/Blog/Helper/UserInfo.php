<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 15/07/2018
 * Time: 21:00
 */

namespace OpenTechiz\Blog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class UserInfo extends AbstractHelper
{
    protected $_customerSession;
    public function __construct(Context $context ,
                                \Magento\Framework\App\Http\Context $httpContext
)
    {
        $this->_httpContext = $httpContext;
        parent::__construct($context);
    }
    public function isLoggedIn()
    {
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        return $isLoggedIn;
    }
}
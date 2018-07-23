<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 03/07/2018
 * Time: 23:28
 */

namespace Robin\Bai1\Block;

class Helloworld extends \Magento\Framework\View\Element\Template
{

    protected $_registry;
    protected $_catalogSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\Session $catalogSession,
        array $data = []
    )
    {
        $this->_registry = $registry;
        $this->_catalogSession = $catalogSession;
        parent::__construct($context, $data);

    }

    public function getHelloWorldTxt()
    {
        return 'Helloworld world! demo 123123aaaaaaaaaaa ';

    }

    public function getCatalogSession()
    {
        return $this->_catalogSession;
    }
}
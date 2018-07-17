<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 17/07/2018
 * Time: 10:02
 */

namespace Hainh\Helloworld\Setup;

use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallDataInterface;
class InstallData implements  InstallDataInterface
{
    private $eavSetupFactory;
    private $eavConfig;
    private $attributeResource;
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
    )
    {
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeResource = $attributeResource;
    }
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
       $eavSetup = $this->eavSetupFactory->create(['setup'=>$setup]);
       $eavSetup->addAttribute(Customer::ENTITY,'attribute_code',[

       ]);
        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'attribute_code');
        $attribute->setData('used_in_forms', ['adminhtml_customer']);
        $this->attributeResource->save($attribute);
    }
}
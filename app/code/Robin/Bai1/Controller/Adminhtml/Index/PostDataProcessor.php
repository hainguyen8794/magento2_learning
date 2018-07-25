<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Robin\Bai1\Controller\Adminhtml\Index;

use Magento\Cms\Model\Page\DomValidationState;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Config\Dom\ValidationException;
use Magento\Framework\Config\Dom\ValidationSchemaException;

/**
 * Class PostDataProcessor
 * @package Magento\Cms\Controller\Adminhtml\Page
 */
class PostDataProcessor
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;

    /**
     * @var \Magento\Framework\View\Model\Layout\Update\ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var DomValidationState
     */
    private $validationState;

    /**
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\View\Model\Layout\Update\ValidatorFactory $validatorFactory
     * @param DomValidationState $validationState
     */
    public function __construct(

        \Magento\Framework\Message\ManagerInterface $messageManager

    ) {

        $this->messageManager = $messageManager;

    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array $data
     * @return array
     */


    /**
     * Validate post data
     *
     * @param array $data
     * @return bool     Return FALSE if some item is invalid
     */

    /**
     * Check if required fields is not empty
     *
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'image' => __('Image'),
            'link' => __('Link'),
            'status' => __('Status')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }

    /**
     * Validate data, avoid cyclomatic complexity
     *
     * @param array $data
     * @param \Magento\Framework\View\Model\Layout\Update\Validator $layoutXmlValidator
     * @return bool
     */
    private function validateData($data, $layoutXmlValidator)
    {
        try {
            if (!empty($data['layout_update_xml']) && !$layoutXmlValidator->isValid($data['layout_update_xml'])) {
                return false;
            }
            if (!empty($data['custom_layout_update_xml']) &&
                !$layoutXmlValidator->isValid($data['custom_layout_update_xml'])
            ) {
                return false;
            }
        } catch (ValidationException $e) {
            return false;
        } catch (ValidationSchemaException $e) {
            return false;
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e);
            return false;
        }

        return true;
    }
}

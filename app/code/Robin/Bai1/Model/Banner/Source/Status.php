<?php
namespace Robin\Bai1\Model\Banner\Source;
use Magento\Framework\Data\OptionSourceInterface;
class Status implements OptionSourceInterface
{
    protected $banner;
    public function __construct(\Robin\Bai1\Model\Banner $banner)
    {
        $this->banner = $banner;
    }
    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $availableOptions = $this->banner->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
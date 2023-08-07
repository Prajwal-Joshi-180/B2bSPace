<?php

namespace Codilar\B2bSpace\Block\Link;

use Magento\Framework\View\Element\Html\Link;

class B2bSpace extends Link implements \Magento\Customer\Block\Account\SortLinkInterface
{
    /**
     * Get href
     *
     * @return string
     */
    public function getHref()
    {
        return $this->getUrl('b2bspace');
    }

    /**
     * Get Label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('B2B Mavericks Hub');
    }

    /**
     * {@inheritdoc}
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }
}

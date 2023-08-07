<?php

/**
 * @package     Team Ode To Code
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\B2bSpace\Block\Link;

use Magento\Customer\Block\Account\SortLinkInterface;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Html\Link;

class B2bSpace extends Link implements SortLinkInterface
{
    /**
     * Get href link
     *
     * @return string
     */
    public function getHref(): string
    {
        return $this->getUrl('b2bspace');
    }

    /**
     * Get Label for the link
     *
     * @return Phrase
     */
    public function getLabel(): Phrase
    {
        return __('B2B Mavericks Hub');
    }

    /**
     * Get the Sort Order
     *
     * @return array|int|mixed|null
     */
    public function getSortOrder(): mixed
    {
        return $this->getData(self::SORT_ORDER);
    }
}

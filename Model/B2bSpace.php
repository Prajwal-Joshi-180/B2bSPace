<?php

/**
 * @package     Team Ode To Code
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\B2bSpace\Model;

use Magento\Framework\Model\AbstractModel;
use Codilar\B2bSpace\Model\ResourceModel\B2bSpace as ResourceModel;

class B2bSpace extends AbstractModel
{
    /**
     * Initialize ResourceModel
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }
}

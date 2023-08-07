<?php

/**
 * @package     Team Ode To Code
 *
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\B2bSpace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class B2bSpace extends AbstractDb
{
    const TABLE_NAME = 'b2b_space';
    const ID_FIELD_NAME = 'entity_id';

    /**
     * Initialize Table the Primary key
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}

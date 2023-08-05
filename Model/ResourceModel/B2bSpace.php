<?php

namespace Codilar\B2bSpace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class B2bSpace extends AbstractDb
{
    const TABLE_NAME = 'b2b_space';
    const ID_FIELD_NAME = 'entity_id';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}

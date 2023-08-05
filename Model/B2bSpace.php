<?php

namespace Codilar\B2bSpace\Model;

use Magento\Framework\Model\AbstractModel;
use Codilar\B2bSpace\Model\ResourceModel\B2bSpace as ResourceModel;

class B2bSpace extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}

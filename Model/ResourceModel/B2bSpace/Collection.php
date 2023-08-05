<?php

namespace Codilar\B2bSpace\Model\ResourceModel\B2bSpace;

use Codilar\B2bSpace\Model\B2bSpace as Model;
use Codilar\B2bSpace\Model\ResourceModel\B2bSpace as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}

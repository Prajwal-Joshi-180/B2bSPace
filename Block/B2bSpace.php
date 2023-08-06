<?php

namespace Codilar\B2bSpace\Block;

use Codilar\B2bSpace\Model\ResourceModel\B2bSpace\CollectionFactory;
use Magento\Company\Api\CompanyManagementInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class B2bSpace extends Template
{
    private CollectionFactory $collectionFactory;
    private CustomerSession $customerSession;
    private CompanyManagementInterface $companyManagement;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param CustomerSession $customerSession
     * @param CompanyManagementInterface $companyManagement
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        CustomerSession $customerSession,
        CompanyManagementInterface $companyManagement,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
        $this->companyManagement = $companyManagement;
        parent::__construct($context, $data);
    }

    public function getMessageData()
    {
        $customerId = $this->getCustomerId();
        $companyId = $this->companyManagement->getByCustomerId($customerId)->getId();
        $data = $this->collectionFactory->create()->addFieldToSelect('*')
            ->addFieldToFilter('company_id', $companyId);
        return $data->getItems();
    }

    public function getCustomerId()
    {
        return (int) $this->customerSession->getCustomerId();
    }

    public function getCompany()
    {
        $customerId = $this->getCustomerId();
        return $this->companyManagement->getByCustomerId($customerId);
    }
}

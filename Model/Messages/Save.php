<?php

namespace Codilar\B2bSpace\Model\Messages;

use Codilar\B2bSpace\Model\B2bSpaceFactory as ModelFactory;
use Codilar\B2bSpace\Model\ResourceModel\B2bSpace as ResourceModel;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Company\Api\CompanyManagementInterface;
use Psr\Log\LoggerInterface;

class Save
{
    /**
     * @var ModelFactory
     */
    private ModelFactory $modelFactory;

    /**
     * @var ResourceModel
     */
    private ResourceModel $resourceModel;
    private CustomerSession $customerSession;
    private LoggerInterface $logger;
    private CompanyManagementInterface $companyManagement;

    /**
     * @param ModelFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CustomerSession $customerSession
     * @param CompanyManagementInterface $companyManagement
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CustomerSession $customerSession,
        CompanyManagementInterface $companyManagement,
        LoggerInterface $logger
    ) {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->customerSession = $customerSession;
        $this->companyManagement = $companyManagement;
        $this->logger = $logger;
    }


    public function MessageSave($message): void
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/company.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $customerId = $this->customerSession->getCustomerId();
        $companyId = $this->companyManagement->getByCustomerId($customerId)->getId();
        $logger->info($companyId);
        $messageModel = $this->modelFactory->create();
        $messageModel->setCustomerId($customerId);
        $messageModel->setCompanyId($companyId);
        $messageModel->setMessage($message);
        try {
            $this->resourceModel->save($messageModel);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}

<?php

/**
 * @package     Team Ode To Code
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\B2bSpace\Model\Messages;

use Codilar\B2bSpace\Model\B2bSpaceFactory as ModelFactory;
use Codilar\B2bSpace\Model\ResourceModel\B2bSpace as ResourceModel;
use Magento\Company\Api\CompanyManagementInterface;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
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

    /**
     * @var CustomerSession
     */
    private CustomerSession $customerSession;

    /**
     * @var CompanyManagementInterface
     */
    private CompanyManagementInterface $companyManagement;

    /**
     * @var CustomerRepository
     */
    private CustomerRepository $customerRepository;

    /***
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Save Constructor
     * @param ModelFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CustomerSession $customerSession
     * @param CompanyManagementInterface $companyManagement
     * @param CustomerRepository $customerRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CustomerSession $customerSession,
        CompanyManagementInterface $companyManagement,
        CustomerRepository $customerRepository,
        LoggerInterface $logger
    ) {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->customerSession = $customerSession;
        $this->companyManagement = $companyManagement;
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
    }

    /**
     * Save the user messages and other Information
     *
     * @param $message
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function MessageSave($message): void
    {
        $customerId = $this->customerSession->getCustomerId();
        $customer = $this->customerRepository->getById($customerId);
        $companyId = $this->companyManagement->getByCustomerId($customerId)->getId();
        $messageModel = $this->modelFactory->create();
        $messageModel->setCustomerId($customerId);
        $messageModel->setCompanyId($companyId);
        $messageModel->setCustomerName($customer->getFirstname() . ' ' . $customer->getLastname());
        $messageModel->setMessage($message);
        try {
            $this->resourceModel->save($messageModel);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}

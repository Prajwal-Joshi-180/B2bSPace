<?php

/**
 * @package     Team Ode To Code
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\B2bSpace\Block;

use Codilar\B2bSpace\Model\ResourceModel\B2bSpace\CollectionFactory;
use Magento\Company\Api\CompanyManagementInterface;
use Magento\Company\Api\Data\CompanyInterface;
use Magento\Company\Model\CompanyHierarchy;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Company\Api\Data\HierarchyInterface;
use Magento\Framework\View\Element\Template\Context;

class B2bSpace extends Template
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var CustomerSession
     */
    private CustomerSession $customerSession;

    /**
     * @var CompanyManagementInterface
     */
    private CompanyManagementInterface $companyManagement;

    /**
     * @var CompanyHierarchy
     */
    private CompanyHierarchy $companyHierarchy;

    /**
     * @var CustomerRepository
     */
    private CustomerRepository $customerRepository;

    /**
     * B2bSpace Constructor
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param CustomerSession $customerSession
     * @param CompanyManagementInterface $companyManagement
     * @param CustomerRepository $customerRepository
     * @param CompanyHierarchy $companyHierarchy
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        CustomerSession $customerSession,
        CompanyManagementInterface $companyManagement,
        CustomerRepository $customerRepository,
        CompanyHierarchy $companyHierarchy,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
        $this->companyManagement = $companyManagement;
        $this->companyHierarchy = $companyHierarchy;
        $this->customerRepository = $customerRepository;
        parent::__construct($context, $data);
    }

    /**
     * Return the Message Data
     *
     * @return array
     */
    public function getMessageData(): array
    {
        $customerId = $this->getCustomerId();
        $companyId = $this->companyManagement->getByCustomerId($customerId)->getId();
        $data = $this->collectionFactory->create()->addFieldToSelect('*')
            ->addFieldToFilter('company_id', $companyId);
        return $data->getItems();
    }

    /**
     * Return the Customer I'd
     *
     * @return int
     */
    public function getCustomerId(): int
    {
        return (int) $this->customerSession->getCustomerId();
    }

    /**
     * Get the Company data by customer I'd
     *
     * @return CompanyInterface
     */
    public function getCompany(): CompanyInterface
    {
        $customerId = $this->getCustomerId();
        return $this->companyManagement->getByCustomerId($customerId);
    }

    /**
     * Return the all company users by Company I'd
     *
     * @param $companyId
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCompanyUsers($companyId): array
    {
        $users = [];
        $hierarchy =  $this->companyHierarchy->getCompanyHierarchy($companyId);
        foreach ($hierarchy as $item) {
            if ($item->getEntityType() == HierarchyInterface::TYPE_CUSTOMER) {
                $customer = $this->customerRepository->getById($item->getEntityId());
                $user = [
                    'name' => $customer->getFirstname() . ' ' . $customer->getLastname(),
                    'email' => $customer->getEmail(),
                ];

                $users[] = $user;
            }
        }
        return $users;
    }
}

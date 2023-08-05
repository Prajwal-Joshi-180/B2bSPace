<?php

namespace Codilar\B2bSpace\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Company\Model\CompanyContext;
use Magento\Framework\Controller\Result\ForwardFactory;

class Index implements ActionInterface
{
    private PageFactory $resultPageFactory;
    private CompanyContext $companyContext;
    private ForwardFactory $forwardFactory;

    /** Index Constructor
     * @param PageFactory $resultPageFactory
     * @param CompanyContext $companyContext
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        PageFactory $resultPageFactory,
        CompanyContext $companyContext,
        ForwardFactory $forwardFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->companyContext = $companyContext;
        $this->forwardFactory = $forwardFactory;
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function execute()
    {
        if ($this->companyContext->isCurrentUserCompanyUser()) {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->set(__('B2B Space'));
            return $resultPage;
        } else {
            $resultForward = $this->forwardFactory->create();
            $resultForward->forward('noroute');
            return $resultForward;
        }
    }
}

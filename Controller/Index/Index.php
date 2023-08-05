<?php

namespace Codilar\B2bSpace\Controller\Index;

use Magento\Company\Model\CompanyContext;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index implements ActionInterface
{

    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var CompanyContext
     */
    private CompanyContext $companyContext;

    /**
     * @var ForwardFactory
     */
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
     * @return ResponseInterface|Forward|ResultInterface|Page
     * @throws LocalizedException
     * @throws NoSuchEntityException
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

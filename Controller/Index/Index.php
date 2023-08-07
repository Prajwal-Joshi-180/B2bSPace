<?php

namespace Codilar\B2bSpace\Controller\Index;

use Magento\Company\Model\CompanyContext;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
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
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /** Index Constructor
     * @param PageFactory $resultPageFactory
     * @param CompanyContext $companyContext
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        PageFactory $resultPageFactory,
        CompanyContext $companyContext,
        ManagerInterface $messageManager,
        RedirectFactory $redirectFactory,
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->companyContext = $companyContext;
        $this->messageManager = $messageManager;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return ResponseInterface|Forward|ResultInterface|Page
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $resultRedirect = $this->redirectFactory->create();
        if ($this->companyContext->isCurrentUserCompanyUser()) {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->set(__('B2B Mavericks Hub'));
            return $resultPage;
        } else {
            $this->messageManager->addErrorMessage(__('Only Company User have access to this page'));
            $resultRedirect->setPath('home');
            return $resultRedirect;
        }
    }
}

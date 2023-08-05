<?php

namespace Codilar\B2bSpace\Controller\Index;

use Codilar\B2bSpace\Model\Messages\Save as MessageSave;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Response implements ActionInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var MessageSave
     */
    private MessageSave $messageSave;

    private JsonFactory $resultJsonFactory;
    private PageFactory $resultPageFactory;

    /**
     * @param RequestInterface $request
     * @param MessageSave $messageSave
     * @param JsonFactory $resultJsonFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        RequestInterface $request,
        MessageSave    $messageSave,
        JsonFactory $resultJsonFactory,
        PageFactory $resultPageFactory
    ) {
        $this->request = $request;
        $this->messageSave = $messageSave;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $resultPage = $this->resultPageFactory->create();

        $message = $this->request->getParam('message');
        if ($message) {
            $this->messageSave->MessageSave($message);
        }
        $block = $resultPage->getLayout()
            ->createBlock(\Codilar\B2bSpace\Block\B2bSpace::class)
            ->setTemplate('Codilar_B2bSpace::messages.phtml')
            ->toHtml();
        $result->setData(['data' => $block]);
        return $result;
    }
}

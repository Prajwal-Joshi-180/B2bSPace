<?php

/**
 * @package     Team Ode To Code
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\B2bSpace\Controller\Index;

use Codilar\B2bSpace\Model\Messages\Save as MessageSave;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Codilar\B2bSpace\Block\B2bSpace;

class Response implements ActionInterface
{
    const TEMPLATE = 'Codilar_B2bSpace::messages.phtml';
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var MessageSave
     */
    private MessageSave $messageSave;

    /**
     * @var JsonFactory
     */
    private JsonFactory $resultJsonFactory;

    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * Response Constructor
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


    /**
     * Ajax Call to Update Message Content
     *
     * @return Json
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(): Json
    {
        $result = $this->resultJsonFactory->create();
        $resultPage = $this->resultPageFactory->create();

        $message = $this->request->getParam('message');
        if ($message) {
            $this->messageSave->MessageSave($message);
        }
        $block = $resultPage->getLayout()
            ->createBlock(B2bSpace::class)
            ->setTemplate(self::TEMPLATE)
            ->toHtml();
        $result->setData(['data' => $block]);
        return $result;
    }
}

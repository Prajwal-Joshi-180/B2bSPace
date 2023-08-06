<?php

namespace Codilar\B2bSpace\Controller\Index;

use Codilar\B2bSpace\Model\B2bSpace as MessageModel;
use Codilar\B2bSpace\Model\ResourceModel\B2bSpace\Collection;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Controller\Result\JsonFactory;

class Search implements ActionInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var MessageModel
     */
    private MessageModel $messageModel;

    /**
     * @var ResourceConnection
     */
    private ResourceConnection $resourceConnection;

    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;

    /**
     * @var Collection
     */
    private Collection $message;

    public function __construct(
        RequestInterface $request,
        MessageModel $messageModel,
        Collection $message,
        ResourceConnection $resourceConnection,
        JsonFactory $jsonFactory
    ) {
        $this->request = $request;
        $this->messageModel = $messageModel;
        $this->resourceConnection = $resourceConnection;
        $this->jsonFactory = $jsonFactory;
        $this->message = $message;
    }

    public function execute()
    {
        $response = [];
        $resultJson = $this->jsonFactory->create();
        $searchQuery = $this->request->getParams()['query'];
        $count = 0;

        if ($searchQuery) {
            try {
                $messageCollection = $this->message->addFieldToFilter('message', ['like' => $searchQuery . '%']);
                if (count($messageCollection)) {
                    $count = count($messageCollection);
                    foreach ($messageCollection as $message) {
                        $response[$message->getEntityID()]['message'] = $message->getMessage();
                    }
                }
            } catch (\Exception $exception) {
                $response['status'] = 400;
                $response['exception'] = $exception->getMessage();
            }
        }
        return $resultJson->setData([
            'html' => $response,
            'count' => $count
        ]);
    }
}

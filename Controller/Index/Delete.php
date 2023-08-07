<?php

/**
 * @package     Team Ode To Code
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\B2bSpace\Controller\Index;

use Codilar\B2bSpace\Model\B2bSpaceFactory;
use Codilar\B2bSpace\Model\ResourceModel\B2bSpace;
use Exception;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

class Delete implements ActionInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var B2bSpaceFactory
     */
    private B2bSpaceFactory $b2bSpaceFactory;

    /**
     * @var B2bSpace
     */
    private B2bSpace $bSpace;
    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;

    /**
     * Delete Constructor
     * @param RequestInterface $request
     * @param B2bSpaceFactory $b2bSpaceFactory
     * @param B2bSpace $bSpace
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        RequestInterface $request,
        B2bSpaceFactory $b2bSpaceFactory,
        B2bSpace $bSpace,
        JsonFactory $jsonFactory
    ) {
        $this->request = $request;
        $this->b2bSpaceFactory = $b2bSpaceFactory;
        $this->bSpace = $bSpace;
        $this->jsonFactory = $jsonFactory;
    }


    /**
     * Delete the message by aAax call
     * @return Json
     * @throws Exception
     */
    public function execute(): Json
    {
        $resultJson = $this->jsonFactory->create();
        $id = $this->request->getParam('id');
        $model = $this->b2bSpaceFactory->create();
        $this->bSpace->load($model, $id);
        $this->bSpace->delete($model);
        return $resultJson->setData(['success' => true]);
    }
}

<?php

/**
 * @package     Team Ode To Code
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\B2bSpace\Model\Messages;

use Codilar\B2bSpace\Model\B2bSpaceFactory;
use Codilar\B2bSpace\Model\ResourceModel\B2bSpace;
use Exception;

class Delete
{

    /**
     * @var B2bSpaceFactory
     */
    private B2bSpaceFactory $b2bSpaceFactory;

    /**
     * @var B2bSpace
     */
    private B2bSpace $bSpace;


    /**
     * Delete Constructor
     * @param B2bSpaceFactory $b2bSpaceFactory
     * @param B2bSpace $bSpace
     */
    public function __construct(
        B2bSpaceFactory $b2bSpaceFactory,
        B2bSpace $bSpace,
    ) {
        $this->b2bSpaceFactory = $b2bSpaceFactory;
        $this->bSpace = $bSpace;
    }


    /**
     * Delete the message by I'd
     * @param $id
     * @return void
     * @throws Exception
     */
    public function MessageDelete($id): void
    {
        $model = $this->b2bSpaceFactory->create();
        $this->bSpace->load($model, $id);
        $this->bSpace->delete($model);
    }
}

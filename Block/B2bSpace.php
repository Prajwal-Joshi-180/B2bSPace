<?php

namespace Codilar\B2bSpace\Block;

use Magento\Framework\View\Element\Template;

class B2bSpace extends Template
{
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getName(): string
    {
        return 'hi';
    }
}

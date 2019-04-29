<?php

namespace Clkweb\Viabill\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function getViabillId()
    {
        return $this->scopeConfig->getValue('catalog/price/viabill_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
<?php
namespace Clkweb\Viabill\Plugin;

class FinalPricePlugin
{
    public function afterToHtml(\Magento\Catalog\Pricing\Render\FinalPriceBox $subject, $result)
    {
        return $result . '<br /><div class="viabill-pricetag" data-view="product" data-price="42"></div>';
    }
}
<?php
namespace Clkweb\Viabill\Plugin;

class FinalPricePlugin
{
    protected $_request;

    public function __construct(\Magento\Framework\App\Request\Http $request)
    {
        $this->_request = $request;
    }

    public function afterToHtml(\Magento\Catalog\Pricing\Render\FinalPriceBox $subject, $result)
    {
        if ($this->_request->getFullActionName() == "catalog_category_view")
        {
            $result .= '<div class="viabill-pricetag" data-view="list" data-price="'.$subject->getPrice()->getAmount().'"></div>';
        }
        else if ($this->_request->getFullActionName() == "catalog_product_view" && $subject->getPriceTypeCode() == "final_price")
        {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $product = $objectManager->get('Magento\Framework\Registry')->registry('current_product');
            $type = $product->getTypeId();

            if ($type == "configurable")
            {
                $result .= '<div class="viabill-pricetag" data-view="product" data-dynamic-price=".price" data-dynamic-price-triggers="#webshop_content .filters input"></div>';
            }
            else
            {
                $result .= '<div class="viabill-pricetag" data-view="product" data-price="'.$subject->getPrice()->getAmount().'"></div>';
            }
        }

        return $result;
    }
}
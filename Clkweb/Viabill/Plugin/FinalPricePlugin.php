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
        $product_id = $subject->getPriceId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->get('Magento\Catalog\Model\Product')->load($product_id);
        $product_type = $product->getTypeId();

        if ($this->_request->getFullActionName() == "catalog_category_view")
        {
            if ($product_type == "configurable")
            {
                $result .= '<div class="viabill-pricetag" data-view="list" data-dynamic-price="#product-price-'.$product_id.' .price" data-dynamic-price-triggers=".product-item-details"></div>';
            }
            else
            {
                $result .= '<div class="viabill-pricetag" data-view="list" data-price="'.$subject->getPrice()->getAmount().'"></div>';

            }
        }
        else if ($this->_request->getFullActionName() == "catalog_product_view" && $subject->getPriceTypeCode() == "final_price")
        {
            if ($product_type == "configurable")
            {
                $result .= '<div class="viabill-pricetag" data-view="product" data-dynamic-price=".price" data-dynamic-price-triggers=".product-add-form"></div>';
            }
            else
            {
                $result .= '<div class="viabill-pricetag" data-view="product" data-price="'.$subject->getPrice()->getAmount().'"></div>';
            }
        }

        return $result;
    }
}
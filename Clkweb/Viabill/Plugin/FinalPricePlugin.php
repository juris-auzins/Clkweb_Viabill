<?php
namespace Clkweb\Viabill\Plugin;

use \Magento\Framework\App\Request\Http;
use \Magento\Catalog\Model\ProductRepository;
use \Magento\Catalog\Pricing\Render\FinalPriceBox;

class FinalPricePlugin
{
    protected $_request;
    protected $_product_repository;

    public function __construct(Http $request, ProductRepository $productRepository)
    {
        $this->_request = $request;
        $this->_product_repository = $productRepository;
    }

    public function getHtmlSelectors()
    {
        return array(
            "list_price" => "#product-price-",
            "list_trigger" => ".product-item-details",
            "details_price" => ".price",
            "details_trigger" => ".product-add-form"
        );
    }

        public function afterToHtml(FinalPriceBox $subject, $result)
    {
        $product_id = $subject->getPriceId();
        $product = $this->_product_repository->getById($product_id);
        $product_type = $product->getTypeId();

        if ($this->_request->getFullActionName() == "catalog_category_view")
        {
            if ($product_type == "configurable")
            {
                $result .= '<div class="viabill-pricetag" data-view="list" data-dynamic-price="'.$this->getHtmlSelectors()['list_price'].$product_id.' .price" data-dynamic-price-triggers="'.$this->getHtmlSelectors()['list_trigger'].'"></div>';
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
                $result .= '<div class="viabill-pricetag" data-view="product" data-dynamic-price="'.$this->getHtmlSelectors()['details_price'].'" data-dynamic-price-triggers="'.$this->getHtmlSelectors()['details_trigger'].'"></div>';
            }
            else
            {
                $result .= '<div class="viabill-pricetag" data-view="product" data-price="'.$subject->getPrice()->getAmount().'"></div>';
            }
        }

        return $result;
    }
}
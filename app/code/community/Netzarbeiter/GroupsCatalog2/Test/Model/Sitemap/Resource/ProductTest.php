<?php


class Netzarbeiter_GroupsCatalog2_Test_Model_Sitemap_Resource_ProductTest
    extends EcomDev_PHPUnit_Test_Case
{
    protected $class = 'Netzarbeiter_GroupsCatalog2_Model_Sitemap_Resource_Catalog_Product';

    /**
     * @return Netzarbeiter_GroupsCatalog2_Model_Sitemap_Resource_Catalog_Product
     */
    private function getInstance()
    {
        /** @var Netzarbeiter_GroupsCatalog2_Model_Sitemap_Resource_Catalog_Product $instance */
        $instance = new $this->class;
        return $instance;
    }
    
    private function getMockBehavior()
    {
        $mockBehavior = $this->getMockBuilder('Netzarbeiter_GroupsCatalog2_Model_Sitemap_Resource_Catalog_Behavior_FilterSitemapProduct')
            ->getMock();
        
        return $mockBehavior;
    }
    
    public function testItIsRewritten()
    {
        $result = Mage::getConfig()->getResourceModelClassName('sitemap/catalog_product');
        $this->assertEquals($this->class, $result);
    }
    
    public function testItExists()
    {
        $class = $this->class;
        $exists = class_exists($this->class, true);
        $this->assertTrue(class_exists($this->class, true), "Class {$this->class} does not exist or can't be found by the autoloader");
    }
    
    public function testItExtendsTheOriginalClass()
    {
        $instance = $this->getInstance();
        $this->assertInstanceOf($this->class, $instance);
        $this->assertInstanceOf('Mage_Sitemap_Model_Resource_Catalog_Product', $instance);
    }
    
    public function testItDelegatesToFilterBehavior()
    {
        $instance = $this->getInstance();
        
        $storeId = $this->app()->getDefaultStoreView()->getId();
        
        $mockBehavor = $this->getMockBehavior();
        $mockBehavor->expects($this->once())
            ->method('setStoreId')
            ->with($storeId);
        $mockBehavor->expects($this->once())
            ->method('addNotLoggedInGroupFilter')
            ->with($this->isInstanceOf('Varien_Db_Select'));
        $instance->setAddFilterBehavior($mockBehavor);
        
        $result = $instance->getCollection($storeId);
        
        $this->assertTrue(false !== $result, "Expected getCollection to return an array, received bool false");
    }
} 
<?php
namespace Semdrops\SemdropsMobileBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;
use Semdrops\SemdropsMobileBundle\Entity\PropertyTags;

Class propertiesTest extends TestCase
{
   protected $propertyTags;
   
  public function setUp()
   {
    $this -> propertyTags = new PropertyTags();
    }
   public function testAddProperties()
   {
    $this->propertyTags ->setUri('http://www.ole.com.ar');
    $this->propertyTags ->setPropertyTag('DiarioOleAscenso');
    $this->propertyTags ->setDestino('http://www.ole.com.ar/futbol-ascenso/b-nacional');	
	$this -> assertTrue($this->propertyTags->writeAProperty());
	}
   public function testGetProperties()
 {
    $this->propertyTags ->setUri('http://www.ole.com.ar');
    $this->propertyTags ->setPropertyTag('DiarioOleAscenso');
    $this->propertyTags ->setDestino('http://www.ole.com.ar/futbol-ascenso/b-nacional');	
    $string=$this->propertyTags->getAProperty()[0];
     $this-> assertContains('DiarioOleAscenso', $string);
  }
 }
?>

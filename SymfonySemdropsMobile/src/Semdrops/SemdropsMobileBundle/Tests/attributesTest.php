<?php
namespace Semdrops\SemdropsMobileBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;
use Semdrops\SemdropsMobileBundle\Entity\AttributeTags;

Class propertiesTest extends TestCase
{
   protected $attribute;
   
  public function setUp()
   {
    $this -> attribute = new AttributeTags();
    }
   public function testAddProperties()
   {
	$url='http://requiem:8080/openrdf-sesame/repositories/lalala/statements';
	$datos='<http://www.ole.com.ar/> <http://semdrops.lifia.edu.ar/ns/attribute#DiarioOle> "DiarioDeportivo".';   
	$this -> assertTrue($this->semdrops->writeInSesameDataBase($datos));
	}
    public function testGetProperties()
 { 
    $url='http://requiem.local:8080/openrdf-workbench/repositories/lalala/query?';
	$this-> attribute-> setUri('http://www.ole.com.ar/');
	$a= $this-> attribute-> getAttributes();
    $this-> assertEquals('DiarioOLe', $a[0]);
  }
 }
?>

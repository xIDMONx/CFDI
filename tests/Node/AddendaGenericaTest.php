<?php

namespace xIDMONx\Tests\CFDI\Node;

use PHPUnit\Framework\TestCase;
use xIDMONx\CFDI\Node\Addenda\Generica\Generica;

/**
 * Class AddendaGenericaTest
 *
 * @package xIDMONx\Tests\CFDI\Node
 */
class AddendaGenericaTest extends TestCase
{
    protected $addenda;
    
    public function testNodeName()
    {
        $this->assertEquals(
            'generica:DatosExtra',
            $this->addenda->getNodeName()
        );
    }
    
    public function testParentNodeName()
    {
        $this->assertEquals(
            'generica:Addenda',
            $this->addenda->getParentNodeName()
        );
    }
    
    protected function setUp()
    : void
    {
        $this->addenda = new Generica();
    }
}

<?php

namespace xIDMONx\Tests\CFDI;

use xIDMONx\CFDI\Node\Concepto;
use PHPUnit\Framework\TestCase;

/**
 * Class ConceptoTest
 *
 * @package xIDMONx\Tests\Node
 */
class ConceptoTest extends TestCase
{
    protected $concepto;
    
    public function testNodeName()
    {
        $this->assertEquals(
            'cfdi:Concepto',
            $this->concepto->getNodeName()
        );
    }
    
    public function testParentNodeName()
    {
        $this->assertEquals(
            'cfdi:Conceptos',
            $this->concepto->getParentNodeName()
        );
    }
    
    protected function setUp()
    : void
    {
        $this->concepto = new Concepto();
    }
}

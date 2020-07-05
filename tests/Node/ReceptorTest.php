<?php

namespace xIDMONx\Tests\CFDI;

use xIDMONx\CFDI\Node\Receptor;
use PHPUnit\Framework\TestCase;

/**
 * Class ReceptorTest
 *
 * @package xIDMONx\Tests\Node
 */
class ReceptorTest extends TestCase
{
    /**
     * @var Receptor
     */
    protected $receptor;
    
    /**
     *
     */
    protected function setUp()
    : void
    {
        $this->receptor = new Receptor();
    }
    
    /**
     *
     */
    public function testNodeName()
    {
        $this->assertEquals(
            'cfdi:Receptor',
            $this->receptor->getNodeName()
        );
    }
}

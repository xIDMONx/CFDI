<?php

namespace xIDMONx\Tests\CFDI\Node\Addenda\Turbopac;

use PHPUnit\Framework\TestCase;
use xIDMONx\CFDI\Node\Addenda\Turbopac\Node\Emisor;
use xIDMONx\CFDI\Node\Addenda\Turbopac\Turbopac;

/**
 *
 */
class TurbopacTest extends TestCase
{
    protected $addenda;
    
    public function testNodeName()
    {
        $this->assertEquals(
            'Turbopac:Adicionales',
            $this->addenda->getNodeName()
        );
    }
    
    public function testParentNodeName()
    {
        $this->assertEquals(
            'cfdi:Addenda',
            $this->addenda->getParentNodeName()
        );
    }
    
    public function testAttrNsTurbopac()
    {
        $this->assertEquals(
            'https://www.turbopac.mx/Addendas/TurbopacAdicionales.xsd',
            $this->addenda->getAttr( 'Turbopac:Adicionales' )['xmlns:Turbopac']
        );
    }
    
    protected function setUp()
    : void
    {
        $this->addenda = new Turbopac( [
            "Campo01" => "EMITIDO PARA LA SOLICITUD CON FOLIO. SOL-15-008"
        ] );
        
        $emisor = new Emisor( [
            "calle"        => "INDEPENDENCIA PTE.",
            "codigopostal" => "50000",
            "colonia"      => "CENTRO",
            "estado"       => "MEXICO",
        ] );
        
        $this->addenda->add( $emisor );
    }
}

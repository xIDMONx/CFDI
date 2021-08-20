<?php

namespace xIDMONx\CFDI\Node\Addenda\Turbopac;

use xIDMONx\CFDI\Common\Node;

/**
 *
 */
class Turbopac extends Node
{
    /**
     * @var string
     */
    protected $parentNodeName = "cfdi:Addenda";
    
    /**
     * @var string
     */
    protected $nodeName = "Turbopac:Adicionales";
    
    /**
     * @param array $data
     */
    public function __construct( array $data )
    {
        $data = array_merge( $this->attributes(), $data );
        
        parent::__construct($data);
    }
    
    /**
     * @return string[]
     */
    public function attributes()
    : array
    {
        return [
            "xmlns:Turbopac" => "https://www.turbopac.mx/Addendas/TurbopacAdicionales.xsd"
        ];
    }
}

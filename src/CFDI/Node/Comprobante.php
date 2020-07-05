<?php

namespace xIDMONx\CFDI\Node;

use xIDMONx\CFDI\Common\Node;

/**
 * Class Comprobante
 *
 * @package xIDMONx\CFDI\Node
 */
class Comprobante extends Node
{
    /**
     * @var string
     */
    protected $version;
    /**
     * @var string
     */
    protected $nodeName = 'cfdi:Comprobante';
    
    /**
     * Comprobante constructor.
     *
     * @param array  $data
     * @param string $version
     */
    public function __construct(array $data, string $version)
    {
        $this->version = $version;
        $data          = array_merge($this->attributes(), $data);
        
        parent::__construct($data);
    }
    
    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'xmlns:cfdi'         => 'http://www.sat.gob.mx/cfd/3',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd',
            'Version'            => $this->version,
        ];
    }
    
}

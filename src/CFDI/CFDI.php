<?php

namespace xIDMONx\CFDI;

use xIDMONx\Common\Node;
use xIDMONx\Node\Comprobante;

use DOMDocument;
use XSLTProcessor;

/**
 * Class CFDI
 *
 * @package xIDMONx
 */
class CFDI
{
    /**
     * SAT XSL endpoint
     */
    const XSL_ENDPOINT = 'http://www.sat.gob.mx/sitio_internet/cfd/3/cadenaoriginal_3_3/cadenaoriginal_3_3.xslt';
    
    /**
     * @var string
     */
    protected $version = '3.3';
    
    /**
     * CSD key.
     *
     * @var string
     */
    protected $key;
    
    /**
     * CSD cer.
     *
     * @var string
     */
    protected $cer;
    
    /**
     * @var boolean
     */
    protected $xslt;
    
    /**
     * Comprobante instance.
     *
     * @var Comprobante
     */
    protected $comprobante;
    
    /**
     * CFDI constructor.
     *
     * @param array  $data
     * @param string $cer
     * @param string $key
     * @param bool   $xslt
     */
    public function __construct(array $data, string $cer, string $key, bool $xslt = false)
    {
        $this->comprobante = new Comprobante($data, $this->version);
        $this->key         = $key;
        $this->cer         = $cer;
        $this->xslt        = $xslt;
    }
    
    /**
     *  Agregue un nuevo nodo a la instancia comprobante.
     *
     * @param Node $node
     */
    public function add(Node $node)
    {
        $this->comprobante->add($node);
    }
    
    /**
     * Obtiene la cadena original.
     *
     * @return string
     */
    public function getCadenaOriginal()
    : string
    {
        $xsl = new DOMDocument();
        
        if ($this->xslt) {
            $path = __DIR__ . '/Utils/cadenaoriginal_3_3.xslt';
            $xslt = @file_get_contents($path);
        } else {
            $xslt = static::XSL_ENDPOINT;
        }
        
        $xsl->load($xslt);
        
        $xslt = new XSLTProcessor();
        $xslt->importStylesheet($xsl);
        
        $xml = new DOMDocument();
        $xml->loadXML($this->comprobante->getDocument()->saveXML());
        
        return (string) $xslt->transformToXml($xml);
    }
    
    /**
     * Obtener sello
     *
     * @return string
     */
    protected function getSello()
    : string
    {
        $pkey = openssl_get_privatekey($this->key);
        openssl_sign(@$this->getCadenaOriginal(), $signature, $pkey, OPENSSL_ALGO_SHA256);
        openssl_free_key($pkey);
        return base64_encode($signature);
    }
    
    /**
     * Poner sello
     *
     * @return void
     */
    protected function putSello()
    {
        $this->comprobante->setAtributes(
            $this->comprobante->getElement(),
            [
                'Sello' => $this->getSello()
            ]
        );
    }
    
    /**
     * Obtener Certificado.
     *
     * @return string
     */
    protected function getCertificado()
    : string
    {
        $cer = preg_replace('/(-+[^-]+-+)/', '', $this->cer);
        $cer = preg_replace('/\s+/', '', $cer);
        return $cer;
    }
    
    /**
     * Poner el certificado en el comprobante.
     *
     * @return void
     */
    protected function putCertificado()
    {
        $this->comprobante->setAtributes(
            $this->comprobante->getElement(),
            [
                'Certificado' => $this->getCertificado()
            ]
        );
    }
    
    /**
     * Devuelve el xml con los atributos de sello y certificado.
     *
     * @return DOMDocument
     */
    protected function xml()
    : DOMDocument
    {
        $this->putSello();
        $this->putCertificado();
        return $this->comprobante->getDocument();
    }
    
    /**
     * Obtén el xml.
     *
     * @return string
     */
    public function getXML()
    : string
    {
        return $this->xml()->saveXML();
    }
    
    /**
     * Guarda el comprobante.
     *
     * @param string $path
     * @param string $name
     *
     * @return void
     */
    public function save(string $path, string $name)
    {
        $this->xml()->save($path . $name);
    }
}

<?php

namespace xIDMONx\CFDI\Common;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use LogicException;

/**
 * Class Node
 *
 * @package xIDMONx\Common
 */
class Node
{
    /**
     * Defina el nombre del nodo.
     *
     * @var string
     */
    protected $nodeName = '';
    
    /**
     * Defina el nombre del nodo primario, cambie el nombre de este atributo en la clase de herencia.
     *
     * @var string|null
     */
    protected $parentNodeName = null;
    
    /**
     * Documento de nodo.
     *
     * @var DOMDocument
     */
    protected $document;
    
    /**
     * Elemento de nodo
     *
     * @var DOMElement
     */
    protected $element;
    
    /**
     * Atributos de nodo.
     *
     * @var array
     */
    protected $attr = [];
    
    /**
     * Crea una nueva instancia de nodo.
     *
     * @param array $attr
     */
    public function __construct(...$attr)
    {
        $this->attr = $attr;
        
        $this->document                     = new DOMDocument('1.0', 'UTF-8');
        $this->document->preserveWhiteSpace = false;
        $this->document->formatOutput       = true;
        
        $this->element = $this->document->createElement($this->getNodeName());
        $this->document->appendChild($this->element);
        $this->setAtributes($this->element, $this->getAttr());
    }
    
    /**
     * Añadir un nuevo nodo.
     *
     * @param Node $node
     *
     * @return void
     */
    public function add(Node $node)
    {
        $wrapperElement = null;
        
        $nodeElement = $this->document->createElement($node->getNodeName());
        $this->setAtributes($nodeElement, $node->getAttr());
        
        foreach ($node->element->childNodes as $child) {
            $nodeElement->appendChild(
                $this->document->importNode($child, true)
            );
        }
        
        if ($wrapperName = $node->getWrapperNodeName()) {
            $wrapperElement = $this->getDirectChildElementByName(
                $this->element->childNodes,
                $wrapperName
            );
            
            if (!$wrapperElement) {
                $wrapperElement = $this->document->createElement($wrapperName);
                $this->element->appendChild($wrapperElement);
                $this->setAtributes($wrapperElement, $node->getAttr('wrapper'));
            }
        }
        
        if ($parentName = $node->getParentNodeName()) {
            $currentElement = ($wrapperElement) ? $wrapperElement : $this->element;
            
            $parentNode = $this->getDirectChildElementByName(
                $currentElement->childNodes,
                $parentName
            );
            
            if (!$parentNode) {
                $parentElement = $this->document->createElement($parentName);
                $currentElement->appendChild($parentElement);
                $parentElement->appendChild($nodeElement);
                $this->setAtributes($parentElement, $node->getAttr('parent'));
            } else {
                $parentNode->appendChild($nodeElement);
            }
        } else {
            $this->element->appendChild($nodeElement);
        }
    }
    
    /**
     * Buscar el hijo directo de un elemento.
     *
     * @param DOMNodeList $children
     * @param string      $find
     *
     * @return DOMElement|null
     */
    protected function getDirectChildElementByName(DOMNodeList $children, string $find)
    {
        foreach ($children as $child) {
            if ($child->nodeName == $find) {
                return $child;
            }
        }
        return null;
    }
    
    /**
     * Agrega atributos a un elemento.
     *
     * @param DOMElement $element
     * @param array|null $attr
     *
     * @return void
     */
    public function setAtributes(DOMElement $element, array $attr = null)
    {
        if (!is_null($attr)) {
            foreach ($attr as $key => $value) {
                $element->setAttribute($key, $value);
            }
        }
    }
    
    /**
     * Obtener elemento
     *
     * @return DOMElement
     */
    public function getElement()
    : DOMElement
    {
        return $this->element;
    }
    
    /**
     * Obtener documento
     *
     * @return DOMDocument
     */
    public function getDocument()
    : DOMDocument
    {
        return $this->document;
    }
    
    /**
     * Obtener atributos de nodo.
     *
     * @param string $index
     *
     * @return array|null
     */
    public function getAttr(string $index = 'node')
    {
        $attrIndex = ['node', 'parent', 'wrapper'];
        
        if (in_array($index, $attrIndex)) {
            $index = array_search($index, $attrIndex);
        } else {
            $index = 0;
        }
        
        return (isset($this->attr[$index])) ? $this->attr[$index] : null;
    }
    
    /**
     * Obtener el nombre del nodo contenedor.
     *
     * @return string|null
     */
    public function getWrapperNodeName()
    {
        return (isset($this->wrapperNodeName)) ? $this->wrapperNodeName : null;
    }
    
    /**
     * Obtener el nombre del nodo primario.
     *
     * @return string|null
     */
    public function getParentNodeName()
    {
        return $this->parentNodeName;
    }
    
    /**
     * Obtener el nombre del nodo.
     *
     * @return string
     */
    public function getNodeName()
    : string
    {
        if (!is_string($this->nodeName) || '' === $this->nodeName) {
            throw new LogicException('El nodo de la clase ' . get_class($this) . ' no tiene nombre de nodo');
        }
        return $this->nodeName;
    }
}

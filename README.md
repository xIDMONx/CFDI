# XML_CFDI 3.3

# CFDI
```php
use xIDMONx\CFDI\CFDI;

$cer = file_get_contents('XAX010101000.cer.pem');
$key = file_get_contents('XAX010101000.key.pem');

$cfdi = new CFDI([
    'Serie'             => 'A',
    'Folio'             => 'A0101',
    'Fecha'             => '2020-06-23T09:23:32',
    'FormaPago'         => '01',
    'NoCertificado'     => '00000000000000000000',
    'CondicionesDePago' => '',
    'SubTotal'          => '',
    'Descuento'         => '0.00',
    'Moneda'            => 'MXN',
    'TipoCambio'        => '1.0',
    'Total'             => '',
    'TipoDeComprobante' => 'I',
    'MetodoPago'        => 'PUE',
    'LugarExpedicion'   => '64000',
], $cer, $key);
```

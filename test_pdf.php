<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml('<h1>Hello, Vee!</h1><p>This is your PDF test.</p>');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("test_output.pdf", ["Attachment" => false]);

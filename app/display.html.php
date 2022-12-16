<?php
    include __DIR__ .'/dump.php';
    $filename = $_GET['filename'];
    $filepath = dirname(__DIR__).'/pdfs/'.$filename;
    $pdf = file_get_contents($filepath);
?>
    <object data="data:application/pdf;base64,<?php echo base64_encode($pdf) ?>" type="application/pdf" height="100%" width="100%"></object>

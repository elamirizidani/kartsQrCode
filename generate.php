<?php
require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;

$usrName = "fb123456789";

$text ="http://localhost:8888/karts/couple/".$usrName;

$qr_code = QrCode::create($text)
    ->setSize(500)
    ->setMargin(40)
    ->setForegroundColor(new Color(255,128,0))
    ->setBackgroundColor(new Color(153,204,255));

$label = Label::create("This is Wedding")
    ->setTextColor(new Color(255,0,0));
    
$logo = Logo::create("./assets/imgs/wedding.png")
    ->setResizeToWidth(150)
    ->setPath("./assets/imgs/wedding.png");

$writer = new PngWriter;
$result = $writer->write($qr_code,logo:$logo, label: $label);
// $result = $writer->write($qr_code, label:$label);
$result->saveToFile('qrCodes/'.$usrName.'.png');

header("Content-Type:" . $result->getMimeType());
echo $result->getString();
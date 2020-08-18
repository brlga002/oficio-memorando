<?php


namespace Source\Support;
use Exception;
use Endroid\QrCode\QrCode;

class QrcodeGerate
{
    private $qrCode;
    private $error;

    public function __construct($text)
    {
        try{
            $this->qrCode = new QrCode($text);
            $this->qrCode->writeFile(__DIR__ . "/../../tmp/qrcode.png");
            return Url("tmp/qrcode.png");
        } catch (Exception $exception) {
            $this->error = $exception;
            return "";
        }
    }

    public function geturl(): string
    {
        return Url("tmp/qrcode.png");
    }

    public function error(): ?Exception
    {
        return $this->error;
    }


}
<?php

class WriteBin
{
    private $data = '';

    private $byte = "\0";

    private $index = 0;

    public function writeBits(string $str): void
    {
        for ($i=0; $i < strlen($str); $i++) { 
            $bit = (bool) $str[$i];
            
            if ($bit) {
                $mask = 1 << (7 - $this->index);
                $this->byte = pack('C', unpack('C', $this->byte)[1] | $mask);
            }

            $this->index++;

            if ($this->index > 7) {
                $this->data .= $this->byte;
                $this->byte = "\0";
                $this->index = 0;
            }
        }
    }

    public function getData(): string
    {
        return $this->index ? $this->data . $this->byte : $this->data;
    }
}
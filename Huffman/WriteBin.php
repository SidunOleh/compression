<?php

class WriteBin
{
    private $data = '';

    private $byte = "\0";

    private $index = 0;

    public function writeBits(string $bits): void
    {
        for ($i=0; $i < strlen($bits); $i++) { 
            $bit = (bool) $bits[$i];
            
            if ($bit) {
                $this->setCurrentBit();
            } else {
                $this->resetCurrentBit();
            }

            $this->index++;

            if ($this->index > 7) {
                $this->data .= $this->byte;
                $this->byte = "\0";
                $this->index = 0;
            }
        }
    }

    public function setCurrentBit(): void
    {
        $mask = 1 << (7 - $this->index);

        $byte = unpack('C', $this->byte)[1];
        $byte |= $mask;

        $this->byte = pack('C', $byte);
    }

    public function resetCurrentBit(): void
    {
        $mask = 255 ^ (1 << (7 - $this->index));

        $byte = unpack('C', $this->byte)[1];
        $byte &= $mask;

        $this->byte = pack('C', $byte);
    }

    public function getData(): string
    {
        return $this->index ? $this->data . $this->byte : $this->data;
    }
}
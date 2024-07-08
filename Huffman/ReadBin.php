<?php

class ReadBin
{
    private $data = '';

    private $index = 0;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function readBit(): int|false
    {
        $bytesOffset = floor($this->index / 8);

        if ($bytesOffset > strlen($this->data)) {
            return false;
        }
        
        $byte = substr($this->data, $bytesOffset, 1);
        
        $bitNumber = $this->index - $bytesOffset * 8;

        $this->index++;

        return ord($byte) & (1 << 7 - $bitNumber) ? 1 : 0;
    }
}
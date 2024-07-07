<?php

class PriorityQueue extends SplPriorityQueue
{
    public function compare($priority1, $priority2): int 
    {
        return $priority2 - $priority1; 
    }
}
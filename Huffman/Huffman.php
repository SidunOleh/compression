<?php

require_once 'Node.php';
require_once 'PriorityQueue.php';
require_once 'WriteBin.php';
require_once 'ReadBin.php';

class Huffman
{
    public static function buildTree(string $str): Node
    {
        $queue = new PriorityQueue();
        $queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
    
        $chars = array_count_values(str_split($str));
        $chars['EOF'] = 1;
        foreach ($chars as $char => $frequency) {
            $queue->insert(new Node($char), $frequency);
        }
    
        while ($queue->count() > 1) {
            $left = $queue->extract();
            $right = $queue->extract();
            $node = new Node(null, $left['data'], $right['data']);
            $queue->insert($node,  $left['priority'] + $right['priority']);
        }
    
        return $queue->extract()['data'];
    }

    public static function getDictionary(Node $node, string $code, array &$dictionary): void
    {
        if (isset($node->char)) {
            $dictionary[$node->char] = $code;
            return;
        }
    
        self::getDictionary($node->left, $code.'0', $dictionary);
        self::getDictionary($node->right, $code.'1', $dictionary);
    }

    public static function encode(string $str, array $dictionary) : string 
    {
        $encoded = new WriteBin;
        foreach (str_split($str) as $char) {
            $encoded->writeBits($dictionary[$char]);
        }

        $encoded->writeBits($dictionary['EOF']);
    
        return $encoded->getData();
    }

    public static function decode(string $encoded, Node $root) : string 
    {
        $decoded = '';
        $encoded = new ReadBin($encoded);
        $current = $root;
        while (($bit = $encoded->readBit()) !== false) {
            $current = $bit == 0 ? $current->left : $current->right;

            if (isset($current->char)) {
                if ($current->char == 'EOF') {
                    break;
                }

                $decoded .= $current->char;
                $current = $root;
            }
        }
    
        return $decoded;
    }
}
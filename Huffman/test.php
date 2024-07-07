<?php

require_once 'Huffman.php';

$str = 'Hello, world!';

$root = Huffman::buildTree($str);

$dictionary = [];
Huffman::getDictionary($root, '', $dictionary);

$encoded = Huffman::encode($str, $dictionary);

$decoded = Huffman::decode($encoded, $root);
echo $decoded;
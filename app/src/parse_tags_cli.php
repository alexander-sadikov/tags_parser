#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

if($argc < 2) {
    echo "Usage: parse_tags_cli.php '<text_with_tags>'\n";
    exit(1);
}

$inputText = $argv[1];
$parsedTags = TagsParser::parseTags($inputText);

echo json_encode($parsedTags, JSON_PRETTY_PRINT) . "\n";
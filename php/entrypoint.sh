#!/usr/bin/env bash

chmod +x /tags_parser/src/parse_tags_cli.php

composer install --working-dir=/tags_parser

tail -f /dev/null
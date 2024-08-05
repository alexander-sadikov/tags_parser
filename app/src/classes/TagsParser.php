<?php

use Exceptions\DuplicateTagsException;

class TagsParser
{
    /**
     * @throws Exception
     */
    public static function parseTags(string $text): array
    {
        $pattern = '/\[(\w+):([^\]]*)\](.*?)\[\/\1]/s';
        $matches = [];
        preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

        $result = [];
        foreach($matches as $match) {
            $tagName = $match[1];

            if(isset($result[$tagName]))
                throw new DuplicateTagsException('String can contain only unique tags.');

            $description = $match[2];
            $data = $match[3];
            $result[$tagName] = [
                'description' => $description,
                'data' => $data
            ];
        }

        return $result;
    }
}
<?php


use Exceptions\DuplicateTagsException;
use PHPUnit\Framework\TestCase;

class TagsParserTest extends TestCase
{
    public function testParseTags()
    {
        $text = '[TAG_NAME:description]data[/TAG_NAME]';
        $expected = [
            'TAG_NAME' => [
                'description' => 'description',
                'data' => 'data'
            ]
        ];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }

    public function testParseTagsWithMultipleTags()
    {
        $text = '[TAG1:desc1]data1[/TAG1][TAG2:desc2]data2[/TAG2]';
        $expected = [
            'TAG1' => [
                'description' => 'desc1',
                'data' => 'data1'
            ],
            'TAG2' => [
                'description' => 'desc2',
                'data' => 'data2'
            ]
        ];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }

    public function testParseTagsWithNoTags()
    {
        $text = 'No tags here';
        $expected = [];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }

    public function testParseTagsWithIncompleteTag()
    {
        $text = '[TAG_NAME:description]data';
        $expected = [];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }

    public function testParseTagsWithEmptyString()
    {
        $text = '';
        $expected = [];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }

    public function testParseTagsWithEmptyData()
    {
        $text = '[TAG_NAME:description][/TAG_NAME]';
        $expected = [
            'TAG_NAME' => [
                'description' => 'description',
                'data' => ''
            ]
        ];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }

    public function testParseTagsWithEmptyDescription()
    {
        $text = '[TAG_NAME:]data[/TAG_NAME]';
        $expected = [
            'TAG_NAME' => [
                'description' => '',
                'data' => 'data'
            ]
        ];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }


    public function testParseTagsWithSpecialCharactersInData()
    {
        $text = '[TAG_NAME:description]data with special characters !@#$%^&*()_+[/TAG_NAME]';
        $expected = [
            'TAG_NAME' => [
                'description' => 'description',
                'data' => 'data with special characters !@#$%^&*()_+'
            ]
        ];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }

    public function testParseTagsWithSpecialCharactersInDescription()
    {
        $text = '[TAG_NAME:desc!@#$%^&*()_+]data[/TAG_NAME]';
        $expected = [
            'TAG_NAME' => [
                'description' => 'desc!@#$%^&*()_+',
                'data' => 'data'
            ]
        ];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }

    public function testParseTagsWithMalformedTag()
    {
        $text = '[TAG_NAME:description]data[TAG_NAME]';
        $expected = [];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }

    public function testParseTagsWithSameNameTags()
    {
        $text = '[TAG_NAME:description]data1[/TAG_NAME][TAG_NAME:description2]data2[/TAG_NAME]';

        $this->expectException(DuplicateTagsException::class);

        TagsParser::parseTags($text);
    }

    public function testParseTagsWithNestedLikeContent()
    {
        $text = '[TAG_NAME:description][NESTED_TAG:nested]nested data[/NESTED_TAG][/TAG_NAME]';
        $expected = [
            'TAG_NAME' => [
                'description' => 'description',
                'data' => '[NESTED_TAG:nested]nested data[/NESTED_TAG]'
            ]
        ];
        $this->assertEquals($expected, TagsParser::parseTags($text));
    }
}

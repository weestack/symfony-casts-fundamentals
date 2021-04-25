<?php


namespace App\Service;


class MarkDownHelper
{
    public function parse(String $source): String {
        $parsedQuestion = $cache->get("markdown_".md5($source), function() use ($source, $markdownParser) {
            return $markdownParser->transformMarkdown($source);
        });
    }
}
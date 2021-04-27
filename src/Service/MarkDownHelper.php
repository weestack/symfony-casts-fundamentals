<?php


namespace App\Service;


use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkDownHelper
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var MarkdownParserInterface
     */
    private $markdownParser;

    private $isDebug;
    /**
     * @var LoggerInterface
     */
    private $markdownLogger;

    /**
     * MarkDownHelper constructor.
     * @param MarkdownParserInterface $markdownParser
     * @param CacheInterface $cache
     * @param bool $isDebug
     * @param LoggerInterface $markdownLogger
     */
    public function __construct(MarkdownParserInterface $markdownParser, CacheInterface $cache, bool $isDebug, LoggerInterface $mLogger)
    {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
        $this->isDebug = $isDebug;
        $this->markdownLogger = $mLogger;
    }

    public function parse(String $source): String {



        if ($this->isDebug) {
            $this->markdownLogger->info("Hello world hehe");
            return $this->markdownParser->transformMarkdown($source);
        }

        return $this->cache->get("markdown_".md5($source), function() use ($source) {
            return $this->markdownParser->transformMarkdown($source);
        });
    }
}
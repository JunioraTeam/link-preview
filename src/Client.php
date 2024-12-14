<?php

namespace Dusterio\LinkPreview;

use Dusterio\LinkPreview\Contracts\ParserInterface;
use Dusterio\LinkPreview\Contracts\PreviewInterface;
use Dusterio\LinkPreview\Parsers\HtmlParser;
use Dusterio\LinkPreview\Parsers\YouTubeParser;
use Dusterio\LinkPreview\Parsers\VimeoParser;
use Dusterio\LinkPreview\Models\Link;
use Dusterio\LinkPreview\Exceptions\UnknownParserException;

class Client
{
    /**
     * @var ParserInterface[]
     */
    private array $parsers = [];

    private ?Link $link = null;

    /**
     * @param string|null $url Request address
     */
    public function __construct(?string $url = null)
    {
        if (! is_null($url)) {
            $this->setUrl($url);
        }
        $this->addDefaultParsers();
    }

    public function getLink(): ?Link
    {
        return $this->link;
    }

    /**
     * Try to get previews from as many parsers as possible
     * 
     * @return PreviewInterface[]
     */
    public function getPreviews(): array
    {
        $parsed = [];

        foreach ($this->getParsers() as $name => $parser) {
            if ($parser->canParseLink($this->link))
                $parsed[$name] = $parser->parseLink($this->link)->getPreview();
        }

        return $parsed;
    }

    /**
     * Get a preview from a single parser
     * 
     * @throws UnknownParserException
     */
    public function getPreview(string $parserId): PreviewInterface|bool
    {
        if (array_key_exists($parserId, $this->getParsers())) {
            $parser = $this->getParsers()[$parserId];
        } else throw new UnknownParserException();

        return $parser->parseLink($this->link)->getPreview();
    }

    /**
     * Add parser to the beginning of parsers list
     */
    public function addParser(ParserInterface $parser): self
    {
        $this->parsers = [(string) $parser => $parser] + $this->parsers;

        return $this;
    }

    public function getParser($id): bool|ParserInterface
    {
        return isset($this->parsers[$id]) ? $this->parsers[$id] : false;
    }

    /**
     * Get parsers
     * @return ParserInterface[]
     */
    public function getParsers(): array
    {
        return $this->parsers;
    }

    /**
     * Set parsers
     * @param ParserInterface[] $parsers
     */
    public function setParsers(array $parsers): self
    {
        $this->parsers = $parsers;

        return $this;
    }

    public function getUrl(): string
    {
        return (!empty($this->link->getEffectiveUrl())) ? $this->link->getEffectiveUrl() : $this->link->getUrl();
    }

    public function setUrl(string $url): self
    {
        $this->link = new Link($url);

        return $this;
    }

    /**
     * Remove parser from parsers list
     *
     * @param string $name Parser name
     */
    public function removeParser(string $name): self
    {
        if (in_array($name, $this->parsers, false)) {
            unset($this->parsers[$name]);
        }

        return $this;
    }

    /**
     * Add default parsers
     */
    protected function addDefaultParsers(): void
    {
        $this->addParser(new HtmlParser());
        $this->addParser(new YouTubeParser());
        $this->addParser(new VimeoParser());
    }
}
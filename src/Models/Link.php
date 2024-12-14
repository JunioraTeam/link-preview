<?php

namespace Dusterio\LinkPreview\Models;

use Dusterio\LinkPreview\Contracts\LinkInterface;
use Dusterio\LinkPreview\Exceptions\MalformedUrlException;

/**
 * Class Link
 */
class Link implements LinkInterface
{
    private string $content;

    private string $contentType;

    private string $url;

    private string $effectiveUrl;

    /**
     * @throws MalformedUrlException
     */
    public function __construct(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new MalformedUrlException();
        }

        $this->setUrl($url);
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @inheritdoc
     */
    public function setContent(string $content): static
    {
        $this->content = (string)$content;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @inheritdoc
     */
    public function setContentType(string $contentType): static
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @inheritdoc
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }
    /**
     * @inheritdoc
     */
    public function getEffectiveUrl(): string
    {
        return $this->effectiveUrl;
    }

    /**
     * @inheritdoc
     */
    public function setEffectiveUrl(string $effectiveUrl): static
    {
        $this->effectiveUrl = $effectiveUrl;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isHtml(): bool
    {
        return !strncmp($this->getContentType(), 'text/', strlen('text/'));
    }

    /**
     * @inheritdoc
     */
    public function isImage(): bool
    {
        return !strncmp($this->getContentType(), 'image/', strlen('image/'));
    }

    /**
     * @inheritdoc
     */
    public function isUp(): bool
    {
        return $this->content !== false && $this->contentType !== false;
    }
}

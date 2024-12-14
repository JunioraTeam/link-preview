<?php

namespace Dusterio\LinkPreview\Contracts;

interface LinkInterface
{
    /**
     * LinkInterface constructor.
     */
    public function __construct(string $url);

    /**
     * Get source code
     */
    public function getContent(): string;

    /**
     * Set source code
     */
    public function setContent(string $content): static;

    /**
     * Get source content type (example: text/html, image/jpg)
     */
    public function getContentType(): string;

    /**
     * Set source content type (example: text/html, image/jpg)
     */
    public function setContentType(string $contentType): static;

    /**
     * Get website url
     */
    public function getUrl(): string;

    /**
     * Set website url
     */
    public function setUrl(string $url): static;

    public function getEffectiveUrl(): string;

    public function setEffectiveUrl(string $effectiveUrl): static;

    /**
     * Is this link an HTML page?
     */
    public function isHtml(): bool;

    /**
     * Is this link an image?
     */
    public function isImage(): bool;

    /**
     * Is this link functioning? (could we open it?)
     */
    public function isUp(): bool;
}
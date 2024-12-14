<?php

namespace Dusterio\LinkPreview\Contracts;
use Dusterio\LinkPreview\Models\Preview;

/**
 * Interface ParserInterface
 * @codeCoverageIgnore
 */
interface ParserInterface
{
    /**
     * Set default reader and model
     */
    public function __construct(?ReaderInterface $reader = null, ?PreviewInterface $preview = null);

    /**
     * Parsers name
     */
    public function __toString(): string;

    /**
     * Get reader
     */
    public function getReader(): ReaderInterface;

    /**
     * Set reader
     */
    public function setReader(ReaderInterface $reader): static;

    public function getPreview(): PreviewInterface;

    public function setPreview(PreviewInterface $preview): static;

    /**
     * Can this parser parse the link supplied?
     */
    public function canParseLink(LinkInterface $link): bool;

    /**
     * Parse link
     */
    public function parseLink(LinkInterface $link): static;
}
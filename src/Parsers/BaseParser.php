<?php

namespace Dusterio\LinkPreview\Parsers;

use Dusterio\LinkPreview\Contracts\LinkInterface;
use Dusterio\LinkPreview\Contracts\ReaderInterface;
use Dusterio\LinkPreview\Contracts\PreviewInterface;

abstract class BaseParser
{
    private ReaderInterface $reader;

    private PreviewInterface $preview;

    /**
     * @inheritdoc
     */
    public function getPreview(): PreviewInterface
    {
        return $this->preview;
    }

    /**
     * @inheritdoc
     */
    public function setPreview(PreviewInterface $preview): static
    {
        $this->preview = $preview;

        return $this;
    }

    public function getReader(): ReaderInterface
    {
        return $this->reader;
    }

    public function setReader(ReaderInterface $reader): static
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * Read link
     */
    protected function readLink(LinkInterface $link): LinkInterface
    {
        return $this->getReader()->readLink($link);
    }
}
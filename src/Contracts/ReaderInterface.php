<?php

namespace Dusterio\LinkPreview\Contracts;

/**
 * Interface ReaderInterface
 * @codeCoverageIgnore
 */
interface ReaderInterface
{
    public function readLink(LinkInterface $link): LinkInterface;

    public function config(array $parameters): void;
}
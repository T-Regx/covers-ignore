<?php
namespace TRegx\CoversIgnore\FileSystem;

use Generator;
use IteratorAggregate;

class Directory implements IteratorAggregate
{
    public function __construct(private string $filename)
    {
    }

    /**
     * @return Generator<File>|iterable<File>
     */
    public function getIterator(): Generator
    {
        foreach ($this->recursiveFiles() as [$filename]) {
            yield new File($filename);
        }
    }

    private function recursiveFiles(): \RegexIterator
    {
        $children = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->filename));
        return new \RegexIterator($children, '/^.+\.php$/i', \RegexIterator::GET_MATCH);
    }
}

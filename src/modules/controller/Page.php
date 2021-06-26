<?php


namespace modules\controller;


class Page
{
    private $root;
    private $self;

    public function __construct(string $file)
    {
        $this->root = dirname($file);
        $this->self = $file;
    }

    public function getSelf(): string
    {
        return $this->self;
    }
}


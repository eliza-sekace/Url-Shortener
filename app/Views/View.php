<?php
namespace App\Views;

class View
{
    private string $path;
    private array $variables;

    public function __construct(?string $path, $variables = [])
    {
        $this->path = $path;
        $this->variables = $variables;
    }

    public function getPath():string
    {
        return $this->path;
    }

    public function getVariables():array
    {
        return $this->variables;
    }
}
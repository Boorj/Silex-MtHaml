<?php
namespace SilexMtHaml;

use \Twig_Source;
use MtHaml\Environment;

class Lexer implements \Twig_LexerInterface
{
    private $environment;
    /* @var \Twig_Lexer $lexer */
    private $lexer;

    public function __construct(Environment $environment, \Twig_LexerInterface $lexer)
    {
        $this->environment = $environment;
        $this->lexer = $lexer;
    }

    public function tokenize($code, $filename = null)
    {
        if ($code instanceof Twig_Source) {
            if ($filename === null)
                $filename = $code->getName();
            $code = $code->getCode();
        }

        if (null !== $filename && preg_match('/\.haml$/', $filename)) {
            $code = $this->environment->compileString($code, $filename);
        }

        $source = new Twig_Source($code, $filename);
        return $this->lexer->tokenize($source);
    }
}

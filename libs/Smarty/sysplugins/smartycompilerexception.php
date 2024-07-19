<?php

/**
 * Smarty compiler exception class
 *
 * @package Smarty
 */
class SmartyCompilerException extends SmartyException
{
    /**
     * @return string
     */
    public function __toString()
    {
        return ' --> Smarty Compiler: ' . $this->message . ' <-- ';
    }

    /**
     * Proprietà personalizzata per il numero di linea dell'errore
     *
     * @var int|null
     */
    private ?int $customLine = null;

    /**
     * The template source snippet relating to the error
     *
     * @var string|null
     */
    public ?string $source = null;

    /**
     * The raw text of the error message
     *
     * @var string|null
     */
    public ?string $desc = null;

    /**
     * The resource identifier or template name
     *
     * @var string|null
     */
    public ?string $template = null;

    /**
     * Imposta il numero di linea personalizzato
     *
     * @param int|null $line
     */
    public function setCustomLine(?int $line)
    {
        $this->customLine = $line;
    }

    /**
     * Ottiene il numero di linea personalizzato
     *
     * @return int|null
     */
    public function getCustomLine(): ?int
    {
        return $this->customLine;
    }
}

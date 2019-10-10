<?php declare(strict_types=1);

namespace Surda\UI\Control;

use Surda\UI\Control\Exception\InvalidArgumentException;

trait ThemeableControls
{
    /** @var array */
    private $templates = [];

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void
    {
        $this->setTemplateByType('default', $template);
    }

    /**
     * @param array $templates
     */
    public function setTemplates(array $templates): void
    {
        foreach ($templates as $type => $template) {
            $this->setTemplateByType((string) $type, $template);
        }
    }

    /**
     * @param string $type
     * @param string $templateFile
     * @throws InvalidArgumentException
     */
    public function setTemplateByType(string $type, string $templateFile): void
    {
        $realTemplateFile = realpath($templateFile);

        if ($realTemplateFile === FALSE) {
            throw new InvalidArgumentException(sprintf("Template file '%s' does not exist.", $templateFile));
        }

        $this->templates[$type] = $realTemplateFile;
    }

    /**
     * @param string $type
     * @return string
     * @throws InvalidArgumentException
     */
    public function getTemplateByType(string $type): string
    {
        if (array_key_exists($type, $this->templates)) {
            return $this->templates[$type];
        }

        throw new InvalidArgumentException(sprintf("Template file of type '%s' is not registered.", $type));
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function getDefaultTemplate(): string
    {
        if (array_key_exists('default', $this->templates)) {
            return $this->templates['default'];
        }

        throw new InvalidArgumentException('Default template file is not registered.');
    }
}
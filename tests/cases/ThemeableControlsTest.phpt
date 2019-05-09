<?php declare(strict_types=1);

namespace Tests\Surda\UI\Control;

use Surda\UI\Control\Exception\InvalidArgumentException;
use Tests\Surda\UI\Control\Mock\ControlMock;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class ThemeableControlsTest extends TestCase
{
    public function testDefaultTemplate()
    {
        $template = __DIR__ . '/files/template1.latte';

        $mock = new ControlMock();
        $mock->setTemplate($template);

        Assert::same($template, $mock->getDefaultTemplate());
        Assert::same($template, $mock->getTemplateByType('default'));
    }

    public function testTemplates()
    {
        $template1 = __DIR__ . '/files/template1.latte';
        $template2 = __DIR__ . '/files/template2.latte';

        $mock = new ControlMock();
        $mock->setTemplateByType('default', $template1);
        $mock->setTemplateByType('foo', $template2);

        Assert::same($template1, $mock->getDefaultTemplate());
        Assert::same($template1, $mock->getTemplateByType('default'));
        Assert::same($template2, $mock->getTemplateByType('foo'));
    }

    public function testException()
    {
        $template = __DIR__ . '/files/bad.latte';

        $mock = new ControlMock();

        Assert::exception(
            function () use ($mock, $template): void {
                $mock->setTemplate($template);
            }, InvalidArgumentException::class, sprintf("Template file '%s' does not exist.", $template)
        );

        Assert::exception(
            function () use ($mock, $template): void {
                $mock->getDefaultTemplate();
            }, InvalidArgumentException::class, "Default template file is not registered."
        );

        Assert::exception(
            function () use ($mock, $template): void {
                $mock->getTemplateByType('foo');
            }, InvalidArgumentException::class, "Template file of type 'foo' is not registered."
        );
    }
}

(new ThemeableControlsTest())->run();
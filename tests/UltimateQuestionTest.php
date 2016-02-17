<?php
namespace Test;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Exception\NoSuchElementException;

/**
 * Class UltimateQuestionTest
 */
class UltimateQuestionTest extends AbstractSeleniumTestCase
{
    /**
     * Check if the ultimate answer isn't changed
     *
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function testUltimateQuestion()
    {
        $this->webDriver->get('http://www.google.be');
        $this->webDriver->findElement(WebDriverBy::id('lst-ib'))
            ->sendKeys('Answer to the Ultimate Question of Life, the Universe, and Everything');

        $this->webDriver->wait(10, 300)
            ->until(
                function ($webDriver) {
                    /** @var WebDriver $webDriver */
                    try {
                        $webDriver->findElement(WebDriverBy::id('cwos'));
                        return true;
                    } catch (NoSuchElementException $ex) {
                        return false;
                    }
                }
            );

        $element = $this->webDriver->findElement(WebDriverBy::id('cwos'));
        $this->assertEquals('42', $element->getText());

        $this->takeScreenshot(__FUNCTION__);

        $element = $this->webDriver->findElement(WebDriverBy::id('cwmcwd'));
        $this->takeScreenshot(__FUNCTION__ . '-detail', $element);
    }
}
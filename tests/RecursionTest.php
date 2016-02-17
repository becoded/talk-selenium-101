<?php
namespace Test;

use Facebook\WebDriver\WebDriverBy;

/**
 * Class RecursionTest
 */
class RecursionTest extends AbstractSeleniumTestCase
{
    /**
     * Test if recursion is still working
     *
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function testRecursion()
    {
        $this->webDriver->get('http://www.google.be');
        $this->webDriver->findElement(WebDriverBy::id('lst-ib'))
            ->sendKeys('Recursion')
            ->submit();

        $this->webDriver->wait(10, 300)
            ->until(
                function ($webDriver) {
                    try {
                        $webDriver->findElement(WebDriverBy::cssSelector('a.spell'));
                        return true;
                    } catch (NoSuchElementException $ex) {
                        return false;
                    }
                }
            );

        $aSpellElement = $this->webDriver->findElement(WebDriverBy::cssSelector('a.spell'));
        $this->assertEquals("Recursion", $aSpellElement->getText());
        $aSpellElement->click();
        $this->takeScreenshot(__FUNCTION__);
    }
}
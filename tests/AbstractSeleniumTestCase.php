<?php
namespace Test;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use PHPUnit_Framework_TestCase as TestCase;
use RuntimeException;

/**
 * Class AbstractSeleniumTestCase
 */
abstract class AbstractSeleniumTestCase extends TestCase
{

    /**
     * @var string
     */
    protected $webDriverUrl = 'http://127.0.0.1:4444/wd/hub';

    /**
     * @var RemoteWebDriver
     */
    protected $webDriver;

    /**
     * Setup test case
     */
    public function setUp()
    {
        // DesiredCapabilities::chrome();
        $this->webDriver = RemoteWebDriver::create($this->webDriverUrl, DesiredCapabilities::firefox());
    }

    /**
     * Tear down test case
     */
    public function tearDown()
    {
        if ($this->webDriver) {
            $this->webDriver->quit();
        }
    }

    /**
     * @param string $prefix
     * @return string
     */
    protected function getScreenshotPath($prefix)
    {
        $paths = [
            dirname(__DIR__),
            'screenshots',
            str_replace('\\', DIRECTORY_SEPARATOR, get_class($this)),
        ];

        $screenshotPath =  implode(DIRECTORY_SEPARATOR, $paths);
        if (!file_exists($screenshotPath)) {
            mkdir($screenshotPath, 0766, true);
        }

        return $screenshotPath . '/' . $prefix . '-' . date('YmdHis') . '.png';
    }

    /**
     * @param string $prefix
     * @param RemoteWebElement $element
     *
     * @return string
     * @throws RuntimeException
     */
    protected function takeScreenshot($prefix, RemoteWebElement $element = null)
    {
        $screenshotPath = $this->getScreenshotPath($prefix);
        $this->webDriver->takeScreenshot($screenshotPath);

        if (!file_exists($screenshotPath)) {
            throw new RuntimeException('Could not save screenshot');
        }

        if ($element === null) {
            return $screenshotPath;
        }

        $elementWidth = $element->getSize()->getWidth();
        $elementHeight = $element->getSize()->getHeight();

        $elementSrcX = $element->getLocation()->getX();
        $elementSrcY = $element->getLocation()->getY();

        // Create image instances
        $src = imagecreatefrompng($screenshotPath);
        $dest = imagecreatetruecolor($elementWidth, $elementHeight);

        // Copy
        imagecopy($dest, $src, 0, 0, $elementSrcX, $elementSrcY, $elementWidth, $elementHeight);
        imagepng($dest, $screenshotPath);

        if (!file_exists($screenshotPath)) {
            throw new RuntimeException('Could not save screenshot');
        }
    }
}

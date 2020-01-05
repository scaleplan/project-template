<?php

namespace Helper;

use Codeception\Lib\InnerBrowser;
use Codeception\Lib\ModuleContainer;
use Codeception\Module\REST;

/**
 * Class CustomREST
 *
 * @package Helper
 */
class CustomREST extends REST
{
    protected const COOKIE_NAME = 'phpbrowser';
    protected const COOKIE_VALUE = 1;

    /**
     * @var InnerBrowser
     */
    protected $innerBrowser;

    /**
     * CustomREST constructor.
     *
     * @param ModuleContainer $moduleContainer
     * @param null $config
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        $this->innerBrowser = $this->getModule('InnerBrowser');
        parent::__construct($moduleContainer, $config);
    }

    /**
     * @param $url
     * @param array $params
     * @param array $files
     */
    public function sendPOSTFromPhpBrowser($url, $params = [], $files = []) : void
    {
        $this->innerBrowser->setCookie(static::COOKIE_NAME, static::COOKIE_VALUE);
        $this->sendPOST($url, $params, $files);
    }
}

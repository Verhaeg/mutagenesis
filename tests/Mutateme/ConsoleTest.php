<?php
/**
 * Mutateme
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mutateme/blob/rewrite/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mutateme
 * @package    Mutateme
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mutateme/blob/rewrite/LICENSE New BSD License
 */

class Mutateme_ConsoleTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->root = dirname(__FILE__) . '/_files/root/base1';
    }

    public function testConsoleSetsRunnerBaseDirectoryFromCommandLineOptions()
    {
        $runner = new \Mutateme\Runner;
        \Mutateme\Console::main(array('basedir'=>$this->root), $runner);
        $this->assertEquals($this->root, $runner->getBaseDirectory());
    }

    public function tearDown()
    {
        spl_autoload_unregister('\Mutateme\Loader::loadClass');
    }

}

<?php some_syntax_error

class PassTest extends PHPUnit_Framework_TestCase
{

    /**
     * @group PHPUnitRunnerTesting
     */
    public function testSomePass()
    {
        $this->assertTrue(true);
    }

}

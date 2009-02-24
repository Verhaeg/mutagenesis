<?php

class Mutateme_Runkit
{
    protected $_methodPreserveCode = '';

    public function applyMutation(array $mutation)
    {

        require_once $mutation['mutation']->getFilename();
        $newBlock = $mutation['mutation']->mutate($mutation['tokens'], $mutation['index']);
        $this->_methodPreserveCode = md5($mutation['method']);
        if(runkit_method_rename($mutation['class'], $mutation['method'], $mutation['method'].$this->_methodPreserveCode) == false) {
            throw new Exception("Runkit Rename failed: ".$mutation['class']."::".$mutation['method']." into ".$mutation['method'].$this->_methodPreserveCode);
        }
        if(runkit_method_add($mutation['class'], $mutation['method'], $mutation['args'], $newBlock, $this->getMethodFlags($mutation)) == false) {
            throw new Exception("Runkit Add failed: ".$mutation['class']."::".$mutation['method']."(".var_export($mutation['args']).") with ".$newBlock);
        }
    }

    public function reverseMutation(array $mutation)
    {
        if(runkit_method_remove($mutation['class'], $mutation['method']) == false) {
            throw new Exception("Runkit Remove failed: ".$mutation['class']."::".$mutation['method']);
        }
        if(runkit_method_rename($mutation['class'], $mutation['method'].$this->_methodPreserveCode, $mutation['method']) == false) {
            throw new Exception("Runkit Rename failed: ".$mutation['class']."::".$mutation['method'].$this->_methodPreserveCode." into ".$mutation['method']);
        }
    }

    public function getMethodFlags(array $mutation)
    {
        $reflectionClass = new ReflectionClass($mutation['class']);
        $reflectionMethod = $reflectionClass->getMethod($mutation['method'].$this->_methodPreserveCode);
        $static = null;
        $access = null;
        if ($reflectionMethod->isPublic()) {
            $access = RUNKIT_ACC_PUBLIC;
        } elseif ($reflectionMethod->isProtected()) {
            $access = RUNKIT_ACC_PROTECTED;
        } elseif ($reflectionMethod->isPrivate()) {
            $access = RUNKIT_ACC_PRIVATE;
        }
        // see http://www.github.com/padraic/runkit fork for the extension code to support static methods
        if (defined('RUNKIT_ACC_STATIC') && $reflectionMethod->isStatic()) {
            $static = RUNKIT_ACC_STATIC;
        }
        if (!is_null($static)) {
            return $access | $static;
        }
        return $access;
    }
}

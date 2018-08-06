<?php

namespace common;

class DebugFunction
{
    public function debug($arr)
    {
        echo '<pre>'.print_r($arr).'</pre>';
    }
}
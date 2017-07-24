<?php

namespace App\Http\Requests\Traits;

trait CommonRequestTrait
{
    protected function getSegmentFromEnd($position_from_end = 1) {
        $segments = $this->segments();
        return $segments[sizeof($segments) - $position_from_end];
    }
}
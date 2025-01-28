<?php

abstract class Node
{
    private $id;

    function __construct($id)
    {
        $this->id = $id;
    }
}

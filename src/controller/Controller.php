<?php

namespace DragonQuiz\Controller;

abstract class Controller
{
    public function __construct() {

    }

    abstract public function run();
}
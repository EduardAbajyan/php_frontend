<?php

class UserController {

    public function __construct() {
        AuthMidlewares::requireAuth();
    }

    public function index() {
        echo "User Controller Index";
    }
}
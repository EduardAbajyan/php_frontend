<?php

class AdminController {
    
    public function __construct() {
        AuthMidlewares::requireAdmin();
    }

    public function index() {
        echo "Admin Page";
    }
}
<?php

namespace App\Controllers;

/**
 * Class HomeController
 * 
 * This controller handles requests related to the home page.
 */
class HomeController
{

    /**
     * HomeController constructor.
     * 
     * Initializes any dependencies or setup required for the home page.
     */
    public function __construct()
    {
        // Constructor logic
    }

    /**
     * Display the home page.
     */
    public function index()
    {
        return view('home');
    }
}

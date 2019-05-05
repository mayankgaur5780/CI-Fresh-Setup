<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load_view('dashboard');
    }

    public function get_stats()
    {
        $response = [];
        $response['total_users'] = \Models\User::where('status', 1)->count();
        echo json_encode($response);
    }
}

<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show_404($page = '', $log_error = true)
    {
        echo $this->show_error(null, null, 'custom404', 404);
    }
}

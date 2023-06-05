<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 

class MY_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function reindex_by_key($input, $key = 'id')
    {
        if ( ! is_array($input))
        {
            return $input;
        }
        
        // FROM:  http://codeigniter.com/forums/viewthread/193209/
        $result = array();
        foreach($input AS $i)
        {
            $result[$i[$key]] = $i;
        }
        return $result;
    }
    
}


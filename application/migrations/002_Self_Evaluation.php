<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Self_Evaluation extends CI_Migration
{
    /**
     * Config settings
     * @var array
     */
    private $settings;

    private function get_settings()
    {
        $this->settings['eval'] = 'self_evaluation';
    }

    public function up()
    {
        $this->get_settings();
        /**************** Start Create Tables ****************/
        $fields = array(
            'selfcomment' => array('type' => 'VARCHAR', 'constraint' => '100', 'unsigned' => TRUE, 'null' => TRUE, 'after' => 'email')
        );
        $this->dbforge->add_column($this->settings['eval'], $fields);

        /**************** End Create Tables ****************/
        /**************** Start Set Foreign Keys ****************/
        /**************** End Set Foreign Keys ****************/
        /**************** Start Insert Data ****************/
        /**************** End Insert Data ****************/
    }

    public function down()
    {
        //Load settings
        $this->get_settings();
    }
}
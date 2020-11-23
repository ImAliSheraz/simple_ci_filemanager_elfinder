<?php

defined('BASEPATH') or exit('No direct script access allowed');
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 3600);

class Filemanagers extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
        $this->load->helper('path');
        $this->load->helper('file');
        $this->data['page_title'] = 'File Manager';
    }
    public function index()
    {

        $this->render_template('filesystem/index', $this->data);
    }

    public function elfinder_init()
    {
        $_allowed_files = explode('|', 'gif|png|jpeg|jpg|pdf|doc|txt|docx|xls|zip|rar|xls|mp4|ico');
        $config_allowed_files = array();
        if (is_array($_allowed_files)) {
            foreach ($_allowed_files as $v_extension) {
                array_push($config_allowed_files, '.' . $v_extension);
            }
        }

        $allowed_files = array();
        if (is_array($config_allowed_files)) {
            foreach ($config_allowed_files as $extension) {
                $_mime = get_mime_by_extension($extension);
                if ($_mime == 'application/x-zip') {
                    array_push($allowed_files, 'application/zip');
                }
                if ($extension == '.exe') {
                    array_push($allowed_files, 'application/x-executable');
                    array_push($allowed_files, 'application/x-msdownload');
                    array_push($allowed_files, 'application/x-ms-dos-executable');
                }
                array_push($allowed_files, $_mime);
            }
        }

        $root_options = array(
            'driver' => 'LocalFileSystem',
            'path' => set_realpath('filemanager'),
            'URL' => base_url('filemanagers') . '/',
            'uploadMaxSize' => $this->config->item('file_max_size') . 'M',
            'accessControl' => 'access',
            'uploadAllow' => $allowed_files,
            'uploadDeny' => [
                'application/x-httpd-php',
                'application/php',
                'application/x-php',
                'text/php',
                'text/x-php',
                'application/x-httpd-php-source',
                'application/perl',
                'application/x-perl',
                'application/x-python',
                'application/python',
                'application/x-bytecode.python',
                'application/x-python-bytecode',
                'application/x-python-code',
                'wwwserver/shellcgi',
            ],
            'uploadOrder' => array('allow', 'deny'),
            'attributes' => array(
                array('pattern' => '/.tmb/', 'hidden' => true),
                array('pattern' => '/.quarantine/', 'hidden' => true)
            )
        );


        $user = $this->db->where('id', $this->session->userdata('id'))->get('users')->row();
        $path = set_realpath('filemanager/' . $user->media_path_slug);
        if (empty($user->media_path_slug)) {
            $this->db->where('id', $user->id);
            $slug = $user->username;
            $this->db->update('users', array(
                'media_path_slug' => $slug
            ));
            $user->media_path_slug = $slug;
            $path = set_realpath('filemanager/' . $user->media_path_slug);
        }
        if (!is_dir($path)) {
            mkdir($path);
        }
        if (!file_exists($path . '/index.html')) {
            fopen($path . '/index.html', 'w');
        }
        array_push($root_options['attributes'], array(
            'pattern' => '/.(' . $user->media_path_slug . '+)/', // Prevent deleting/renaming folder
            'read' => true,
            'write' => true,
            'locked' => true
        ));
        $root_options['path'] = $path;
        $root_options['URL'] = base_url('filemanager/' . $user->media_path_slug) . '/';


        $data = array(
            'roots' => array(
                $root_options
            )
        );
        $this->load->library('elfinder_lib', $data);
    }
}

<?php
/*
    Staff portfolio plugins for wordpress
    Copyright (C) 2012  Fazle Elahee

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */
class Staff{
    private $post_id;
    private $data;
    private $table;
    public function __construct($post_id = '') {
        global $wpdb;
        $this->table = $wpdb->prefix."staff_portfolio";
        if($post_id != ''){
            $this->load($post_id);
        }
    }
    
    public function load($post_id) {
        global $wpdb;
        $this->post_id = $post_id;
        
        
        $sql = "SELECT * FROM {$this->table} WHERE post_id = '{$post_id}'";
        $this->data = $wpdb->get_row($sql, ARRAY_A);
        if(empty($this->data)) {
            $this->data = array();
        } 
    }
    
    public function save($obj) {
        $staff_data = array(
            'post_id' => $this->post_id,
            'position' => sanitize_text_field(@$obj['staff_position']),
            'address' => sanitize_text_field(@$obj['staff_address']),
            'work_phone' => sanitize_text_field(@$obj['staff_work_phone']),
            'mobile' => sanitize_text_field(@$obj['staff_mobile']),
            'email' => sanitize_email(@$obj['staff_email']),
            'website' => esc_url(@$obj['staff_website'])
        );

        if(count($this->data) == 0 ) {
            $this->insert($staff_data);
        }
        else {
            $this->update($staff_data);
        }
    }
    private function insert($staff_data) {
        global $wpdb;
        
        $wpdb->insert( 
            $this->table, 
            $staff_data, 
            array( 
                    '%d', 
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
            ) 
        );
        //var_dump($staff_data);
        //exit;
        $this->data =  $staff_data;
    } 
    private function update($staff_data) {
        global $wpdb;
        $wpdb->update( 
            $this->table, 
            $staff_data, 
            array( 'id' => $this->getProperty('id')), 
            array( 
                    '%d', 
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
            ), 
            array( '%d' ) 
        );
        $this->data =  $staff_data;
    } 
    
    public function getProperty($key){
        if(array_key_exists($key, $this->data)) {
            return html_entity_decode(stripcslashes($this->data[$key]));
        }
        return '';
    }
}
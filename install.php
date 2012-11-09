<?php
/*
Description: Content installtion file.
Aurther: Fazle Elahee
Version : 1.0
Date : 28/10/2011

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
/****************************************************************/
/* Install routine for wordpress staff web portfolio plugins
/****************************************************************/

function wp_staff_portfolio_install()
{
    global $wpdb;
    // set tablename
    $table_name 		= $wpdb->prefix . 'staff_portfolio';
    
    $manu_table_found              = false;


    foreach ($wpdb->get_results("SHOW TABLES;", ARRAY_N) as $row)
    {

        if ($row[0] == $table_name) 	                $manu_table_found   = true;
    }

    // add charset & collate like wp core
    $charset_collate = '';

    if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') )
    {
        if ( ! empty($wpdb->charset) )
        $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if ( ! empty($wpdb->collate) )
        $charset_collate .= " COLLATE $wpdb->collate";
    }

    if (! $manu_table_found )
    {
        $sql = "CREATE TABLE $table_name
		(
		        id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        post_id         int,
		        position        varchar(255),
			address         text,
			work_phone      varchar(20),
			mobile          varchar(20),
			email           varchar(255),
                        website         varchar(512)
		) $charset_collate;";
         $wpdb->query($sql);
    }

}
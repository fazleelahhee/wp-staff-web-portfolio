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

$so = new StaffOption();
?>
<script>
jQuery(document).ready(function ($){     
    $("#staff_settings_form").submit(function(e) {
    e.preventDefault();  
    /*tinyMCE.triggerSave(true,true); */
    $.post(
        $(this).attr('action'), 
        $(this).serialize(),
        function(data) {
            if(data.response == 'fail'){
                $(".response_message").html(data.from_email); 
            }
            else {
                $(".response_message").html('Successfully saved'); 
            }
        });
    });  
    
});
</script>
<h2>Staff portfolio settings</h2>
<div class="response_message"></div>
<form name="staff_settings_form" id="staff_settings_form" action="<?php echo site_url();?>" method="post">
<h3> List view settings </h3>    
    <table>
        <tr> <td><strong>Page title</strong></td><td>&nbsp;<input name="list_page_title" type="textbox" value="<?php echo $so->getProperty('list_page_title')  ?>"/></td></tr>
        <tr> <td valign="top"><strong>List page content</strong></td><td>&nbsp;<textarea name="list_page_content" rows="5" cols="70"><?php echo $so->getProperty('list_page_content')  ?></textarea></td></tr>
        
        <tr> <td><strong>Show thumb image</strong></td><td>&nbsp;<input name="list_thumb_image" type="checkbox" value="1" <?php echo $so->getProperty('list_thumb_image') == '1'? "checked='checked'": ''; ?>/></td></tr>
        <tr> <td><strong>Image Height</strong></td><td>&nbsp;<input name="list_thumb_image_height" type="textbox" value="<?php echo $so->getProperty('list_thumb_image_height'); ?>" style="width:30px;" />px</td></tr>
        <tr> <td><strong>Image Width</strong></td><td>&nbsp;<input name="list_thumb_image_width" type="textbox" value="<?php echo $so->getProperty('list_thumb_image_width'); ?>" style="width:30px;" />px</td></tr>
        <tr> <td><strong>Show Job Title</strong></td><td>&nbsp;<input name="list_job_title" type="checkbox" value="1" <?php echo $so->getProperty('list_job_title') == '1'? "checked='checked'": ''; ?>/></td></tr>
    </table>    
 <h3> Portfolio view settings </h3>      
    <table>
        <tr> <td><strong>Show Job Title</strong></td><td>&nbsp;<input name="show_job_title" type="checkbox" value="1" <?php echo $so->getProperty('show_job_title') == '1'? "checked='checked'": ''; ?>/></td></tr>
        <tr> <td><strong>Show Address</strong></td><td>&nbsp;<input name="show_address" type="checkbox" value="1" <?php echo $so->getProperty('show_address') == '1'? "checked='checked'": ''; ?>/></td></tr>
        <tr> <td><strong>Show Work Phone</strong></td><td>&nbsp;<input name="show_work_phone" type="checkbox" value="1" <?php echo $so->getProperty('show_work_phone') == '1'? "checked='checked'": ''; ?>/></td></tr>
        <tr> <td><strong>Show Mobile</strong></td><td>&nbsp;<input name="show_mobile" type="checkbox" value="1" <?php echo $so->getProperty('show_mobile') == '1'? "checked='checked'": ''; ?>/></td></tr>
        <tr> <td><strong>Show Email</strong></td><td>&nbsp;<input name="show_email" type="checkbox" value="1" <?php echo $so->getProperty('show_email') == '1'? "checked='checked'": ''; ?>/></td></tr>
        <tr> <td><strong>Show Website</strong></td><td>&nbsp;<input name="show_website" type="checkbox" value="1" <?php echo $so->getProperty('show_website') == '1'? "checked='checked'": ''; ?>/></td></tr>
        
        <tr> <td><strong>Show thumb image in portfolio</strong></td><td>&nbsp;<input name="show_thumb_image" type="checkbox" value="1" <?php echo $so->getProperty('show_thumb_image') == '1'? "checked='checked'": ''; ?>/></td></tr>
        <tr> <td><strong>Image Height</strong></td><td>&nbsp;<input name="thumb_image_height" type="textbox" value="<?php echo $so->getProperty('thumb_image_height'); ?>" style="width:30px;" />px</td></tr>
        <tr> <td><strong>Image Width</strong></td><td>&nbsp;<input name="thumb_image_width" type="textbox" value="<?php echo $so->getProperty('thumb_image_width'); ?>" style="width:30px;" />px</td></tr>
        
        <input type="hidden" value="staff-portolio-options" name="staff_portolio_options" />
        <tr> <td> &nbsp; </td><td> <input name="submit" type="submit" value="Update" class="button-primary"/> </td></tr>
    </table>
</form>
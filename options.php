<?php
/*
File: options.php
Description: Create the options for the plugin
Author: Nick Deboo
*/

if(!empty($_POST['submit']))
{
	update_option('myevents_cat_id',get_cat_ID($_POST['event-category']));	
	echo '<div id="message" class="updated fade"><p>Settings saved</p></div>';
}
?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>My Events</h2>
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="event-category">Events category</label></th>
			<td>
				<select name="event-category" id="default_role">
				<?php $categories = get_categories();
				foreach ($categories as $category) 
				{
					if (get_option('myevents_cat_id') == $category->cat_ID)
						echo '<option selected="selected" value="'.$category->name.'">'.$category->name.'</option>';
					else
						echo '<option value="'.$category->name.'">'.$category->name.'</option>';
				}?>
				</select>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="submit" class="button-primary" value="Save Changes" />
	</p>
	</form>	
</div>
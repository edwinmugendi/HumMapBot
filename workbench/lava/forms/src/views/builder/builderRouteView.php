<?php echo '<?php'; ?>

\Route::group(array('before' => array('auth', 'https')), function() {

/**
* <?php echo $table_name; ?> routes
*/
//Detailed <?php echo $table_name."\n"; ?>
\Route::get('<?php echo $package; ?>/detailed/<?php echo $snake_table_name; ?>/{id}', array('as' => '<?php echo camel_case($package . '_Detailed_' . $camel_table_name); ?>', 'uses' => '<?php echo $name_space = ucwords($workbench) . '\\' . ucwords($package) . '\\' . ucwords($camel_table_name); ?>Controller@getDetailed'));

//List <?php echo $table_name."\n"; ?>
\Route::get('<?php echo $package; ?>/list/<?php echo $snake_table_name; ?>', array('as' => '<?php echo camel_case($package . '_List_' . $camel_table_name); ?>', 'uses' => '<?php echo $name_space; ?>Controller@getList'));

//Post <?php echo $table_name."\n"; ?>
\Route::get('<?php echo $package; ?>/post/<?php echo $snake_table_name; ?>/{id?}', array('as' => '<?php echo camel_case($package . '_Post_' . $camel_table_name); ?>', 'uses' => '<?php echo $name_space; ?>Controller@getPost'));

//Create a <?php echo $table_name."\n"; ?>
\Route::post('<?php echo $package; ?>/create/<?php echo $snake_table_name; ?>', array('as' => '<?php echo camel_case($package . '_Create_' . $camel_table_name); ?>', 'before' => 'csrf', 'uses' => '<?php echo $name_space; ?>Controller@postCreate'));

//Update a <?php echo $table_name."\n"; ?>
\Route::post('<?php echo $package; ?>/update/<?php echo $snake_table_name; ?>', array('as' => '<?php echo camel_case($package . '_Update_' . $camel_table_name); ?>', 'before' => 'csrf', 'uses' => '<?php echo $name_space; ?>Controller@postUpdate'));

//Delete <?php echo $table_name."\n"; ?>
\Route::post('<?php echo $package; ?>/delete/<?php echo $snake_table_name; ?>', array('as' => '<?php echo camel_case($package . '_Delete' . $camel_table_name); ?>', 'uses' => '<?php echo $name_space; ?>Controller@postDelete'));

//Un-Delete <?php echo $table_name."\n"; ?>
\Route::post('<?php echo $package; ?>/undelete/<?php echo $snake_table_name; ?>', array('as' => '<?php echo camel_case($package . '_Undelete_' . $camel_table_name); ?>', 'uses' => '<?php echo $name_space; ?>Controller@postUndelete'));
});


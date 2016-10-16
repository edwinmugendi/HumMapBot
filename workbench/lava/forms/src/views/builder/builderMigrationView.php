<?php echo'<?php'; ?>

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class <?php echo $class_name; ?> extends Migration {

/**
* Run the migrations.
*
* @return void
*/
public function up() {

Schema::create('frm_<?php echo $table_name; ?>', function(Blueprint $table) {
//System fields
$table->increments('id');
$table->integer('organization_id')->unsigned();
$table->integer('user_id')->unsigned();
$table->integer('session_id')->unsigned();
$table->integer('form_id')->unsigned();
$table->string('names', 255);
$table->string('channel_chat_id', 255);
$table->string('channel', 255);
//Form fields
<?php foreach ($fields as $key => $type): ?>
    <?php if ($type == 'string'): ?>
        $table->string('<?php echo \Str::lower(snake_case($key)); ?>', 255);
    <?php elseif ($type == 'integer'): ?>
        $table->integer('<?php echo \Str::lower(snake_case($key)); ?>')->unsigned();
    <?php elseif ($type == 'float'): ?>
        $table->integer('<?php echo \Str::lower(snake_case($key)); ?>');
    <?php elseif ($type == 'boolean'): ?>
        $table->boolean('<?php echo \Str::lower(snake_case($key)); ?>');
    <?php elseif ($type == 'decimal'): ?>
        $table->decimal('<?php echo \Str::lower(snake_case($key)); ?>', 10, 6);
    <?php endif; ?>
<?php endforeach; ?>

//System fields
$table->string('workflow', 255);
$table->string('agent', 255);
$table->string('ip', 255);
$table->integer('status')->unsigned();
$table->integer('created_by')->unsigned();
$table->integer('updated_by')->unsigned();
$table->timestamps();
});
}

/**
* Reverse the migrations.
*
* @return void
*/
public function down() {
Schema::drop('frm_<?php echo $table_name; ?>');
}
}

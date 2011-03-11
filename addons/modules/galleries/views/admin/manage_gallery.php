<div id="galleries_form_box">
	<h3><?php echo lang('galleries.manage_gallery_label'); ?></h3>

	<?php echo form_open($this->uri->uri_string(), 'class="crud"', array('folder_id' => $gallery->folder_id)); ?>
		<ol>
			<li class="<?php echo alternator('', 'even'); ?>">
				<?php echo form_label(lang('galleries.folder_label'). ':', 'folder_id'); ?>
				<?php
				$folder_options = array(lang('select.pick'));
				foreach($file_folders as $row)
				{
					$indent = ($row['parent_id'] != 0) ? repeater(' &raquo; ', $row['depth']) : '';
					$folder_options[$row['id']] = $indent.$row['name'];
				}
				echo form_dropdown('folder_id', $folder_options, $gallery->folder_id, 'id="folder_id" class="required"');
				?>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="title"><?php echo lang('galleries.title_label'); ?></label>
				<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery->title; ?>" />
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="slug"><?php echo lang('galleries.slug_label'); ?></label>
				<?php echo form_input('slug', $gallery->slug, 'class="width-15"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="description"><?php echo lang('galleries.description_label'); ?></label>
				<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="comments"><?php echo lang('galleries.comments_label'); ?></label>
				<?php echo form_dropdown('enable_comments', array('1'=>lang('galleries.comments_enabled_label'), '0'=>lang('galleries.comments_disabled_label')), $gallery->enable_comments); ?>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="published"><?php echo lang('galleries.published_label'); ?></label>
				<?php echo form_dropdown('published', array('1'=>lang('galleries.published_yes_label'), '0'=>lang('galleries.published_no_label')), $gallery->published); ?>
			</li>

			<?php if ( !empty($gallery_images) ): ?>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="gallery_thumbnail"><?php echo lang('galleries.thumbnail_label'); ?></label>
				<select name="gallery_thumbnail" id="gallery_thumbnail">

					<?php if ( !empty($gallery->thumbnail_id) ): ?>
					<!-- Current thumbnail -->
					<optgroup label="Current">
						<?php foreach ( $gallery_images as $image ): if ( $image->id == $gallery->thumbnail_id ): ?>
						<option value="<?php echo $gallery->thumbnail_id; ?>">
							<?php echo $image->name; ?>
						</option>
						<?php break; endif; endforeach; ?>
					</optgroup>
					<?php endif; ?>

					<!-- Available thumbnails -->
					<optgroup label="Thumbnails">
						<?php foreach ( $gallery_images as $image ): ?>
						<option value="<?php echo $image->id; ?>">
							<?php echo $image->name; ?>
						</option>
						<?php endforeach; ?>
					</optgroup>

				</select>
			</li>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="gallery_images"><?php echo lang('galleries.current_label'); ?></label>
				<div class="clear-both"></div>
				<ul id="gallery_images_list">
					<?php if ( $gallery_images !== FALSE ): ?>
					<?php foreach ( $gallery_images as $image ): ?>
					<li>
						<a href="<?php echo base_url() . 'uploads/files/' . $image->filename; ?>" class="modal">
							<?php echo img(array('src' => site_url() . 'files/thumb/' . $image->file_id, 'alt' => $image->name, 'title' => 'File: ' . $image->filename . $image->extension . ' Title: ' . $image->name)); ?>
							<?php echo form_hidden('action_to[]', $image->id); ?>
						</a>
					</li>
					<?php endforeach; ?>
					<?php else: ?>
					<li>
						<?php echo lang('gallery_images.no_images_label'); ?>
					</li>
					<?php endif; ?>
				</ul>
				<div class="clear-both"></div>
			</li>
			<?php endif; ?>
		</ol>

		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
	<?php echo form_close(); ?>

<script type="text/javascript">

jQuery(function($){
$('select#folder_id').change(function(){
	$.get(BASE_URI + 'index.php/admin/galleries/ajax_select_folder/' + this.value.toString(), function(data) {

		if (data) {
			$('input[name=title]').val(data.name);
			$('input[name=slug]').val(data.slug);
		}
		else {
			$('input[name=title]').val('');
			$('input[name=slug]').val('');
		}

	}, 'json');
});
});

</script>
</div>
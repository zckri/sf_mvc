<style>
	.wrappez span {
		color: #111;
	}
	.padding {
		padding: 10px;
	}
	.padding span {
		min-width: 140px;
		display: inline-block;
	}
	.error {
		color: #CC3C3C;
		font-weight: bold;
	}
</style>
<div class="wrappez">
	<div class="padding" style="padding: 10px;">
		<?php 
			if (isset($error)):  
				echo '<ul class="error">';
				foreach($error as $err)
					foreach($err as $val)
						echo "<li>{$val}</li>"; 
				echo '</ul>';
			endif;
		?>
		<form method="post" enctype="multipart/form-data" >
			<span>Автор объявления:</span>
			<?php echo CHtml::dropDownList('Post[author_id]',$model->author_id, CHtml::listData($authors,'id','name')); ?>
			<br/>
			<span>Категория: </span>
			<?php echo CHtml::dropDownList('Post[category_id]',$model->category_id, CHtml::listData($categories,'id','name')); ?>
			<br/>
			<span>Фото: </span>
			<img src="/upload/nophoto.jpg" height="10%" width="10%"/>
			<input type="file" name="file" size="50" />
			<br/><br/>
			<span>Описание (ru): </span>
			<?php echo CHtml::textArea('Post[ru]',$model->ru); ?>
			<br/>
			<span>Описание (en): </span>
			<?php echo CHtml::textArea('Post[en]',$model->en); ?>
			<br/>
			<span>Описание (kz): </span>
			<?php echo CHtml::textArea('Post[kz]',$model->kz); ?>
			<br/>
			<br/>
			<input type="submit" value="Cохранить">
		</form>
	</div>
</div>
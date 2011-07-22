<?php $cl = 'clear'; if(isset($noclear)) $cl = ''; ?>
<div class="<?php echo $cl ?>" style="text-align:right; padding-top:40px;">

<?php if(!isset($tipus)): ?>

<?php //Exemple: include_partial('botonera',array('element'=>'TOTA l\'agenda')); ?>
<?php //Exemple: include_partial('botonera',array('element'=>'TOTA l\'agenda','tipus'=>'Guardar','nom'=>'SaveHTML')); ?>

	<button type="submit" name="<?php echo "BSAVE".(isset($nom)?"_$nom":"") ?>" class="BOTO_ACTIVITAT" onClick="return confirm('Segur que vols guardar els canvis?')">
		<?php echo image_tag('template/disk.png').' Guardar i sortir' ?>
	</button>
	<button type="submit" name="<?php echo "BDELETE".(isset($nom)?"_$nom":"") ?>" class="BOTO_PERILL" onClick="return confirm('Segur que vols esborrar <?php echo $element ?>? No ho podràs recuperar! ')">
		<?php echo image_tag('tango/16x16/status/user-trash-full.png').' Eliminar' ?>
	</button>


<?php else: ?>

<?php //Exemple: include_partial('botonera',array('element'=>'TOTA l\'agenda','tipus'=>'Guardar','nom'=>'SaveHTML')); ?>

	<?php if($tipus == 'Guardar'): ?>
			<button type="submit" name="<?php echo (empty($nom))?'BSAVE':$nom; ?>" class="BOTO_ACTIVITAT" onClick="return confirm('Segur que vols guardar els canvis?')">
				<?php echo image_tag('template/disk.png').' Guardar i sortir' ?>
			</button>
	<?php elseif($tipus == 'Esborrar'): ?>
			<button type="submit" name="<?php echo (empty($nom))?'BDELETE':$nom; ?>" class="BOTO_PERILL" onClick="return confirm('Segur que vols esborrar <?php echo $element ?>? No ho podràs recuperar! ')">
				<?php echo image_tag('tango/16x16/status/user-trash-full.png').' Eliminar' ?>
			</button>
	<?php elseif($tipus == 'Tancar'): ?>
			<?php //Exemple:  include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gNoticies?accio=C'))?>
			<div class="OPCIO_FINESTRA">
				<?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),$url,array('confirm'=>'Segur que vols tancar sense guardar?')); ?>
			</div>
	<?php elseif($tipus == 'Blanc'): ?>			
			<button type="submit" name="<?php echo $nom; ?>" class="BOTO_ACTIVITAT">
				<?php echo $text ?>
			</button>
	<?php endif; ?>
	
<?php endif; ?>

</div>
<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Atviro tipo klausimas</a></li>
	<li><?php if(!empty($id)) echo "Klausimo redagavimas"; else echo "Naujas klausimas"; ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
	<?php if($formErrors != null) { ?>
		<div class="errorBox">
			Neįvesti arba neteisingai įvesti šie laukai:
			<?php
				echo $formErrors;
			?>
		</div>
	<?php } ?>
	<form action="" method="post">
		<fieldset>
			<legend>Atviro klausimo informacija</legend>

				<p>
					<label class="field" for="id">Klausimo ID<?php echo in_array('id', $required) ? '<span> *</span>' : ''; ?></label>
					<?php if(!isset($data['editing'])) { ?>
						<input type="text" id="id" name="id" class="textbox textbox-150" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>" />
						<?php if(key_exists('id', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['id']} simb.)</span>"; ?>
					<?php } else { ?>
						<span class="input-value"><?php echo $data['id']; ?></span>
						<input type="hidden" name="editing" value="1" />
						<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
					<?php } ?>
				</p>
				<p>
					<label class="field" for="klausimas">Klausimas<?php echo in_array('klausimas', $required) ? '<span> *</span>' : ''; ?></label>
					<textarea id="klausimas" name="klausimas" class="textbox textbox-large"><?php echo isset($data['klausimas']) ? $data['klausimas'] : ''; ?></textarea>
						<?php if(key_exists('klausimas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['klausimas']} simb.)</span>"; ?>
				</p>
				<p>
					<label class="field" for="atsakymas">Teisingas Atsakymas<?php echo in_array('atsakymas', $required) ? '<span> *</span>' : ''; ?></label>
					<textarea id="atsakymas" name="atsakymas" class="textbox textbox-large"><?php echo isset($data['atsakymas']) ? $data['atsakymas'] : ''; ?></textarea>
						<?php if(key_exists('atsakymas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['atsakymas']} simb.)</span>"; ?>
				</p>
				<p>
					<label class="field" for="tsk_sk">taškų skaičius<?php echo in_array('tsk_sk', $required) ? '<span> *</span>' : ''; ?></label>

						<input type="text" id="tsk_sk" name="tsk_sk" class="textbox textbox-150" value="<?php echo isset($data['tsk_sk']) ? $data['tsk_sk'] : ''; ?>" />
						<?php if(key_exists('tsk_sk', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['tsk_sk']} simb.)</span>"; ?>
				</p>
				<p>
					<label class="field" for="saltinis">šaltinis<?php echo in_array('saltinis', $required) ? '<span> *</span>' : ''; ?></label>
					<textarea id="saltinis" name="saltinis" class="textbox textbox-large"><?php echo isset($data['saltinis']) ? $data['saltinis'] : ''; ?></textarea>
						<?php if(key_exists('saltinis', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['saltinis']} simb.)</span>"; ?>
				</p>
		</fieldset>
		<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
		<p>
			<input type="submit" class="submit button" name="submit" value="Išsaugoti">
		</p>
		<?php if(isset($data['id'])) { ?>
			<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
		<?php } ?>
	</form>
</div>

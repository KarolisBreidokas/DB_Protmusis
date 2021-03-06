<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Vaizdiniai klausimai</a></li>
	<li><?php if(!empty($id)) echo "klausimo redagavimas"; else echo "Naujas klausimas"; ?></li>
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
	<form enctype="multipart/form-data" action="" method="post">
		<fieldset>
			<legend>Vaizdino klausimo informacija</legend>

				
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
					<?php if(isset($data['medziaga'])){$picture_RAW=base64_encode($data['medziaga']);} ?>
					<label class="field" for="medziaga">Vaizdinė medžiaga<?php echo in_array('tsk_sk', $required) ? '<span> *</span>' : ''; ?></label>
					<img src="<?php if(isset($data['medziaga'])){echo "data:{$data['type']};base64, {$picture_RAW}";} ?>" alt="">
					<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
					<input type="file" id="medziaga" name="medziaga" class="textbox textbox-150" accept="image/*"/>
				</p>
				<p>
					<label class="field" for="type">medžiagos tipas</label>
					<span class="input-value"><?php if(isset($data['type'])){echo $data['type'];} ?></span>

				</p>
				<p>
					<label class="field" for="saltinis">Teisingas Atsakymas<?php echo in_array('atsakymas', $required) ? '<span> *</span>' : ''; ?></label>
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

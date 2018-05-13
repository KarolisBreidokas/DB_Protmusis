<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">testinis klausimas</a></li>
	<li><?php if (!empty($id)) {
    echo "Klausimo redagavimas";
} else {
    echo "Naujas klausimas";
} ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
	<?php if ($formErrors != null) {
    ?>
		<div class="errorBox">
			Neįvesti arba neteisingai įvesti šie laukai:
			<?php
                echo $formErrors; ?>
		</div>
	<?php
} ?>
	<form action="" method="post">
		<fieldset>
			<legend>testinio klausimo informacija</legend>
				<p>
				<?php if (!isset($data['editing'])) {
                } else {
                    ?>
						<label class="field" for="id">Klausimo ID<?php echo in_array('id', $required) ? '<span> *</span>' : ''; ?></label>
						<span class="input-value"><?php echo $data['id']; ?></span>
						<input type="hidden" name="editing" value="1" />
						<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
					<?php
                } ?>
				</p>
				<p>
					<label class="field" for="klausimas">Klausimas<?php echo in_array('klausimas', $required) ? '<span> *</span>' : ''; ?></label>
					<textarea id="klausimas" name="klausimas" class="textbox textbox-large"><?php echo isset($data['klausimas']) ? $data['klausimas'] : ''; ?></textarea>
						<?php if (key_exists('klausimas', $maxLengths)) {
                    echo "<span class='max-len'>(iki {$maxLengths['klausimas']} simb.)</span>";
                } ?>
				</p>
				<p>
					<label class="field" for="tsk_sk">taškų skaičius<?php echo in_array('tsk_sk', $required) ? '<span> *</span>' : ''; ?></label>

						<input type="text" id="tsk_sk" name="tsk_sk" class="textbox textbox-150" value="<?php echo isset($data['tsk_sk']) ? $data['tsk_sk'] : ''; ?>" />
						<?php if (key_exists('tsk_sk', $maxLengths)) {
                    echo "<span class='max-len'>(iki {$maxLengths['tsk_sk']} simb.)</span>";
                } ?>
				</p>
				<p>
					<label class="field" for="saltinis">šaltinis<?php echo in_array('saltinis', $required) ? '<span> *</span>' : ''; ?></label>
					<textarea id="saltinis" name="saltinis" class="textbox textbox-large"><?php echo isset($data['saltinis']) ? $data['saltinis'] : ''; ?></textarea>
						<?php if (key_exists('saltinis', $maxLengths)) {
                    echo "<span class='max-len'>(iki {$maxLengths['saltinis']} simb.)</span>";
                } ?>
				</p>
			<fieldset>
				<legend>Atsakymai</legend>

			<div class="childRowContainer">
				<div class="labelLeft label-30 <?php if (empty($data['atsakymai']) || sizeof($data['atsakymai']) == 0) {
                    echo ' hidden';
                } ?>">Id</div>
				<div class="labelLeft label-200 <?php if (empty($data['atsakymai']) || sizeof($data['atsakymai']) == 0) {
                    echo ' hidden';
                } ?>">atsakymas</div>
				<div class="labelLeft label-30 <?php if (empty($data['atsakymai']) || sizeof($data['atsakymai']) == 0) {
                    echo ' hidden';
                } ?>">teisingas</div>

				<div class="float-clear"></div>
				<?php
                    if (empty($data['atsakymai']) || sizeof($data['atsakymai']) == 0) {
                        ?>
				<?php
                    } else {
                        foreach ($data['atsakymai'] as $key => $val) {
                            ?>
						<div class="childRow">
							<input type=hidden name="deps[]" value="<?php echo $val['dep']; ?>"/>

							<input type="text" class="textbox textbox-30" value="<?php echo $val['id']; ?>" disabled></input>
							<input type="hidden" name="ids[]" value="<?php echo $val['id']; ?>" />
							<input type="text" name="atsakymai[]" class="textbox textbox-200" value="<?php echo isset($val['atsakymas']) ? $val['atsakymas'] : ''; ?>"/>
							<input type="hidden" name="teisingi[]" value="<?php  echo (isset($val['teisingas'])&&$val['teisingas']==1) ? "1" : '0'; ?>"><input type="checkbox" <?php echo (isset($val['teisingas'])&&$val['teisingas']==1) ? "checked" : ''; ?> onclick="this.previousSibling.value=1-this.previousSibling.value">
							<input type="hidden" name="Nauji[]" value="current"/>
							<?php  if (!isset($val['dep'])||$val['dep']==0) {
                                ?>
							<a href="#" title="" class="removeChild">šalinti</a>
						<?php
                            } else {
                                ?>
							<label>negalima naikinti</label>
						<?php
                            } ?>
						</div>
						<div class="float-clear"></div>
				<?php
                        }
                    }
                ?>
			</div>
			<p id="newItemButtonContainer">
				<a href="#" title="" class="addChild">Pridėti</a>
			</p>
			</fieldset>

			<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
			<p>
				<input type="submit" class="submit button" name="submit" value="Išsaugoti">
			</p>
		</fieldset>
		<?php if (isset($data['id'])) {
                    ?>
			<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
		<?php
                } ?>
	</form>
</div>



<div class="childform hidden">
	<input type=hidden name="deps[]" value="0"/>
	<input type="text" name="ids[]" class="textbox textbox-30 cid" value="" disabled="disabled" />
	<input type="hidden" name="ids[]" value="" disabled="disabled" />
	<input type="text" name="atsakymai[]" class="textbox textbox-200" value="" disabled="disabled" />
	<input type="hidden" name="teisingi[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">
	<input type="hidden" name="Nauji[]" value="new"/>
	<a href="#" title="" class="removeChild">šalinti</a>
</div>

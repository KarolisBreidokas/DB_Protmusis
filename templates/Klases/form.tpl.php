<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Klasės</a></li>
	<li><?php if (!empty($id)) {
    echo "Klasės redagavimas";
} else {
    echo "Nauja klasė";
} ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
	<?php
    // išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
    $team = Team::GetQList();;
    if ($formErrors != null) {
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
			<legend>Klasės informacija</legend>
				<p>
					<label class="field" for="raide">raidė<?php echo in_array('raide', $required) ? '<span> *</span>' : ''; ?></label>
					<input type="text" id="raide" name="raide" class="textbox textbox-150"value="<?php echo isset($data['raide']) ? $data['raide'] : ''; ?>"/>
						<?php if (key_exists('raide', $maxLengths)) {
        echo "<span class='max-len'>(iki {$maxLengths['raide']} simb.)</span>";
    } ?>
				</p>

					<p>
						<label class="field" for="laida">laida<?php echo in_array('laida', $required) ? '<span> *</span>' : ''; ?></label>
						<input type="text" id="laida" name="laida" class="textbox textbox-150"value="<?php echo isset($data['laida']) ? $data['laida'] : ''; ?>"/>
							<?php if (key_exists('laida', $maxLengths)) {
        echo "<span class='max-len'>(iki {$maxLengths['laida']} simb.)</span>";
    } ?>
					</p>
				<p>
					<label class="field" for="pradz">Mokslo pradžia<?php echo in_array('pradz', $required) ? '<span> *</span>' : ''; ?></label>
					<input type="text" id="pradz" name="pradz" class="textbox date textbox-150"value="<?php echo isset($data['pradz']) ? $data['pradz'] : ''; ?>"/>
						<?php if (key_exists('atsakymas', $maxLengths)) {
        echo "<span class='max-len'>(iki {$maxLengths['atsakymas']} simb.)</span>";
    } ?>
				</p>
				<p>
					<label class="field" for="FK_mokytojas">Mokytojas<?php echo in_array('FK_mokytojas', $required) ? '<span> *</span>' : ''; ?></label>
					<select id="FK_mokytojas" name="FK_mokytojas">
						<option value="null">---------------</option>
						<?php

                            // išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
                            $class = Teacher::GetQList();
                            foreach ($class as $key => $val) {
                                $selected = "";
                                if (isset($data['FK_mokytojas']) && $data['FK_mokytojas'] == $val['id']) {
                                    $selected = " selected='selected'";
                                }
                                echo "<option{$selected} value='{$val['id']}'>{$val['val']}</option>";
                            }
                        ?>
					</select>
				</p>
				<fieldset>
					<legend>Mokinių informacija</legend>

				<div id="mokiniai" class="childRowContainer">
				<div class="labelLeft label-100 <?php if (empty($data['mokiniai']) || sizeof($data['mokiniai']) == 0) {
                            echo ' hidden';
                        } ?>">Vardas</div>
					<div class="labelLeft label-100 <?php if (empty($data['mokiniai']) || sizeof($data['mokiniai']) == 0) {
                            echo ' hidden';
                        } ?>">Pavardė</div>

					<div class="labelLeft label-100 <?php if (empty($data['mokiniai']) || sizeof($data['mokiniai']) == 0) {
                            echo ' hidden';
                        } ?>">Komanda</div>
					<div class="float-clear"></div>
					<?php
                        if (empty($data['mokiniai']) || sizeof($data['mokiniai']) == 0) {
                        } else {
                            foreach ($data['mokiniai'] as $key => $val) {
                                ?>
							<div class="childRow">
								<input type=hidden name="deps[]" value="<?php echo $val['dep']; ?>"/>
								<input type="hidden" name="ids[]" value="<?php echo $val['id']; ?>" />
								<input type="text" name="vardai[]" class="textbox textbox-100" value="<?php echo isset($val['vardas']) ? $val['vardas'] : ''; ?>"/>
								<input type="text" name="pavardes[]" class="textbox textbox-100" value="<?php echo isset($val['pavarde']) ? $val['pavarde'] : ''; ?>"/>
										<select id="FK_komanda" name="FK_komandos[]">
											<option value="null">---------------</option>
											<?php
                                foreach ($team as $key => $aval) {
                                    $selected = "";
                                    if (isset($val['FK_komanda']) && $val['FK_komanda'] == $aval['id']) {
                                        $selected = " selected='selected'";
                                    }
                                    echo "<option{$selected} value='{$aval['id']}'>{$aval['val']}</option>";
                                } ?>
										</select>
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
		<?php if (isset($data['id'])) {
                        ?>
			<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
		<?php
                    } ?>
	</form>
</div>


<div id="mokiniai" class="childform hidden">
	<input type=hidden name="deps[]" value=""/>
	<input type="hidden" name="ids[]" value="" />
	<input type="text" name="vardai[]" class="textbox textbox-100" value=""/>
	<input type="text" name="pavardes[]" class="textbox textbox-100" value=""/>
	<select id="FK_komanda" name="FK_komandos[]">
		<option value="null" selected>---------------</option>
		<?php
            foreach ($team as $key => $val) {
                echo "<option value='{$val['id']}'>{$val['val']}</option>";
            } ?>
	</select>
	<input type="hidden" name="Nauji[]" value="new"/>
	<a href="#" title="" class="removeChild">šalinti</a>
</div>

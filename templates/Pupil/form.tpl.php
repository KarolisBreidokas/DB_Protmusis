<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Mokinio</a></li>
	<li><?php if (!empty($id)) {
    echo "Mokinio redagavimas";
} else {
    echo "Naujas mokinys";
} ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
	<?php  if ($formErrors != null) {
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
			<legend>Mokinio informacija</legend>
			<?php if (!isset($data['editing'])) {
                } else {
                    ?>
				<p>
					<label class="field" for="id">Mokinio ID<?php echo in_array('id', $required) ? '<span> *</span>' : ''; ?></label>

						<span class="input-value"><?php echo $data['id']; ?></span>
						<input type="hidden" name="editing" value="1" />
						<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />

				</p>
									<?php
                } ?>
				<p>
					<label class="field" for="vardas">Vardas<?php echo in_array('vardas', $required) ? '<span> *</span>' : ''; ?></label>
					<input type="text" id="vardas" name="vardas" class="textbox textbox-150"value="<?php echo isset($data['vardas']) ? $data['vardas'] : ''; ?>"/>
						<?php if (key_exists('vardas', $maxLengths)) {
                    echo "<span class='max-len'>(iki {$maxLengths['vardas']} simb.)</span>";
                } ?>
				</p>
				<p>
					<label class="field" for="pavarde">Pavardė<?php echo in_array('pavarde', $required) ? '<span> *</span>' : ''; ?></label>
					<input type="text" id="pavarde" name="pavarde" class="textbox textbox-150"value="<?php echo isset($data['pavarde']) ? $data['pavarde'] : ''; ?>"/>
						<?php if (key_exists('atsakymas', $maxLengths)) {
                    echo "<span class='max-len'>(iki {$maxLengths['atsakymas']} simb.)</span>";
                } ?>
				</p>
				<p>
					<label class="field" for="FK_klase">Klasė<?php echo in_array('FK_klase', $required) ? '<span> *</span>' : ''; ?></label>
					<select id="FK_klase" name="FK_klase">
						<option value="null">---------------</option>
						<?php

                            // išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
                            $class = Klase::GetQList();
                            foreach ($class as $key => $val) {
                                $selected = "";
                                if (isset($data['FK_klase']) && $data['FK_klase'] == $val['id']) {
                                    $selected = " selected='selected'";
                                }
                                echo "<option{$selected} value='{$val['id']}'>{$val['val']}</option>";
                            }
                        ?>
					</select>
				</p>
				<p>
						<label class="field" for="FK_komanda">Komanda<?php echo in_array('FK_komanda', $required) ? '<span> *</span>' : ''; ?></label>
						<select id="FK_komanda" name="FK_komanda">
							<option value="null">---------------</option>
							<?php
                                // išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
                                $team = Team::GetQList();
                                foreach ($team as $key => $val) {
                                    $selected = "";
                                    if (isset($data['FK_komanda']) && $data['FK_komanda'] == $val['id']) {
                                        $selected = " selected='selected'";
                                    }
                                    echo "<option{$selected} value='{$val['id']}'>{$val['val']}</option>";
                                }
                            ?>
						</select>
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

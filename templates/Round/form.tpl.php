<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Raundai</a></li>
	<li><?php
	var_dump($data);
	if (!empty($id)) {
    echo "Raundo redagavimas";
} else {
    echo "Naujas raundas";
} ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
	<?php
    // išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
    $teams = Team::GetQList();
		$potMods=Pupil::GetQList();
		$Questions['Open']=QuestionsOpen::GetQList();
		$Questions['Visual']=QuestionsVisual::GetQList();
		$Questions['Test']=QuestionsTest::GetQList();
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
			<legend>Raundo informacija</legend>
				<p>
					<label class="field" for="laikas">Laikas<?php echo in_array('laikas', $required) ? '<span> *</span>' : ''; ?></label>
					<input type="text" id="laikas" name="laikas" class="textbox time textbox-150"value="<?php echo isset($data['laikas']) ? $data['laikas'] : ''; ?>"/>
						<?php if (key_exists('laikas', $maxLengths)) {
        echo "<span class='max-len'>(iki {$maxLengths['laikas']} simb.)</span>";
    } ?>
				</p>

					<p>
						<label class="field" for="data">Data<?php echo in_array('laida', $required) ? '<span> *</span>' : ''; ?></label>
						<input type="text" id="data" name="data" class="textbox date textbox-150"value="<?php echo isset($data['data']) ? $data['data'] : ''; ?>"/>
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

				<fieldset>
					<legend>moderatorių informacija</legend>
					<div id="moderatoriai" class="childRowContainer">
						<div class="labelLeft label-100 <?php if (empty($data['moderatoriai']) || sizeof($data['moderatoriai']) == 0) {
    echo ' hidden';
} ?>">Mokinys</div>
						<div class="labelLeft label-100 <?php if (empty($data['moderatoriai']) || sizeof($data['moderatoriai']) == 0) {
    echo ' hidden';
} ?>">Pagrindinis moderatorius</div>
						<div class="float-clear"></div>
					<?php
          if (empty($data['moderatoriai']) || sizeof($data['moderatoriai']) == 0) {
          } else {
              foreach ($data['moderatoriai'] as $key => $val) {
                  ?>
						<div class="childRow">
							<input type=hidden name="Mod_deps[]" value="<?php echo $val['dep']; ?>"/>
							<input type="hidden" name="Mod_ids[]" value="<?php echo $val['id']; ?>" />
							<select id="FK_mokinys" name="Mod_FK_mokinai[]">
								<option value="null">---------------</option>
								<?php
                	foreach ($potMods as $key => $aval) {
                    $selected = "";
                    if (isset($val['FK_mokinys']) && $val['FK_mokinys'] == $aval['id']) {
                        $selected = " selected='selected'";
                    }
                    echo "<option{$selected} value='{$aval['id']}'>{$aval['val']}</option>";
                } ?>
							</select>
							<input type="hidden" name="Mod_mains[]" value="<?php  echo (isset($val['main'])&&$val['main']==1) ? "1" : '0'; ?>"><input type="checkbox" <?php echo (isset($val['main'])&&$val['main']==1) ? "checked" : ''; ?> onclick="this.previousSibling.value=1-this.previousSibling.value">
							<input type="hidden" name="Mod_Nauji[]" value="current"/>
							<?php  if (!isset($val['dep'])||$val['dep']==0) {?>
							<a href="#" title="" class="removeChild">šalinti</a>
							<?php} else {?>
								<label>negalima naikinti</label>
							<?php	} ?>
					</div>
					<div class="float-clear"></div>
					<?php }
          }?>
					</div>
					<p id="newItemButtonContainer">
						<a href="#" title="" class="addChild">Pridėti</a>
					</p>
				</fieldset>
				<fieldset>
					<legend>Komandų informacija</legend>
						<div id="komandos" class="childRowContainer">
							<div class="labelLeft label-100 <?php if (empty($data['komandos']) || sizeof($data['komandos']) == 0) {
														echo ' hidden';
												} ?>">Komanda</div>
							<div class="float-clear"></div>
						<?php
												if (empty($data['komandos']) || sizeof($data['komandos']) == 0) {
												} else {
														foreach ($data['komandos'] as $key => $val) {
																?>
																<div id="komandos" class="childRow">
																	<input type="hidden" name="T_ids[]" value="<?php  echo (isset($val['id'])) ? $val['id'] : ''; ?>" />
																	<select id="FK_komanda" name="T_FK_komandos[]">
																		<option value="null">---------------</option>
																		<?php
																							foreach ($teams as $key => $aval) {
																								$selected="";
																								if (isset($val['FK_komanda']) && $val['FK_komanda'] == $aval['id']) {
						                                        $selected = " selected='selected'";
						                                    }
																									echo "<option$selected value='{$aval['id']}'>{$aval['val']}</option>";
																							} ?>
																	</select>
																	<a href="#" title="" class="removeChild">šalinti</a>
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
				<fieldset>
					<legend>Atviro tipo klausimo informacija</legend>
					<div id="Open" class="childRowContainer">
						<div class="labelLeft label-100 <?php if (empty($data['komandos']) || sizeof($data['komandos']) == 0) {
														echo ' hidden';
												} ?>">Komanda</div>
						<div class="float-clear"></div>
						<?php
								if (empty($data['klausimaiOpen']) || sizeof($data['klausimaiOpen']) == 0) {
								} else {
										foreach ($data['klausimaiOpen'] as $key => $val) {?>
							<div id="Open" class="childRow">
								<input type="hidden" name="Open_ids[]" value="<?php  echo (isset($val['id'])) ? $val['id'] : ''; ?>" />
								<input type=text name=Open_no[] value="<?php  echo (isset($val['no'])) ? $val['no'] : ''; ?>"/>
								<select id="FK_klausimas" name="Open_FK_klausimai[]">
									<option value="null">---------------</option>
									<?php
									foreach ($Questions['Open'] as $key => $aval) {
										$selected="";
										if (isset($val['FK_klausimas']) && $val['FK_klausimas'] == $aval['id']) {
			              	$selected = " selected='selected'";
			            }
									echo "<option value='{$aval['id']}'>{$aval['val']}</option>";
								} ?>
								</select>
								<input type="hidden" name="Open_Nauji[]" value="current"/>
								<?php  if (!isset($val['dep'])||$val['dep']==0) {?>
								<a href="#" title="" class="removeChild">šalinti</a>
								<?php} else {?>
								<label>negalima naikinti</label>
								<?php} ?>
							</div>
						</div>
						<div class="float-clear"></div>
						<?php}
							}?>
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

<div id="moderatoriai" class="childform hidden">
	<input type=hidden name="Mod_deps[]" value=""/>
	<input type="hidden" name="Mod_ids[]" value="" />
	<select id="FK_mokinys" name="Mod_FK_mokinai[]">
		<option value="null">---------------</option>
		<?php
							foreach ($potMods as $key => $aval) {
									echo "<option value='{$aval['id']}'>{$aval['val']}</option>";
							} ?>
	</select>
	<input type="hidden" name="Mod_mains[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">
	<input type="hidden" name="Mod_Nauji[]" value="new"/>
	<a href="#" title="" class="removeChild">šalinti</a>
</div>

<div id="komandos" class="childform hidden">
	<input type="hidden" name="T_ids[]" value="" />
	<select id="FK_komanda" name="T_FK_komandos[]">
		<option value="null">---------------</option>
		<?php
							foreach ($teams as $key => $aval) {
									echo "<option value='{$aval['id']}'>{$aval['val']}</option>";
							} ?>
	</select>
	<a href="#" title="" class="removeChild">šalinti</a>
</div>

<div id="Open" class="childform hidden">
	<input type=hidden name="Open_deps[]" value=""/>
	<input type="hidden" name="Open_ids[]" value="" />
	<input type=text name=Open_no[] value=""/>
	<select id="FK_open" name="Open_FK_klausimai[]">
		<option value="null">---------------</option>
		<?php
							foreach ($Questions['Open'] as $key => $aval) {
									echo "<option value='{$aval['id']}'>{$aval['val']}</option>";
							} ?>
	</select>
	<input type="hidden" name="Open_Nauji[]" value="new"/>
	<a href="#" title="" class="removeChild">šalinti</a>
</div>
<div id="Test" class="childform hidden">
	<input type=hidden name="Test_deps[]" value=""/>
	<input type="hidden" name="Test_ids[]" value="" />
	<input type=text name="Test_no[]" value=""/>
	<select id="FK_test" name="Test_FK_klausimai[]">
		<option value="null">---------------</option>
		<?php
							foreach ($Questions['Test'] as $key => $aval) {
									echo "<option value='{$aval['id']}'>{$aval['val']}</option>";
							} ?>
	</select>
	<input type="hidden" name="Test_Nauji[]" value="new"/>
	<a href="#" title="" class="removeChild">šalinti</a>
</div>
<div id="Visual" class="childform hidden">
	<input type=hidden name="Visual_deps[]" value=""/>
	<input type="hidden" name="Visual_ids[]" value="" />
	<input type=text name="Visual_no[]" value=""/>
	<select id="FK_visual" name="Visual_FK_klausimai[]">
		<option value="null">---------------</option>
		<?php
							foreach ($Questions['Visual'] as $key => $aval) {
									echo "<option value='{$aval['id']}'>{$aval['val']}</option>";
							} ?>
	</select>
	<input type="hidden" name="Visual_Nauji[]" value="new"/>
	<a href="#" title="" class="removeChild">šalinti</a>
</div>

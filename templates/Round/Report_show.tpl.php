<ul id="reportInfo">
	<li class="title">Pasibaigusių Raundų ataskaita</li>
	<li>Sudarymo data: <span><?php echo date("Y-m-d"); ?></span></li>
	<li>Sutarčių sudarymo laikotarpis:
		<span>
		<?php
            if (!empty($data['dataNuo'])) {
                if (!empty($data['dataIki'])) {
                    echo "nuo {$data['dataNuo']} iki {$data['dataIki']}";
                } else {
                    echo "nuo {$data['dataNuo']}";
                }
            } else {
                if (!empty($data['dataIki'])) {
                    echo "iki {$data['dataIki']}";
                } else {
                    echo "nenurodyta";
                }
            }
        ?>
		</span>
	</li>
</ul>



<?php
    if (sizeof($Data) > 0) {
        ?>
		<table class="reportTable">
			<tr>
				<th>Komandos Pavadinimas</th>
				<th class="width150">Surinktų taškų skaičius</th>
				<th class="width150">Teisingai atsakytų klausimų skaičius</th>
			</tr>

			<?php
                // suformuojame lentelę
                for ($i = 0; $i < sizeof($Data); $i++) {
                    if ($Data[$i]['RID']===null) {
                        echo"<tr>"
                        ."<td class='groupSeparator' colspan='4'>Bendra suma</td>"
                        ."</tr>"
                        ."<tr class='aggregate'>"
                            . "<td colspan='2'></td>"
                            . "<td class='border'>{$Data[$i]['Teisingų_kiekis']}</td>"
                        . "</tr>";
                    } else {
                        if ($i == 0 || $Data[$i]['RID'] != $Data[$i-1]['RID']) {
                            echo
                                "<tr>"
                                . "<td class='groupSeparator' colspan='4'>ID:{$Data[$i]['RID']} Data:{$Data[$i]['Data']} Laikas:{$Data[$i]['Laikas']}</td>"

                            . "</tr>";
                        }
                        if ($Data[$i]['TID']===null) {
                            echo "<tr class='aggregate'>"
                                . "<td colspan='2'></td>"
                                . "<td class='border'>{$Data[$i]['Teisingų_kiekis']}</td>"
                            . "</tr>";
                        } else {
                            echo
                            "<tr>"
                                . "<td>{$Data[$i]['Pavadinimas']}</td>"
                                . "<td>{$Data[$i]['taskai']}</td>"
                                . "<td>{$Data[$i]['Teisingų_kiekis']}</td>"
                            . "</tr>";
                        }
                    }
                } ?>




		</table>
		<a href="index.php?module=<?php echo $module ?>&action=<?php echo $action ?>" title="Nauja ataskaita" style="margin-bottom: 15px" class="button large float-right">nauja ataskaita</a>
<?php
    } else {
        ?>
		<div class="warningBox">
			Nurodytu laikotartpiu sutarčių sudaryta nebuvo.
		</div>
<?php
    }
?>

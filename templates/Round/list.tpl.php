<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li>Raundai</li>
</ul>
<div id="actions">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas Klausimas</a>
</div>
<div class="float-clear"></div>
<table class="listTable">
	<tr>
		<th>Data</th>
		<th>Laikas</th>
		<th>Pasiruošimo_Stadija</th>
		<th></th>
	</tr>
	<?php
        // suformuojame lentelę
        foreach ($data as $key => $val) {
            echo
                "<tr>"
                    . "<td>{$val['data']}</td>"
                    . "<td>{$val['laikas']}</td>"
                    . "<td>{$val['stadija']}</td>"
                    . "<td>"
                        . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id']}\"); return false;' title=''>šalinti</a>&nbsp;"
                        . "<a href='index.php?module={$module}&action=edit&id={$val['id']}' title=''>redaguoti</a>"
                    . "</td>"
                . "</tr>";
        }
    ?>
</table>

<?php
    // įtraukiame puslapių šabloną
    include 'templates/paging.tpl.php';
?>

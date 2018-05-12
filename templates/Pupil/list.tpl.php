<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li>Atviro tipo klausimai</li>
</ul>
<div id="actions">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas Klausimas</a>
</div>
<div class="float-clear"></div>
<table class="listTable">
	<tr>
		<th>ID</th>
		<th>Vardas</th>
		<th>Pavardė</th>
		<th>Klasė</th>
		<th>komanda</th>
		<th></th>
	</tr>
	<?php
        // suformuojame lentelę
        foreach ($data as $key => $val) {
            echo
                "<tr>"
                    . "<td>{$val['id']}</td>"
                    . "<td>{$val['vardas']}</td>"
                    . "<td>{$val['pavarde']}</td>"
                    . "<td>{$val['kprad']}{$val['kraide']}</td>"
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

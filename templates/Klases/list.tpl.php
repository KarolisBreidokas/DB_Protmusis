<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li>Klasės</li>
</ul>
<div id="actions">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Nauja klasė</a>
</div>
<div class="float-clear"></div>
<table class="listTable">
	<tr>
		<th>ID</th>
		<th>Raidė</th>
		<th>Mokyklos Laida</th>
		<th>Pradžios metai</th>
		<th>Auklėtojas</th>
		<th></th>
	</tr>
	<?php
        // suformuojame lentelę
        foreach ($data as $key => $val) {
            echo
                "<tr>"
                    . "<td>{$val['id']}</td>"
                    . "<td>{$val['raide']}</td>"
                    . "<td>{$val['laida']}</td>"
                    . "<td>{$val['pradz']}</td>"
                    . "<td>{$val['avrd']} {$val['apvd']}</td>"
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

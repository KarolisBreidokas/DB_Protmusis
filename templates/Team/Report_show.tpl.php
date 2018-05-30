<ul id="reportInfo">
	<li class="title">Pasibaigusių Raundų ataskaita</li>
	<li>Sudarymo data: <span><?php echo date("Y-m-d"); ?></span></li>
	
</ul>
<table class="listTable">
  <col>
  <colgroup span="2"></colgroup>
  <colgroup span="2"></colgroup>
  <colgroup span="2"></colgroup>
  <tr>
  	<th rowspan="2">Komanda</th>
    <th scope="colgroup" colspan="2">Testiniai klausimai</th>
    <th scope="colgroup" colspan="2">Atviro tipo klausimai</th>
    <th scope="colgroup" colspan="2">Vaizdinai klausimai</th>
  </tr>
	<tr>
    <th scope="col">atsakymų kiekis</th>
    <th scope="col">teisingų atsakymų kiekis</th>
    <th scope="col">atsakymų kiekis</th>
    <th scope="col">teisingų atsakymų kiekis</th>
    <th scope="col">atsakymų kiekis</th>
    <th scope="col">teisingų atsakymų kiekis</th>
	</tr>
	<?php
        // suformuojame lentelę
        foreach ($Data as $key => $val) {
            echo
                "<tr>"
                    . "<td>{$val['Pavadinimas']}</td>"
                    . "<td>{$val['Test_ats']}</td>"
                    . "<td>{$val['Test_teis']}</td>"
                    . "<td>{$val['Open_ats']}</td>"
                    . "<td>{$val['Open_teis']}</td>"
                    . "<td>{$val['Visual_ats']}</td>"
                    . "<td>{$val['Visual_teis']}</td>"

                . "</tr>";
        }
    ?>
</table>

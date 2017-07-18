<?php

/*
	Codice della mappa dei negozi Linux-friendly italiani
	Copyright (C) 2010-2017  Italian Linux Society - http://www.ils.org/

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU Affero General Public License as
	published by the Free Software Foundation, either version 3 of the
	License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once ('funzioni.php');

function do_row ($nriga, $region, $tot, $perc) {
	global $elenco_regioni;

	?>

	<tr class="row_<?php echo ($nriga % 2); ?>">
		<td class="province"><a href="/<?php echo $region; ?>/"><?php echo $elenco_regioni [$region]; ?></a></td>
		<td><?php echo $tot; ?></td>
		<td><?php echo round ($perc, 1); ?></td>
	</tr>

	<?php
}

lugheader ('Statistiche dei negozi Linux-friendly italiani');

?>

<div id="center">
	<p class="pull-right text-right">
		<a href="/">&raquo; torna all'indice</a>
	</p>

	<table id="lugListTable">
		<thead>
			<tr>
				<th>Regione</th>
				<th>Numero di Negozi</th>
				<th>Percentuale sul Totale</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3"></td>
			</tr>
		</tfoot>
		<tbody>
			<?php

			$tots = array ();
			$sum = 0;

			foreach (glob ('db/*.txt') as $filename) {
				if (in_array($filename, array('db/emilia.txt', 'db/friuli.txt', 'db/trentino.txt', 'db/valle.txt')))
					continue;

				$contents = file ($filename, FILE_IGNORE_NEW_LINES);
				$tot = count ($contents);
				$sum += $tot;

				$tots[$filename] = $tot;
			}

			$nriga = 0;

			foreach (glob ("db/*.txt") as $filename) {
				if (in_array($filename, array('db/emilia.txt', 'db/friuli.txt', 'db/trentino.txt', 'db/valle.txt')))
					continue;

				$t = $tots [$filename];
				list ($name) = explode ('.', basename ($filename));
				do_row ($nriga, $name, $t, $t == 0 ? 0 : ($t * 100) / $sum);
				$nriga++;
			}

			?>

			<tr class="row_special">
				<td class="province">Totale</td>
				<td><?php echo $sum; ?></td>
				<td>100</td>
			</tr>
		</tbody>
	</table>
	<br />
</div>

<?php lugfooter () ?>


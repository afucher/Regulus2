<?php
include './php/db.php';
						$stmt = null;
						$stmt = $mysql_con->prepare("SELECT id_forn, raz_social FROM fornecedor");
						echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
						$stmt->execute();
						$stmt->bind_result($id,$descricao);
						while($stmt->fetch()){
							echo '<option value="' . $id . '">' . $descricao . '</option>';
						}
					?>
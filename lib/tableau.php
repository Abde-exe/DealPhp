<?php

function genererTableau(PDO $connexion, string $table, array $colonne)
{
    $data = $connexion->query("SELECT * FROM $table");
    // concaténation tout notre tableau 
    $html = "
    <div class=\"container\">
            <table class=\"table table-striped table-sm table-hover align-middle table-bordered \">
            <thead class=\"table-dark\">
                <tr>";
    foreach ($colonne as $k => $c) {
        $html .= "<th>$c</th>";
    }
    $html .= "<th>action</th>";
    $html .= "</tr>
            </thead>
            <tbody>";
    foreach ($data as $d) {
        $html .= "<tr>";

        foreach ($colonne as $k => $c) {
            if ($c == "photo") {
                $html .=  "<td> <img  class=\"figure-img img-fluid\" src=" . htmlspecialchars($d[$c]) . "></img>";
            } elseif ($c == "statut") {
                $html .= ($d[$c] == 1) ? "<td>Admin</td>" : "<td>Membre</td>";
            } else {
                $html .=  "<td>" . htmlspecialchars($d[$c]) . "</td>";
            }
        }
        $html .= "<td>
                    <a href=\"?modifier&type=" . htmlspecialchars($table) . "&id=" . htmlspecialchars($d[$colonne[0]]) . "\">
                    <span style=\"font-size: 1em; color: Blue;\">
                    <i class=\"fa-solid fa-pen-to-square\"></i></span>
                    </a>
                     <a href=\"?supprimer&type=" . htmlspecialchars($table) . "&id=" . htmlspecialchars($d[$colonne[0]]) . "\"
                        onclick=\"return confirm('êtes vous sûr de supprimer " . htmlspecialchars($d[$colonne[1]]) . " ?')\">
                        <span style=\"font-size: 1em; color: Tomato;\">
                        <i class=\"fa-solid fa-trash\"></i></span>
                        </a>
                   
                        </td>
                    </tr>";
    }
    $html .= "</tbody>
        </table>
    </div>

    ";
    return $html;
}

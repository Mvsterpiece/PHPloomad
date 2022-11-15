<?php
require_once ('connect.php');


global $yhendus;

//andmete lisamine tabelisse
if(isset($_REQUEST['lisamisvorm']) &&!empty($_REQUEST['nimi']) &&!empty($_REQUEST['vanus'])  &&!empty($_REQUEST['silmadevarv'])){
    $paring=$yhendus->prepare(
            "INSERT INTO loomad(loomanimi,vanus,silmadevarv,pilt) Values (?,?,?,?)"
    );
    $paring->bind_param("sis",$_REQUEST["nimi"],$_REQUEST["vanus"],$_REQUEST["pilt"]);
    //("s",$_REQUEST["nimi"]) - "s" - string - tekstikastiga "nimi"
    $paring->execute();
}



//kustutamine
if(isset($_REQUEST['kustuta'])){
    $paring = $yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $paring->bind_param('i',$_REQUEST['kustuta']);
    $paring->execute();
}

//tabeli sisu näitemine
$paring=$yhendus->prepare("SELECT id, loomaNimi, vanus,silmadevarv, pilt FROM loomad");
$paring->bind_result($id, $nimi,$vanus,$silmadevarv,$pilt);
$paring->execute();


?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomad</title>
</head>
<body>
<h1>Loomade tabel</h1>
<table>
    <tr>
        <td>id</td>
        <td>Loomanimi</td>
        <td>Vanus</td>
        <td>SilmadeVärv</td>
        <td>Pilt</td>
        <td>Kustuta</td>
    </tr>
    <?php
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>".htmlspecialchars($id)."</td>";
        //htmlspecialchars($id) - <käsk> - käsk nurksulgudes mis ie loetakse
        echo "<td>$nimi</td>";
        echo "<td>$vanus</td>";
        echo "<td>$silmadevarv</td>";
        echo "<td><img src='$pilt' alt='pilt' width='25%'></td>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
    ?>


</table>
<h2>Uue looma lisamine</h2>
<form name="uusloom"method="post" action="?">
    <input type="hidden" name="lisamisvorm">
    <input type="text" name="nimi" placeholder="Looma nimi">
    <br>
    <input type="text" name="vanus" placeholder="Looma vanus">
    <br>
    <textarea name="pilt">Siia lisa pildi aadress.</textarea>
    <br>
    <label>Vali silmadevärv.</label>
    <input type="color" id="varv" value="red">
    <br>
    <input type="submit" value="OK">

</form>

</body>



<?php
$yhendus->close();
?>
</html>

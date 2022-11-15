<?php
require_once ('connect.php');
global $yhendus;

//andmete lisamine tabelisse
if(isset($_REQUEST['lisamisvorm']) &&!empty($_REQUEST['loomatuup'] &&!empty($_REQUEST['nimi']) &&!empty($_REQUEST['vanus'] &&!empty($_REQUEST['silmadevarv'])))){
    $paring=$yhendus->prepare(
        "INSERT INTO loomaaed(loomatuup,loomanimi,vanus,silmadevarv,pilt) Values (?,?,?,?,?)"
    );
    $paring->bind_param("ssiss",$_REQUEST["loomatuup"],$_REQUEST["nimi"],$_REQUEST["vanus"],$_REQUEST["silmadevarv"],$_REQUEST["pilt"]);
    //("s",$_REQUEST["nimi"]) - "s" - string - tekstikastiga "nimi"
    $paring->execute();
}

//kustutamine
if(isset($_REQUEST['kustuta'])) {
    $paring = $yhendus->prepare("DELETE FROM loomaaed WHERE id=?");
    $paring->bind_param('i', $_REQUEST['kustuta']);
    $paring->execute();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomaaed</title>
    <link rel="stylesheet" type="text/css" href="styles.css"
</head>
<body>
<h1>Loomaaed</h1>
<div id="menyy">
<ul>
    <?php
    echo("<h3>Loomade nimekirja.</h3>");
    //näitab loomade loetelu tablist
    $paring=$yhendus->prepare("SELECT id, loomaNimi FROM loomaaed");
    $paring->bind_result($id, $nimi);
    $paring->execute();

    while ($paring->fetch()) {
        echo "<li><a href='?id=$id'>$nimi</a></li>";
    }
    echo "</ul>";
    echo "<a href='?lisaloom=jah'>Lisa Loom</a>";
    ?>
</div>
<div id="sisu">
    <?php
    if(isset($_REQUEST["id"])){
        $paring=$yhendus->prepare("SELECT loomaNimi, loomatuup, vanus, silmadevarv, pilt FROM loomaaed WHERE id=?");
        $paring->bind_param("i",$_REQUEST["id"]);
        $paring->bind_result($loomatuup,$nimi,$vanus,$silmadevarv,$pilt);
        $paring->execute();
        if($paring->fetch()){
            echo "<div>".htmlspecialchars($loomatuup)." , loomatüüp ";
            echo htmlspecialchars($nimi).", vanus ";
            echo htmlspecialchars($vanus)." aastat.";
            echo "<br>Silmade värv: ".htmlspecialchars($silmadevarv);
            echo "<br>";
            echo "<img src='$pilt' alt='pilt' width='150px'>";
            //echo "<br>Silmadevärv ".htmlspecialchars($silmadevarv);
            echo "<br>";
            echo "<a href='?kustuta=".$_REQUEST['id']."'.>Kustuta</a>";
            echo "</div>";
        }
    }
        if(isset($_REQUEST['lisaloom']))
        {
            ?>
            <h2>Uue looma lisamine</h2>
            <form name="uusloom"method="post" action="?">
                <input type="hidden" name="lisamisvorm" value="jah">
                <input type="text" name="loomatuup" placeholder="Loomatüüp">
                <br>
                <input type="text" name="nimi" placeholder="Looma nimi">
                <br>
                <input type="text" name="vanus" placeholder="Looma vanus">
                <br>
                <textarea name="pilt">Siia lisa pildi aadress.</textarea>
                <br>
                <label>Vali silmadevärv.</label>
                <input type="color" id="varv" name="silmadevarv">
                <br>
                <input type="submit" value="OK">
            </form>
    <?php
        }
        else{
            echo("<h3>siia tuleb loomade sisu</h3>");
        }
    ?>
</div>
</body>
</html>


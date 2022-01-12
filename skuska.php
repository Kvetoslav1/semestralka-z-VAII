<?php
require "pripojenie.php";
require "pracovanie_s_databazou/clanky_posty/vyberanieDatabaza.php";
require "pracovanie_s_databazou/clanky_posty/pridavaniePostu.php";
$nazovClanku = "skuska";

$nazovClanku = "skuska";
$nazovPostu = "novy nadpis postu";
$textPostu = "asljdhalkjfgaslkdfh sadkjf sadlkjfhasdjkf akjsldh kjlafdshfklja sflkjsadhflaksdhfl kas";
if(isset($_POST['post']) && strlen($_POST['textArea']) > 50 && isset($pripojenie)) {
    $update = new pridavaniePostu();
    echo $_POST['post'];
    echo $_POST['textArea'];
    if(!$update->updatePost($pripojenie, $nazovPostu, $_POST['textArea'], $_POST['post'])) {
        echo "Článok nebol pridaný!";
    } else {
        header("Location: index.php");
    }
}
?>
<form method="post" enctype="application/x-www-form-urlencoded">
    <div id="pridajPost" class="gridy">
        <H2 class="header">Upravenie postu: <?php if (isset($nazovPostu)) {
                echo $nazovPostu;
            } ?></H2>
        <span style="padding-top: 5px; grid-column: 1" class="bold">Názov postu:</span>
        <label style="grid-row: 2; grid-column: 2">
            <input name="post" type="text" value="<?php echo $nazovPostu ?>" required class="vstup" maxlength="60">
        </label>

        <span style="padding-top: 5px; grid-column: 1" class="bold">Obsah článku:</span>
        <label style="grid-row: 3; grid-column: 2/4">
                    <textarea style="width: 90%; height: 100%;"
                              name="textArea" onKeyDown="limitText(this.form.textArea,this.form.countdown,1000);"
                              onKeyUp="limitText(this.form.textArea,this.form.countdown,1000);">
                        <?php echo $textPostu ?>
                    </textarea>
        </label>
        <div style="grid-row: 4; grid-column: 1/4">
            <br >(Maximálny počet znakov je: 1000)
            <span>Máte ešte <input readonly type="text" name="countdown" size="1" value="1000"> voľných znakov.</span><br>
        </div>
        <button class="btn-reg-log" style="grid-area: 5/2;">Upraviť článok</button>
    </div>
</form>


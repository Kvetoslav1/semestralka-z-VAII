<?php
require "pripojenie.php";
?>
<script type="text/javascript">
    function limitText(textArea, aktPocet, maxPocet) {
        if (textArea.value.length > maxPocet) {
            textArea.value = textArea.value.substring(0, maxPocet);
        } else {
            aktPocet.value = maxPocet - textArea.value.length;
        }
    }
</script>
<form method="post" enctype="application/x-www-form-urlencoded">
<textarea name="textArea" onKeyDown="limitText(this.form.textArea,this.form.countdown,100);"
          onKeyUp="limitText(this.form.textArea,this.form.countdown,100);">
</textarea>
    <br>(Maximálny počet znakov je: 100)<br>
    Máte ešte <input readonly type="text" name="countdown" size="1" value="100"> voľných znakov.
</form>

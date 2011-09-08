<?php use_helper('Form'); ?>
<html>
<head>

<script type="text/javascript">
    window.setTimeout(function() { document.forms[0].submit(); }, 300);
</script>

</head>
<body>


<form action="<?php echo $URL ?>" method="POST">
<?php foreach($TPV as $K => $T) echo input_hidden_tag($K,$T); ?> 

<noscript>
    <p><?php echo __("Prem el següent botó per a fer el pagament.") ?></p>
    <input type="submit" value="Fes el pagment" />
</noscript>

</form>


</body>




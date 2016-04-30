<script type="text/javascript">
$(document).ready(function() {
    var printFinished = function(print) {
        console.log('finished');
        var url = '<?php echo $this->Html->url(['controller' => 'transactions', 'action' => 'index'])?>';
        window.location.href = url;
    }
    printFinished(window.print());
});
</script>

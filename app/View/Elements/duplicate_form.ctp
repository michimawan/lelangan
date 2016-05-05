<script type="text/javascript">
$(document).ready(function() {
    $('#create').click(function() {
        var quantity = $('#TransactionQuantity').val();
        var $container = $('.js-customers');
        $container.empty();
        var i = 0;
        for(var i=0; i<quantity; i++) {
            var $form = $('.master').html();
            $form = $form.replaceAll('xxx', (i+1));
            $container.append($form);
        }
    });
    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.replace(new RegExp(search, 'g'), replacement);
    };
});
</script>

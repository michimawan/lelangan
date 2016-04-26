<script type="text/javascript">
$(document).on('keyup', '#PaymentPay', function() {
    var pay = $('#PaymentPay').val();
    var total_price = $('#TransactionBidPrice').val();
    var deficient = (total_price - pay);

    $('#PaymentDeficient').attr('value', deficient);
});
</script>

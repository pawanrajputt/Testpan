<!DOCTYPE html>
<html>
<head>
    <title>Payment Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

<h2>Test Payment</h2>

<button id="payBtn">Pay ₹10</button>

<div id="result"></div>

<script>
$("#payBtn").click(function(){

    $("#result").html("Processing payment...");

    $.ajax({
        url: "<?= base_url('payment/create') ?>",
        type: "POST",
        dataType: "json",
        success: function(res){

            console.log(res);

            if(res.respCode == "0"){
                
                let intentURL = res.data.intentURL;
                let txnid = res.data.merchant_txnid;

                $("#result").html("Redirecting to payment...");

                // Redirect to UPI Intent
                window.location.href = intentURL;

                // OPTIONAL: check status after 10 sec
                setTimeout(function(){
                    checkStatus(txnid);
                }, 10000);

            } else {
                $("#result").html("Payment Failed: " + res.respMessage);
            }
        }
    });

});


function checkStatus(txnid)
{
    $.ajax({
        url: "<?= base_url('payment/status') ?>",
        type: "POST",
        data: {merchant_txnid: txnid},
        success: function(res){
            console.log("Status:", res);
        }
    });
}
</script>

</body>
</html>
<?php

//*****************************************************
//**ONESIGNAL PUSH NOTIFICATIONS **********************
//*****************************************************

function BYA_add_onesignalScript(){

?>

<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "fbc7dcc4-4beb-43d9-9325-b9da2903dee0",
      notifyButton: {
        enable: false	,
      },
    });
  });
</script>


<?php

}

if($_SERVER["SERVER_NAME"]=="balanceadosya.com.ar")
{

    add_action('wp_head','BYA_add_onesignalScript');

}

?>
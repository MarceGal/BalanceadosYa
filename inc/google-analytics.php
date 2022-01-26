<?php

//*****************************************************
//**GOOGLE ANALYTICS **********************************
//*****************************************************


function BYA_add_googleAnalyticsScript(){

?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-150064125-1"></script>
    
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-150064125-1');
    </script>

<?php

}

add_action('wp_head','BYA_add_googleAnalyticsScript');

?>

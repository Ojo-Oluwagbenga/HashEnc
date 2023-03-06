
<?php
    // if (isset($_SERVER['HTTPS'])){
    //     if ($_SERVER['HTTPS'] != 'on'){
    //         header('Location: https://hashenc.inventivetelecomhub.com');
    //         die();
    //     }
    // }else{
    //     header('Location: https://hashenc.inventivetelecomhub.com');
    //     die();
    // }
    session_start();
    if (isset($_SESSION['user'])){
        header('Location:hack/');
    }

?>
<!DOCTYPE html>
<html lang="en"> 
                
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ceaser Cipher</title>   
        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">         
    </head>
                                    
    <body>
        <div class="popalertBox">
            <style>
                .popalertBox{
                    position: fixed;
                    width: 100vw;
                    bottom: 60px;
                    display: none;
                    z-index: 220;
                }
                .popalertBox .mypop{
                    width: max-content;
                    margin: 0px auto;
                    padding: 10px;
                    border-radius: 10px;
                    background-color: #343434;
                    transition: opacity 0.3s ease-in;
                    color: white;
                    /* font-family: "Open Sans Condensed", sans-serif; */
                    font-size: 15px;
                    font-weight: bold;
                    opacity:1;
                }
            </style>
            <div class="mypop">Pop Here</div>
            <script>
                function popAlert(text){
                    $(".popalertBox").css('display', 'block');
                    $(".popalertBox .mypop").css('opacity', '1').text(text);
                    setTimeout(() => {
                        $(".popalertBox .mypop").css('opacity', '0');
                        setTimeout(() => {
                            $(".popalertBox").css('display', 'none');
                        }, 400);
                    }, 2000);
                }
            </script>
        </div>

        <div class="hold">
            <img src="back.jpg" alt="">
            <div class="loginpanelhold">
                <div id="logpage" class="subphold" >
                    <div class="l-text loginpanel v-align" style="font-size: 20px;">Ready to start hacking?</div>
                    <div class="loginpanel">
                        <div id="a-name" class="entryhold">
                            <div class="name">Access name</div>
                            <input type="text">
                        </div>
                        <div id="a-code" class="entryhold">
                            <div class="name">Access code</div>
                            <input type="password">
                        </div>

                        <div class="buttonpack">
                            <div id="createacct" class="create v-align" style="color: white;">Create New</div>
                            <div id="loginacct" class="login v-align">Hack!</div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            body, *{
                box-sizing: border-box;
                margin: 0px;
                padding: 0px;
                font-family: 'PT Sans', sans-serif;
            }
            .v-align{
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            .hold{
                width: 100%;;
                height: 100vh;
            }
            .hold img{
                height: 100%;
                width: 100%;
                object-fit: cover;
                position: fixed;
                top: 0px;
            }
            .hold .loginpanelhold{
                height: 100%;
                overflow-y: scroll;
                width: 100%;
                position: relative;
                z-index: 2;
                backdrop-filter: blur(10px);
                background-color: rgba(223, 223, 223, 0.315);
                /* display: flex; */
                justify-content: center;
                flex-direction: column;
            }

            .loginpanelhold .subphold{
                margin: 0px auto;
            }
            .loginpanelhold div.l-text{
                margin: 10px auto;
                width: 100%;
                text-align: center;
                font-weight: bold;
            }
            .loginpanelhold .loginpanel{
                background-color: rgba(255, 255, 255, 0.5);
                border-radius: 5px;
                padding: 30px;
            }


            .entryhold {
                width: 100%;
            }
            .entryhold .name{
                padding:20px 1px 2px 1px;
                font-weight: bold;                
            }
            .entryhold input{
                padding: 10px;
                border-radius: 0px 8px 0px 8px;
                outline: none;
                width: 100%;
                border: 1px solid rgba(255, 255, 255, 0);
                transition: border 0.4s ease;
            }

            input:focus{
                border-left: 3px solid rgb(70, 15, 8);
            }
            .buttonpack{
                display: flex;
                justify-content: space-between;
                margin: 30px 0;
            }
            .buttonpack :nth-child(n){
                height: 40px;
                border-radius: 5px;
                text-align: center;
                cursor: pointer;
            }
            .buttonpack .login{
                width: 30%;
                color:rgb(53, 11, 6);
                border:2px solid rgb(53, 11, 6);
            }
            .buttonpack .create{
                width: 60%;
                background-color: rgb(53, 11, 6);
            }

      
            .subphold{
                width: 80%;
                max-width: 400px;
                height: 90vh;
                /* overflow-y: scroll; */
            }
            .text-panel{
                width: 100%;
                margin: 10px auto;
                height: 50vh;
                /* background-color: red; */
            }
            .text-panel textarea{
                width: 100%;
                height: 100%;
                resize: none;
                padding: 10px;
                outline: none;
                background-color: rgba(218, 231, 218, 0.315);
                border: 2px dashed rgba(210, 228, 210, 0);
                border-radius: 5px;
                transition: border 0.5s ease;
            }
            .text-panel textarea:focus{
                border: 2px dashed rgba(86, 98, 141, 0.534);
            }
            .actiontab{
                display: flex;
                justify-content: space-between;
            }
            .actiontab  :nth-child(n){
                text-align: center;
            }
            .actiontab div.bott{
                border-radius: 0px 0px 5px 5px;
            }
            .actiontab > :nth-child(n){
                border-radius: 5px;
                margin: 10px;
                
            }
            .actiontab > div{
                transition: all 0.4s ease;
                cursor: pointer;
            }
            .actiontab > div:hover{
                color: white;
                background-color: rgb(87, 14, 5);
            }
            .actiontab > :nth-child(1){
                width: 25%;
                /* border: 2px solid rgb(187, 33, 13);
                color: rgb(187, 33, 13); */
                color: white;
                background-color: rgb(117, 33, 20);

            }
            .actiontab > :nth-child(2){
                width: 50%;
            }
            .actiontab > :nth-child(3){
                width: 25%;
                border: 2px solid rgb(117, 33, 20);
                color:rgb(117, 33, 20);
            }
            .writekey input{
                width: 100%;
                border-radius: 5px;
                padding: 10px;
                outline: none;
                border: 2px solid rgb(172, 172, 173) ;
                transition: border 0.5s ease;
            }
            .writekey input:focus{
                border: 2px solid rgb(117, 117, 117);
            }
            @media (max-width: 400px){
                .buttonpack{
                    flex-direction: column;
                }
                .buttonpack > :nth-child(n){
                    width: 100%;
                    margin: 10px 0px;
                }
                .subphold{
                    width: 90%;
                }
            }
        </style>

        <script src="manage.js"></script>
    </body>

          
</html>
<?php
    session_start();
    if (!isset($_SESSION['user'])){
        header('Location:../../ccipher');
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
                padding: 10px;
                transition:all 0.3s ease;
                margin-left: -60%;
                width:100%;
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
                color:rgb(76 33 27);
                border:2px solid rgb(76 33 27);
            }
            .buttonpack .create{
                width: 60%;
                background-color: rgb(76 33 27);
            }

            .subphold{
                width: 80%;
                max-width: 500px;
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
                font-size: 15px;
                transition: border 0.5s ease, font-size 0.2s ease-out;
            }
            .text-panel .ta-pack{
                height: 100%;
                width:100%;
                position: relative;
            }
            .text-panel .option-super{
                position: absolute;
                bottom:1%;
                left: 1%;
                z-index:3;
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
                border-radius: 5px;
                background-image: linear-gradient(45deg, rgb(117, 33, 20), #5646460d);
                color: white;
                font-weight:bold;
                width: 25%;
                text-shadow: 2px 2px 5px black;
            }
            .actiontab div.bott#hash{
                background-image: linear-gradient(-45deg, rgb(117, 33, 20), #5646460d);
            }
            .actiontab > :nth-child(n){
                border-radius: 5px;
                padding: 5px;                
            }
            .actiontab > :nth-child(n).writekey{
                margin: 0 10px;            
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
               
            }
            .actiontab > :nth-child(2){
                width: 50%;
                padding: unset;
            }
            .writekey input{
                width: 100%;
                border-radius: 5px;
                padding: 10px;
                height: 100%;
                outline: none;
                border: 2px solid rgb(172, 172, 173) ;
                transition: border 0.5s ease;
            }
            .writekey input:focus{
                border: 2px solid rgb(117, 117, 117);
            }
            
            @media (max-width: 400px){
                .actiontab{
                    flex-direction: column;
                }
                .actiontab > :nth-child(n).writekey{
                   margin: 10px 0px;
                }
                .actiontab > :nth-child(n){
                    width: 100% !important;
                    height: 50px;
                }
                .subphold{
                    width: 90%;
                }
                .actiontab div.bott{
                    background-image: linear-gradient(45deg, rgb(117, 33, 20), #5646460d) !important;
                }
            }
            
            .option-pack-rel{
                position:relative;
                display:flex;
            }
            .option-pack-rel .option{
                border: 1px dashed grey;
                border-radius: 100%;
                padding: 8px;
                margin: 5px;
                height: 35px;
                width: 35px;
                position: relative;
                backdrop-filter:blur(5px);
            }
            .option-pack-rel .option svg{
                height: 17px;
                fill: #752114;
            }
            .option-super .data-entry{
               position: absolute;
                bottom: calc(97% - 1px);
                border-radius: 5px;
                padding: 16px 14px;
                background-color: #f3f3f3ba;
            }
            .option-super .data-entry input{
                outline:none;
                border:1px dashed transparent;
                padding: 5px;
                transition: all .3s ease;
            }
            .option-super .data-entry input:focus{
                border:1px dashed grey;
            }
            .option-super .pointer{
                display:none;
                position: absolute;
                bottom: 92%;
                height: 10px;
                width: 10px;
                margin: 0px auto;
                left: calc( 50% - 5px);
                background-image: linear-gradient(-46deg, #e6e8e9, transparent);
                transform: rotateZ(45deg);
            }
        </style>
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
                    border-radius: 5px;
                    background-color: #343434;
                    transition: opacity 0.3s ease-in;
                    color: white;
                    /* font-family: "Open Sans Condensed", sans-serif; */
                    font-size: 14px;
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
            <img src="../back.jpg" alt="">
            <div class="loginpanelhold">
                <div id="encpage" style="display:<?php if (isset($_SESSION['user'])){echo 'block';}else{echo 'none';}?>"  class="subphold" style="display: none;">
                    <div class="l-text loginpanel v-align">
                        <div class="buttonpack" style="margin: 0px">
                            <div id="copyid" class="create v-align" style="color: white;">Copy plate text</div>
                            <div id="pasteid"class="login v-align">Paste</div>                        
                        </div>
                    </div>

                    <div class="loginpanel">
                        <div class="text-panel">
                            <div class="ta-pack">
                                <textarea id="hashtext" name="" placeholder="Paste a text to encrypt or an encrypted text to hack!"></textarea>
                                <div class="option-super">
                                    <div class="option-pack-rel">
                                        <div class="option v-align" id="adduser">
                                            <div class="pointer"></div>
                                            <svg style="height: 16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 304h-96C78.8 304 0 382.8 0 480c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32C448 382.8 369.2 304 272 304zM48.99 464C56.89 400.9 110.8 352 176 352h96c65.16 0 119.1 48.95 127 112H48.99zM224 256c70.69 0 128-57.31 128-128c0-70.69-57.31-128-128-128S96 57.31 96 128C96 198.7 153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48z"/></svg>
                                        </div>
                                        <div class="option v-align" id="addtime">
                                            <div class="pointer"></div>
                                            <svg style="height: 16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M232 120C232 106.7 242.7 96 256 96C269.3 96 280 106.7 280 120V243.2L365.3 300C376.3 307.4 379.3 322.3 371.1 333.3C364.6 344.3 349.7 347.3 338.7 339.1L242.7 275.1C236 271.5 232 264 232 255.1L232 120zM256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48C141.1 48 48 141.1 48 256z"/></svg>
                                        </div>
                                        <div class="option v-align" id="setonce">
                                            <div class="pointer"></div>
                                            <svg style="height: 16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 448c0 17.67-14.33 32-32 32H32c-17.67 0-32-14.33-32-32s14.33-32 32-32h64V123.8L49.75 154.6C35.02 164.5 15.19 160.4 5.375 145.8C-4.422 131.1-.4531 111.2 14.25 101.4l96-64c9.828-6.547 22.45-7.187 32.84-1.594C153.5 41.37 160 52.22 160 64.01v352h64C241.7 416 256 430.3 256 448z"/></svg>
                                        </div>
                                        <div class="option v-align" id="toggletext">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M384 64.01c0 17.67-14.33 32-32 32h-128v352c0 17.67-14.33 31.99-32 31.99s-32-14.32-32-31.99v-352H32c-17.67 0-32-14.33-32-32s14.33-32 32-32h320C369.7 32.01 384 46.34 384 64.01z"/></svg>
                                        </div>
                                    </div>
                                    <div class="data-entry" style="display:none">
                                        <div class="t-head" style="padding:4px 0px 10px 0px; font-weight:bold; color:#6a352efa">Set Receiver</div>
                                        <div class="entpack" style="position:relative; display:flex;border-radius:4px; overflow:hidden">
                                            <input type="name" placeholder="Enter name" style="width: 100px">
                                            <div id="save-extra" class="v-align" style="height: 100%;background-color: #752114ba;color:white; padding:10px; cursor:pointer">Save</div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="actiontab">
                            <div id="hack" class="decrypt v-align bott">Hack!</div>
                            <div class="writekey">
                                <input id="hashkey" type="text" placeholder="Enter hack key">
                            </div>
                            <div id="hash" class="encrypt v-align bott">Hash!</div>
                        </div>
                    </div>

                    <div id="logout" class="l-text loginpanel v-align" style="padding: 10px; background-color: rgb(76 33 27); color: white;">
                        Log Out
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            setTimeout(function(){
                $(".loginpanelhold .loginpanel").css("margin-left", "0%");
            }, 100);
        </script>
        
        
        

        
        
        

        <script src="../manage.js"></script>
    </body>
          
</html>
$(document).ready(function(){
    

    $(".buttonpack #createacct").click(function(){
        let uname = $("#a-name input").val();
        let ucode = $("#a-code input").val();

        
        if (uname.length > 4 && ucode.length >4){
            communicator({"action":"create",
            "data":{
                "username": uname,
                "password": ucode
            }}, function(ret){
                const data = JSON.parse(ret);
                const resp = data['response'];
                
                if (resp == 200){
                    sessionStorage.setItem("user", data['data']['username']);
                    popAlert("Account created successfully. Happy hacking!");
                    login();
                }else{
                    popAlert(data['data']['message']);
                }
                
            });
        }else{
            popAlert("Entries must be a minimum of 4 chars");
        }
    });

    $(".buttonpack #loginacct").click(function(){
        let uname = $("#a-name input").val();
        let ucode = $("#a-code input").val();
        
        if (uname !== "" && ucode !== ""){
            communicator({"action":"login",
            "data":{
                "username": uname,
                "password": ucode
            }}, function(ret){
                data = JSON.parse(ret);
                if (data['response'] == 201){
                    popAlert("Username or password incorrect.");
                }
                if (data['response'] == 200){
                    sessionStorage.setItem("user", data['data']['username']);
                    popAlert("Happy hacking!");
                    login();
                }
            });
        }else{
            popAlert("Kindly make the entries");
        }
    });
    
    $("#logout").click(function(){
        communicator({"action":"logout"}, function(ret){
            window.location.href="../";
        }, "../backend.php");
    });

    $("#hack").click(function(){
        hackhash("hack");
    });
    
    $("#hash").click(function(){
        hackhash('hash');
    });
    
    $("#copyid").click(function (){        
        let text = $("#hashtext").val();
        $("textarea#hashtext").css("fontSize", 18);
        writeToClipboard(text);
        setTimeout(() => {
            $("textarea#hashtext").css("fontSize", 14);
            popAlert('Plate Text copied!');
        }, 201);
    });
    
    $("#pasteid").click(function (){
        copyFromClipboard($("#hashtext"));
    });
    
    let extradata = {};
    extradata['setonce'] = 0;
    extradata['validity'] = true;
    extradata['adduser'] = '';
    extradata['adduser'] = '';
    let focobj = '';
    
    $(".data-entry input").on('keyup', function(){
        if (focobj !== ''){
            extradata['validity'] = false;
            extradata[focobj] = $(this).val();  
            $(".data-entry #save-extra").text('Save').css('background-color', "rgb(71 15 10)");
        }
    });
    
    $(".data-entry #save-extra").click(function(){
        let data = {};
        data['action'] = 'checkuser';
        
        
        data['data'] = {"username":extradata['adduser'], "time":extradata['addtime']};
        
        if (extradata['adduser'] != ''){
            communicator(data, function(ret){
                console.log(ret);
                let cret = JSON.parse(ret);
                if (cret['response'] == 200){
                    extradata['validity'] = true;
                    popAlert("User Valid - Entries saved");
                    $(".data-entry #save-extra").text('Saved').css('background-color', "grey");
                    if (typeof(extradata['addtime']) !== 'undefined' && extradata['addtime'] !== ''){
                        setTimeout(function(){
                            popAlert('Read once will now be activated');
                            extradata['setonce'] = 0;
                            setOnce();
                        }, 1000);
                    }
                }else{
                    extradata['validity'] = false;
                    popAlert(cret['data']['message']);
                }
            }, '../backend.php');
            
        }else{
            if (!isNaN(extradata['addtime']) && 1 < extradata['addtime'] && 101 > extradata['addtime']){
                $(".data-entry #save-extra").text('Saved').css('background-color', "grey");
                extradata['validity'] = true;
                popAlert("Timed reading activated.");
                setTimeout(function(){
                    popAlert('Read once will now be activated');
                    extradata['setonce'] = 0;
                    setOnce();
                }, 1000);
            }else{
                popAlert("The set time is not valid. Min at 1s, Max at 100s");
            }
        }
    });
    
    $(".option-pack-rel #setonce").click(function(){
        setOnce();
    });
    
    
    
    let istext = 0;
    $(".option-pack-rel #toggletext").click(function(){
        istext = (istext+1)%2;
        
        if (istext == 1){
            $(".option-pack-rel #toggletext").css({"background-color": "grey"});
            popAlert("Messages will be hashed into text");
        }else{
            $(".option-pack-rel #toggletext").css({"background-color": "unset"});
            popAlert("Messages will be hashed into J_Codes");
        }
    });
    
    $(".option-pack-rel .option").hover(function(){
        let id = $(this).attr('id');
        
        focobj = id;
        if (id !== "setonce"){
            $("#"+id + " .pointer").css('display', "block");
            $(".data-entry").hover(function(){
                $(this).css("display", "block");
                $(" .pointer").css('display', "none");
                $("#"+id + " .pointer").css('display', "block");
                // $(".data-entry").unbind('mouseenter');
                
            }, function(){
                $(" .pointer").css('display', "none");
                // $(".data-entry").unbind('mouseenter');
                $(".data-entry").css("display", "none");
            })
            
            $(".data-entry input").val(extradata[id]);
            if (id=="addtime"){
                $(".data-entry").css("display", "block");
                $(".data-entry .t-head").text("Set max readable time");
                $(".data-entry input").attr("placeholder", "Time in seconds");
            }
            if (id=="adduser"){
                $(".data-entry").css("display", "block");
                $(".data-entry .t-head").text("Assign to a user");
                $(".data-entry input").attr("placeholder", "Receiver's username");
            }
        }
    }, function(){
        $(".data-entry").unbind('hover');
        $(" .pointer").css('display', "none");
        $(".data-entry").css("display", "none");
    });
    

    function setOnce(){
        extradata['setonce'] = (extradata['setonce'] + 1)%2;
        if (extradata['setonce'] == 1){
            $(".option-pack-rel #setonce").css({"background-color": "grey"});
            popAlert("Receiver will be able to read once");
        }else{
            $(".option-pack-rel #setonce").css({"background-color": "unset"});
            extradata['addtime'] = '';
            popAlert("Receiver will be able to read always without timing");
        }
    }
    
    function enText(jtext){
        let  rtext = "aojbdefq";
        let  ctext = ",'^>!.|_";
        let  corr = "";
        for(let i = 0; i < jtext.length; i++){
            let t = jtext[i];
            let i2 = ctext.indexOf(t);
            corr += rtext[i2];
        }
        return corr;
    }
    
    function deText(jtext){
        let  rtext = "aojbdefq";
        let  ctext = ",'^>!.|_";
        let  corr = "";
        for(let i = 0; i < jtext.length; i++){
            let t = jtext[i];
            let i2 = rtext.indexOf(t);
            corr += ctext[i2];
        }
        return corr;
    }
    
    function login(){
        setTimeout(() => {
            window.location.href="hack/";
        }, 1000);       

    }
    
    function hackhash(type){
        let text = $("#hashtext").val();
        let key = $("#hashkey").val();
        
        if (extradata['validity']){
            if (text !== "" && key !== ""){
                $("#" + type).text(type + "ing...");
                communicator({"action":type, 
                                "data": {
                                    "text":text,
                                    "key":key,
                                    "extras": extradata,
                                    "user":sessionStorage.getItem("user")
                                }}, function(ret){
                                    if (type == 'hash'){
                                        $("#hash").text("Hash!");
                                        popAlert("hashing:" + text);
                                    }
                                    if (type == 'hack'){
                                        popAlert("got:" + ret);
                                        $("#hack").text("Hack!");
                                    }
                                    
                                    const cret = JSON.parse(ret);
                                    
                                    if (cret['response'] == 200){
                                        let parse = cret['data']['message']
                                        
                                        
                                        
                                        if (type == 'hash'){
                                            if (istext == 1){
                                                parse = enText(parse);
                                            }
                                            popAlert("A level of encryption added!");
                                            
                                        }
                                        
                                        if (type == 'hack'){
                                            popAlert("A layer of encryption removed!");
                                            const v = cret['data']['readtime'];
                                            if (v!=0){
                                                setTimeout(function(){
                                                    $("#hashtext").val(text);
                                                    popAlert("Max read time reached!");
                                                }, v*1000);
                                            }
                                        }
                                        $("#hashtext").val(parse);
                                        
                                    }else{
                                        popAlert(cret['data']['message']);
                                    }
                                }, "../backend.php");
            }else{
                popAlert("Neither the text nor the hash key can be empty!");
            }
        }else{
            popAlert("Ensure all values are saved before hashing");
        }
        
    }
    
    function communicator(data, callback, path){
        
        path = typeof(path) !== 'undefined' ? path : "backend.php";
        $.ajax({
            type: "POST",
            url: path,
            data: {
                data: JSON.stringify(data)
            },
            cache: false,
            success: function(data) {
                callback(data);
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }   
        });
    }

    async function writeToClipboard(text) {
        const type = "text/plain";
        let blob = new Blob([text], {type});
        let data  = [new ClipboardItem({[blob.type] : blob})]
        navigator.clipboard.write(data);
    }
    
    function copyFromClipboard(el) {

            navigator.permissions.query({name:'clipboard-read'}).then(function(result) {
                if (result.state === 'granted') {
                    navigator.clipboard.readText()
                        .then(text => {
                            el.val(text);
                        })
                        .catch(err => {
                            console.error('Failed to read clipboard contents: ', err);
                        });
                } else if (result.state === 'prompt') {
                    popAlert("Kindly allow the write permission");
                }else{
                    popAlert("Write permission not granted. Please paste manually");
                }
              });
               
    }
    
});
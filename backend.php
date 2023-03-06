<?php
    require_once "hackmanager.php";
    if(isset($_POST['data'])){
        $data = (array) json_decode($_POST['data']);
        $myDb = new DB();
        
        if ($data['action'] == "login"){
            // die($myDb->clearAndBuild());
            $logdata = (array)($data['data']);
            $uname = $logdata['username'];
            $upass = $logdata['password'];
            $resp = json_encode(array("response"=>201, "data"=>array("error"=>"Password or Username incorrect")));

            $user = $myDb->readBy("users", "username", $uname);
            if ($user !== null){
                // $resp = json_encode($user);
                if ($user['password'] == $upass){
                    $resp = json_encode(array("response"=>200, "data"=>array("username"=>$uname)));
                    session_start();
                    $_SESSION['user'] = $user["id"];
                }
            }
            echo $resp;
        }
        
        if ($data['action'] == "create"){
            $logdata = (array) ($data['data']);
            $uname = $logdata['username'];
            $upass = $logdata['password'];
            
            $allowed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_1234567890";
            
            

            $resp = json_encode(array("response"=>203, "data"=>array("message"=>"Invalid login")));

            $isallowed = true;
            for($i=0;$i<strlen($upass);$i++){
                $char = substr($upass, $i, 1);
                if (strpos($allowed, $char) === false){
                    $resp = json_encode(array("response"=>201, "data"=>array("message"=>"Login credentials can only be alphabets, numbers and underscore")));
                    $isallowed = false;
                }
            }
            
            if ($isallowed){
                if (strlen($uname) >= 4 && strlen($upass) >= 4){
                    if ($myDb->readBy("users", "username", $uname) !== null){
                        $resp = json_encode(array("response"=>201, "data"=>array("message"=>"Username exists already. Kindly try another")));
                        
                    }else{
                        $id = $myDb->insert("users", array("username"=>$uname, "password"=>$upass, "hackcount"=> 0, "read"=>array()));
                        if ($id != -1){
                            $resp = json_encode(array("response"=>200, "data"=>array("username"=>$uname, "message"=>"Account created successfully. Happy hacking!")));
                            session_start();
                            $_SESSION['user'] = $id;
                        }
                    }
                }else{
                    $resp = json_encode(array("response"=>202, "data"=>array("message"=>"Entries must be a minimum of 4 chars")));
                }
            }
            echo $resp;

        }
        
        if ($data['action'] == "logout"){
            session_start();
            $_SESSION['user'] = null;
            session_destroy();
        }
        
        if ($data['action'] == "checkuser"){ 
            $logdata = (array) ($data['data']);
            echo json_encode(checkuser($logdata));
        }
        
        
        if ($data['action'] == "hack" || $data['action'] == "hash"){
            
            $hackdata = (array) ($data['data']);
            $js = new JSymbols();
            $txt = $hackdata['text'];
            $key = $hackdata['key'];
            $myDb = new DB();
            $uname = $hackdata['user'];
            $user = $myDb->readBy("users", "username", $uname);
            
            
            
            if ($data['action'] == "hash"){
                $code = json_encode(array("response"=>201, "data"=>array("message"=>"Invalid hashing parameters")));
                $extras = (array) ($hackdata['extras']);
                $logdata = array();
                $runtest = 0;
                
                $messBund = array();
                
                //u = user id; t = time; m = message; v = viewonce; i=sender|hashcount
                $messBund['i'] = $user['id']."|".$user['hackcount'];
                if (isset($extras['addtime'])){
                    if ($extras['addtime'] != ''){
                        $logdata["addtime"] = $extras['addtime'];
                        $runtest = 1;
                        $messBund['t'] = $extras['addtime'];
                        $messBund['v'] = 1;
                    }
                }
                
                if (isset($extras['setonce'])){
                    if ($extras['setonce'] == 1){
                        $messBund['v'] = 1;
                    }
                }
                
                $resp = array('response'=> 200);
                
                if (isset($extras['adduser'])){
                    if ($extras['adduser'] != ''){
                        $logdata["username"] = $extras['adduser'];
                        $resp = checkuser($logdata);
                        
                        if ($resp['response']==200){
                            $messBund["u"] = $resp['data']['uid'];
                        }
                        $runtest = 0;
                        
                    }
                }
                
                if ($runtest == 1){
                    $resp = checkuser($logdata);
                }
                
                
                if ($resp['response'] == 200){
                    if ($user !== null){
                        $hackcount = $user['hackcount'] + 1;
                        $user['hackcount'] = ($hackcount)%2000;
                        $myDb->update("users", $user['id'], $user);
                        $messBund['m'] = $txt;
                        $codex = $js->encPersSync(json_encode($messBund), $key, (($hackcount*19)%111) . $uname);
                        $code = json_encode(array("response"=>200, "data"=>array("message"=>$codex)));
                    }
                }else{
                    $code = json_encode($resp);
                }
            }
            
            if ($data['action'] == "hack"){
                $codex = $js->decPersSync($txt, $key);
                
                $code = json_encode(array("response"=>201, "data"=>array("message"=>"Invalid hashing parameters")));
                
                if ($codex->isValid()){
                    $bund = (array) json_decode($codex->getMessage());
                    $mtxt = $bund['m'];
                    $err = '';
                    
                    $set = true;
                    if (isset($bund['u'])){
                        if ($bund['u'] != $user['id']){
                            $set = false;
                            $err = 'Message not hashed for this user';
                        }
                    }
                    if (isset($bund['v']) && $set){
                        if ($bund['v'] == 1){
                            $myarr = (array)$user['read'];
                            
                            if(in_array($bund['i'], $myarr)){
                                $set = false;
                                $err = 'Message set to hack once and has been hacked by you!';
                            }else{
                                array_push($myarr, $bund['i']);
                            }
                            $user['read'] = $myarr;
                            $myDb->update("users", $user['id'], $user);
                        }
                        
                    }
                    $readtime = 0;
                    if (isset($bund['t']) && $set){
                        $readtime = $bund['t'];
                    }
                    if (explode("|", $bund['i'])[0] == $user['id']){
                        $set = true;
                        $readtime = 0;
                    }
                    
                    
                    if ($set){
                        $code = json_encode(array("response"=>200, "data"=>array("message"=>$mtxt, 'readtime'=>$readtime)));
                    }else{
                        $code = json_encode(array("response"=>201, "data"=>array("message"=>$err)));
                    }
                }else{
                    $code = json_encode(array("response"=>201, "data"=>array("message"=>"Incorrect hack key or invalid hashed packet.")));
                }
            }
            
            
            echo $code;
        }
        
    }else{
        die("Improper Access!");
    }
    
    function checkuser($logdata){
        $myDb = new DB();
        $uname = $logdata['username'];
        $user = $myDb->readBy("users", "username", $uname);
        
        if (!isset($user)){
            $resp = array("response"=>201, "data"=>array("message"=>"User Not Found"));
            return $resp;
        }

        $resp = array("response"=>201, "data"=>array("message"=>"Invalid data parsed"));
        
        if ($uname != ''){
            $resp = array("response"=>200, "data"=>array("message"=>"All values are valid!", "uid"=>$user['id']));
        }else{
            $resp = array("response"=>200, "data"=>array("message"=>"Only time per se"));
        }
        
        if (isset($logdata['time'])){
            if ($logdata['time'] != ''){
                if (!is_numeric($logdata['time']) || $logdata['time'] < 1 || $logdata['time'] > 100){
                    $resp = array("response"=>201, "data"=>array("message"=>"The set time is not valid. Min at 1s, Max at 100s"));
                }
            }
        }
        
        return $resp;
    }

    class DB{
        private $file;
        private $DB;

        public function __construct(){
            
        }
        function clearAndBuild(){
            $ret = false;
            $tbname = "users";
            if(!isset($this->DB[$tbname])){

                if ($tbname != "meta"){
                    $this->DB = (object) $this->DB;
                    $this->DB->{$tbname} = (object) array();
                    $ret = true;
                }
            }

            $this->closeDb();
            return $ret;
        }
        function openDb(){
           
            $fftext = file_get_contents("storage.php");
            
            
            $dblen = strlen($fftext);
            $trimtext = "<?php die('Invalid Access');". "$". "k = '";
            $trimlen = strlen($trimtext);
            
            $ftext = substr($fftext,$trimlen, $dblen-$trimlen-2);
            
            if ($ftext != ""){
                $this->DB = (array) json_decode($ftext);
            }else{
                $this->DB = new stdClass;
            }           
        }
        function closeDb(){
            $js  = new JSymbols();
            
            $t = "<?php die('Invalid Access');". "$". "k = '";
            $t2 = "';";
            
            $towrite = $t.json_encode((array)$this->DB).$t2;
            file_put_contents("storage.php", $towrite);
        }
        function create($tbname){
            $this->openDb();
            $ret = false;
            if(!isset($this->DB[$tbname])){

                if ($tbname != "meta"){
                    $this->DB = (object) $this->DB;
                    $this->DB->{$tbname} = (object) array();
                    $ret = true;
                    // ($this->DB['meta'])->{$tbname} = array("count"=>0);
                }
            }

            $this->closeDb();
            return $ret;

        }

        function insert($tbname, $data){
            $this->openDb();
            $id = -1;
            if (isset($this->DB[$tbname])){
                $id = count((array)$this->DB[$tbname]);
                $data = (object) $data;
                $data->id = $id;
                $this->DB[$tbname]->{$id} = (array) $data;
            }
            $this->closeDb();
            return $id;
        }
        function read($tbname, $id){
            $this->openDb();
            $ret = array();
            if (isset($this->DB[$tbname])){
                $ret = ((array)$this->DB[$tbname])[$id];
                if (!isset($ret)){
                    $ret = array();
                }
            }
            $this->closeDb();
            return $ret;
        }
        function readBy($tbname, $readkey, $searchvalue){
            $this->openDb();
            $ret = null;
            if (isset($this->DB[$tbname])){
                $arrTable = (array) $this->DB[$tbname];
                for ($i=0; $i < count($arrTable); $i++) { 
                    $pack = (array)$arrTable[$i];
                    if (isset($pack[$readkey])){
                        if ($pack[$readkey] == $searchvalue){
                            $ret = (array) $pack;
                            $i = count($arrTable);
                        }
                    }
                }
            }
            $this->closeDb();
            return $ret;
        }
        function update($tbname, $id, $newset){
            $this->openDb();
            $ret = array();
            if (isset($this->DB[$tbname])){
                $newset = (object) $newset;
                $newset->{"id"} = $id;
                $this->DB[$tbname]->{$id} = $newset;
            }
            $this->closeDb();
            return $ret;
        }
        function delete($tbname, $id){
            $this->update($tbname, $id, array());
        }
    }
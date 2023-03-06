<?php


class Constants{
    public $J_BinAlph = "iopIK`JHGFDSAZ\\XCV[];'./!@#$%^&Blkjhgm1fds2azxcv5N763QW,yuU8bn490-=*()~{}:>OPLERTqwe<?|YMrt+_ \n\"";
    public $MyAlphas = "l|QFDSKJHG!i\\op`I[#$%^&B];'@sXW,CVU34kjhg1./NyuOdxc~vbMr8Raz2nm7}:>Tqwe<fAZY)0{95?PLE-=*(6t+_ \n\"";
}

class Codebank{
    
    private $dot = ".";
    private $dash = "_";
    // public $MyAlphas = "tuvwxyz1234567ABCIrs890!@#$%^&*()`~TUVlm-=+[]{DEFGH}';<>,?/|àJKLMNOPQRSnopqáâäæãåāéèëêēîíìïīòöôóõōœøûúūüù•√π÷×¶∆WXYZab°¥€¢£©®™✓ßçñⱡⱣcdefghijkⱠꜬꜭꜮꜯꜨꜩꜷꜵꜿꝇꝚꝛꝜꝝꝞꝟꝢꝵꝱꝲꝭꝬꝩꝨꝰꞇꞆꝿꝾꝽꝼꝻꝸꞓ\"\\ШЩЙИЗЖІ϶ЅϵϴϤϣϖϘϗϙϛϜϝϞϟϰАаѐяьэыћњљјѥ҉҈ἓἒἥἰἱἲἳὈὉὍὐὑ`ΉῼΏῺΌῸῷῶῴῳῲżŻŹźƅƕƝƯƽƴƒųŵŷŪŽžůſŰƀðÿăĂɑɒɓɔɕɖɗɘəɚɛɜɝɞɟɠɣɤɥɦɧɨɩɪɫɬɭɮɯɰɱɲɳɵɷɸɹɺɻɼɽɾɿʁʂʃʄʅʇʆʈʉʊʋʌʍʎʏʐʑʒʓʔʕʖʗʘʚʛʝʞʠʤʥʧµº¿řşšǐȉᵃᵄᵅᵷᵆᵇᵈᵉᵊᵋᵌᵍᵎᵏᵐᵑᵒᵓᵔᵕᵖᵗᵘᵙᵚᵛᵝᵞᵜᵟᵠᵡᵢᵣᵤᵥᵦᵧᵨᵩᵪᶜᶝᶞᶟᶠᶢᶡᶤᶥᶦᶧᶨᶩᶪᶫᶹᶷᶽꝌꝍꝋꝊꝉꝈꜣꜢꜚꜙꜘ⸗ⱽǥǫǬǞǎизϚϕϔϓϒρςστυφχψωϊϋόύώϐϑοξνμλκ˔˕˓˒ˑƾƼƺƻƹƸƷƶƵơƢƤƥƣƦƨƩƪƫƬƭƇƈƔƁŲŝňłıįĩćĆ«»¤²±¡";
    private $J_BinAlph;
    private $MyAlphas;
    // private $J_BinAlph = "qwertyuioplkjhgfdsazxcvbnm1234567890QWERTYUIOIPASDFGHJKLZXCVBNM,-";
    
    function __construct(){
        $this->J_BinAlph = (new Constants())->J_BinAlph;
        $this->MyAlphas = (new Constants())->MyAlphas;
    }
 
    function getChar($str, $i){
        return substr($str, $i, 1);
    }

    public function AddCont($s) {
        $k = 0;
        for ($i = 0; $i < strlen($s); $i++) {
            
            $ss = $this->getChar($s,$i);                               
            $k += strpos($this->MyAlphas, $ss);           

        }
        

        return $k;
    }

    public function itMatches($Message, $sum) {

        $Vals = "0123456789";


        $valOkay = true;
        for ($i = 0; $i < strlen($sum) ; $i++) {
            $ss = $this->getChar($sum, $i);
            if (strpos($Vals, $ss) === false){
                $valOkay = false;
            }
        }

        if ($valOkay && $sum != "") {
            $sumCalc = 0;
            $iSum = $sum;

            for ($i = 0; $i < strlen($Message); $i++) {
                $s = $this->getChar($Message, $i);
                $sumCalc += strpos($this->J_BinAlph, $s) % 1111;
            }
             
            return $sumCalc == $iSum;
        }else {
            return false;
        }

    }

}
class JSymbols {
    private $dot = ".";
    private $dash = "_";
    private $MyAlphas;
    private $J_BinAlph;
    // private $J_BinAlph = "qwertyuioplkjhgfdsazxcvbnm1234567890QWERTYUIOIPASDFGHJKLZXCVBNM,-";
    function __construct(){
        $this->J_BinAlph = (new Constants())->J_BinAlph;
        $this->MyAlphas = (new Constants())->MyAlphas;
    }
    public function AddCont($s) {
        $k = 0;
        for ($i = 0; $i < strlen($s); $i++) {
            
            $ss = (new Codebank())->getChar($s,$i);                               
            $k += strpos((new Codebank())->MyAlphas, $ss);           

        }
        
        return $k;
    }
    function getChar($str, $i){
        return substr($str, $i, 1);
    }


    function filtertext($text, $allowed){
        $retText = "";
        $store = array();
        for ($i=0; $i < strlen($text); $i++) { 
            $t = $this->getChar($text, $i);
            if (strpos($allowed,$t) !== false){
                $retText .= $t;
            }else{
                array_push($store, array($i, $t));
            }
        }
        return $retText;
    
    
    }

    function entext($jtext){
        $rtext = "aojbdefq";
        $ctext = ",'^>!.|_";
        $corr = "";
        for($i = 0; $i < strlen($jtext); $i++){
            $t = $this->getChar($jtext, $i);
            $i2 = strpos($ctext, $t);
            $corr .= $this->getChar($rtext, $i2);
        }
        return $corr;
    }
    function detext($jtext){
        $rtext = "aojbdefq";
        $ctext = ",'^>!.|_";
        $corr = "";
        for($i = 0; $i < strlen($jtext); $i++){
            $t = $this->getChar($jtext, $i);
            $i2 = strpos($rtext, $t);
            $corr .= $this->getChar($ctext, $i2);
        }
        return $corr;
    }
    
    public function encPersSync($message, $stableCode, $jumpCode){
        $message = $this->filtertext($message, $this->MyAlphas);
        return ($this->jcodize($message, $stableCode, $jumpCode));
    }

    public function decPersSync($message, $stableCode){
        if (strpos($message, ".") === false){
            $message = $this->detext($message);
        }

        // return new MessageBody($message, true);
        $Mess = $this->deJcodize($message, $stableCode);

        if ($Mess != "Ѫљ"){ 
            return new MessageBody($Mess, true);
        }else {
            return new MessageBody("", false);
        }

    }

    function debug($valname,$val, $linenum){
        echo ($valname . " : " . $val . " <b> --From line:". $linenum." </b><br>");
    }
    private function sjcodize($text, $stableCode, $jumpCode){
        $jsymb = new Jsymb();


        $stableint = -1;
        $jumpint = -1;

        $coded = "";


        for ($i = 0; $i < strlen($text); $i++) {

            $v = $this->getChar($text, $i);
            $vPos = $jsymb->getPos($v);


            $stableint = ($i) % strlen($stableCode);
            $sv = $this->getChar($stableCode, $stableint);
            $svpos = $jsymb->getPos($sv);

            $jumpint = ($i) % strlen($jumpCode);
            $jv = $this->getChar($jumpCode, $jumpint);
            $jval = $jsymb->enBin($jv);
            
            if ($vPos != -1){
                $vPos = $this->process($vPos, $stableCode, $jumpCode);
                $coded .= ($jsymb->operate($vPos, $svpos, $jval, $text));
                // $this->debug("coded", $coded, 137);
            }else {
                $coded .= ($this->getChar($text, $i)) . ($this->dash);
            }
        }

        return $coded;
    }

    private function process($k, $stableCode, $jumpcode){
        $jsymb = new Jsymb();
        $len = strlen($jsymb->jAlphas());

        for ($i = 0; $i < strlen($stableCode) ; $i++) {
            $sv = $this->getChar($stableCode, $i);
            $svpos = $jsymb->getPos($sv);

            $jv = $this->getChar($jumpcode, ($i % strlen($jumpcode)));
            $jvpos = ($jsymb->getPos($jv)) % 2;

            if ($jvpos == 1){
                $k = $k + $svpos;
            }else {
                $k = $k - $svpos;
            }


            $k = $k % $len + $len;
            $k = $k % $len;
        }

        return $k;
    }

    private function deprocess($k, $stableCode, $jumpcode){
        $jsymb = new Jsymb();
        $len = strlen($jsymb->jAlphas());

        for ($i = 0; $i < strlen($stableCode) ; $i++) {
            $sv = $this->getChar($stableCode, $i);
            $svpos = $jsymb->getPos($sv);

            $jv = $this->getChar($jumpcode, ($i % strlen($jumpcode)));
            $jvpos = ($jsymb->getPos($jv)) % 2;

            if ($jvpos == 1){
                $k = $k - $svpos;
            }else {
                $k = $k + $svpos;
            }

            $k = ($k % $len) + $len;
            $k = $k % $len;
        }

        return $k;
    }

    public function jcodize($text, $stableCode, $jumpCode){
        $ss = (((new Codebank())->AddCont($stableCode)) % 111);
        $sum = 0;
        
        
        for ($i = 0; $i < strlen($text); $i++) {
            $s = $this->getChar($text, $i);
            $sum += (new Jsymb())->getPos($s) % 1111;
        }

        $eAll = $this->sjcodize(($sum), $ss, $jumpCode) . $this->dot;
        $hjump = $this->sjcodize($jumpCode, "&_^*", $stableCode);
        $eMess = $this->sjcodize($text, $sum . $stableCode, $jumpCode);

        return ($eAll.$hjump."|".$eMess);
    }

    function deJcodize($text, $stableCode){

        $lenght = 0;

        $swich = false;
        $esum = "";
        $rText = "";
        for ($i = 0; $i < strlen($text) ; $i++) {
            $t = $this->getChar($text, $i);
            if ($t != $this->dot ){
                if (!$swich) {
                    $esum .= $t;
                }

            } else {
                $swich = true;
            }

            if ($swich){
                if ($t != $this->dot){
                    $rText .= $t;
                }
                if ($t == $this->dash){
                    $lenght = $lenght + 1;
                }
            }
        }

        $joint = explode("|", $rText);
        if (count($joint) == 2){
            $rText = $joint[1];       


            $ss = (((new Codebank())->AddCont($stableCode)) % 111);

            $jumpCode = $this->reStarker($joint[0],"&_^*",$stableCode);

            $realSum = $this->reStarker($esum, $ss,  $jumpCode);

            $Message = $this->reStarker($rText, $realSum . $stableCode, $jumpCode);

            if ((new Codebank()) -> itMatches($Message, $realSum)){
                return  $Message;
            }else {
                return "Ѫљ";
            }
        }else{
            return "Ѫљ";
        }

    }

    function reStarker($text, $stableCode, $jumpCode){
        $jsymb = new Jsymb();
        $length = 0;

        for ($i = 0; $i < strlen($text) ; $i++) {
            $t = $this->getChar($text, $i);
            if ($t == $this->dash){
                $length = $length + 1;
            }
        }

        $sortSum = $this->codeSorter($text);

        $stableint = -1;
        $jumpint = -1;

        $rSum = "";
        
        for ($i = 0; $i < count($sortSum); $i++) {

            if ($i + 1 < count($sortSum)){
                $s = ($sortSum[$i]);
                $s1 = ($sortSum[$i + 1]);


                if ($s1 == ($this->dot)){
                    $stableint = ($stableint + 1) % strlen($stableCode);
                    $sv = $this->getChar($stableCode, $stableint);
                    $svpos = $jsymb->getPos($sv);


                    $jumpint = ($jumpint + 1) % strlen($jumpCode);
                    $jv = $this->getChar($jumpCode, $jumpint);
                    $jvpos = $jsymb->enBin($jv);




                    $nvpos = ($jsymb->deOperate($svpos, $jvpos, $s, $length));
                    $nvpos = $this->deprocess($nvpos, $stableCode, $jumpCode);
                    $rSum .= ($this->getChar((new Jsymb())->jAlphas(), $nvpos));

                }else {

                    if ($s1 == $this->dash && $s != $this->dot){
                        $stableint = ($stableint + 1) % strlen($stableCode);
                        $jumpint = ($jumpint + 1) % strlen($jumpCode);
                        $rSum .= ($s);
                    }
                }
            }
        }

        return  $rSum;
    }

    function codeSorter($code){

        $as = array();

        $s = "";
        for ($i = 0; $i < strlen($code); $i++) {
            $ss = $this->getChar($code, $i);
            if (strpos((new Jsymb())->jcodex(), $ss) !== false){
                $s .= ($ss);
            }else {
                if ($s != "") {
                    array_push($as, $s);

                    $s = "";
                    $s .= ($this->dot);
                    array_push($as,$s);

                    $s = "";
                    $s.=($ss);
                    array_push($as,$s);

                }else {
                    $s = "";
                    $s.= ($ss);
                    array_push($as,$s);
                }

                $s = "";
            }
        }

        return $as;
    }   

}
class Jsymb{
    private $dot = ".";
    private $dash = "_";
    private $MyAlphas;
    private $J_BinAlph;
    // private $J_BinAlph = "QAZWS07134XEDCR;FVTGBY|:HNU#JMIKLO. Pp!@#%^&*()lokm£i-jnu_h+=bygvtfcrd{}[βꞒ¶∆¥®Ꞓ£×©ẻếxes>zw]aq29?/<568~`,$" . "\n" . "\b" . "\uD83D\uDE01\uD83D\uDE00\uD83D\uDE02\uD83E\uDD23\uD83D\uDE0A\uD83D\uDE06\uD83D\uDE0B\uD83D\uDE09\uD83D\uDE0E\uD83D\uDE17☺️\uD83D\uDE19\uD83D\uDE1A\uD83D\uDE42\uD83E\uDD17\uD83E\uDD29\uD83D\uDE18\uD83D\uDE0D\uD83D\uDE04\uD83D\uDE05\uD83E\uDD14\uD83E\uDD28\uD83D\uDE10\uD83D\uDE11\uD83D\uDE36\uD83D\uDE44\uD83D\uDE0F\uD83D\uDE2B\uD83D\uDE2A\uD83D\uDE2F\uD83E\uDD10\uD83D\uDE2E\uD83D\uDE25\uD83D\uDE23\uD83D\uDE34\uD83D\uDE0C\uD83D\uDE1B\uD83D\uDE1C\uD83D\uDE1D\uD83E\uDD24\uD83D\uDE12\uD83D\uDC35\uD83D\uDC12\uD83E\uDD8D\uD83D\uDC36\uD83D\uDC15\uD83C\uDF0D\uD83C\uDF0F\uD83C\uDF0E\uD83C\uDF10\uD83D\uDE13\uD83D\uDE14\uD83D\uDE15\uD83D\uDE43\uD83D\uDE41\uD83E\uDD11\uD83D\uDE1F\uD83D\uDE16\uD83D\uDE1E\uD83D\uDE24\uD83D\uDE32\uD83D\uDE22☹️\uD83D\uDE2D\uD83D\uDE30\uD83D\uDE2C\uD83E\uDD2F\uD83D\uDE29\uD83D\uDE26\uD83D\uDE28\uD83D\uDE27\uD83D\uDE31\uD83D\uDE33\uD83E\uDD2A\uD83D\uDE35\uD83D\uDE21\uD83D\uDE20\uD83E\uDD2C\uD83D\uDE07\uD83E\uDD27\uD83E\uDD22\uD83E\uDD22\uD83E\uDD15\uD83D\uDE37\uD83E\uDD12\uD83E\uDD20\uD83E\uDD25\uD83E\uDD2B\uD83E\uDD2D\uD83E\uDDD0\uD83E\uDD13\uD83D\uDE08\uD83D\uDC7F\uD83E\uDD21\uD83D\uDC79\uD83D\uDC7D\uD83D\uDC7A\uD83E\uDD16\uD83D\uDC7E\uD83D\uDCA9\uD83D\uDC80\uD83D\uDE3A☠️\uD83D\uDE38\uD83D\uDC7B\uD83D\uDE39\uD83D\uDE48\uD83D\uDE3E\uD83D\uDE3F\uD83D\uDE3D\uD83D\uDE3C\uD83D\uDE3B\uD83D\uDE3C\uD83C\uDFC3\uD83D\uDEB6\uD83D\uDC83\uD83D\uDD7A\uD83D\uDC6F\uD83E\uDDD7\uD83E\uDDD8\uD83D\uDEC0\uD83E\uDD3A\uD83D\uDD74️\uD83D\uDC68\u200D\uD83D\uDC67\uD83D\uDC69\u200D\uD83D\uDC69\u200D\uD83D\uDC66\u200D\uD83D\uDC66\uD83D\uDC9F❣️\uD83D\uDC8C\uD83D\uDCA3\uD83D\uDCA5\uD83D\uDC95❤️\uD83D\uDC94\uD83D\uDC93\uD83D\uDC96\uD83D\uDC97\uD83D\uDC8B\uD83D\uDC98\uD83D\uDC9E\uD83D\uDC99\uD83D\uDC97\uD83D\uDC9D\uD83D\uDDA4\uD83D\uDC9C\uD83E\uDDE1\uD83D\uDC9B\uD83D\uDC9A\uD83D\uDC41️\u200D\uD83D\uDDE8️\uD83D\uDC41️\uD83E\uDDE0\uD83E\uDD1A\uD83E\uDD1C\uD83E\uDD1B\uD83D\uDC4A✊\uD83D\uDC4E\uD83D\uDC4D\uD83E\uDD1F\uD83D\uDC4B✍️\uD83D\uDC4F\uD83D\uDC42\uD83D\uDC43\uD83D\uDE4F\uD83D\uDC63\uD83D\uDC40\uD83E\uDD1D\uD83D\uDC85\uD83E\uDD32\uD83D\uDC3B\uD83D\uDC3C\uD83D\uDC28\uD83E\uDD83";
    public function AddCont($s) {
        $k = 0;
        for ($i = 0; $i < strlen($s); $i++) {
            
            $ss = (new Codebank())->getChar($s,$i);                               
            $k += strpos((new Codebank())->MyAlphas, $ss);           

        }
        

        return $k;
    }
    function getChar($str, $i){
        return substr($str, $i, 1);
    }

    function __construct(){
        $this->J_BinAlph = (new Constants())->J_BinAlph;
        $this->MyAlphas = (new Constants())->MyAlphas;
    }
    function Jsymb() {

    }

    public function base5equi($text){

        $s = "";
        for ($i = 0; $i < strlen($text); $i++) {
            $s1 = $this->getChar($text, $i);
            if ($s1 != $this->dash) {
                $s .= ($this->getjPos($s1));
            }
        }

        return ($s);
    }



    public function jAlphas(){
        return $this->J_BinAlph;
    }

    public function jcodex(){
        // return "%&^*!";
        return ",'^>!";
    }

    public function contains($s){
        return false;
    }

    public function getPos($s){
        $pos = -1;
        for ($i = 0; $i < strlen($this->jAlphas()) ; $i++) {
            $js = $this->getChar($this->jAlphas(), $i);

            if ($s == $js){
                $pos = $i;
                $i = 1000;
            }
        }
        return $pos;
    }

    public function getjPos($s){
        $pos = -1;
        for ($i = 0; $i < strlen($this->jcodex()) ; $i++) {
            $js = $this->getChar($this->jcodex(), $i);

            if ($s == $js){
                $pos = $i;
                $i = 10;
            }
        }
        return $pos;
    }

    public function getAlpha($pos){
        return $this->getChar($this->jAlphas(), $pos);
    }

    private function getCode($pos){
        $k = $pos;
        return $this->getChar($this->jcodex(), $k);
    }

    public function enBin($s){
        $pos = $this->getPos($s);
        return $pos%2;
    }

    private function enBas5($val){
        $vs = "";
        for ($i = 0; $i < 2; $i++) {
            $vs.=($val % 5);
            $val = ($val - ($val % 5)) / 5;


            if ($val == 0){
                $i = 100;
            }else {
                $i = 0;
            }
        }

        return ($vs);
    }

    function p($v, $to){
        $k = 1;
        for ($i = 0; $i < $to ; $i++) {
            $k = $k * $v;
        }

        return $k;
    }


    public function bas5to10($base5){
        $val = 0;
        for ($i = 0; $i < strlen($base5); $i++) {
            $v = (int) $this->getChar($base5,$i);
            $val = $val + $v*($this->p(5, $i));
        }

        return $val;
    }

    public function operate($vposi, $svpos, $jval, $text){

        $vpos = $vposi;
        $k = strlen($this->jAlphas());
        $lenght = strlen($text);
        $kk = $vpos;
        if ($jval == 1){
            $vpos = ($vpos - $svpos + $lenght);
            //Log.d("working" + " param" + (jAlphas().charAt(kk)), "wvpos:" + vpos);
        }
        if ($jval == 0){
            $vpos = ($vpos + $svpos + $lenght);
            //Log.d("working" + " param" + (jAlphas().charAt(kk)), "wvpos:" + vpos);
        }


        if ($vpos < 0){
            $vpos = ($vpos + $k);
        }

        $vpos = $vpos % $k;

        return $this->extractjCode($vpos);
        
    }

    function extractjCode($vpos){
        $s = $this->enBas5($vpos);

        $coded = "";
        for ($i = 0; $i < strlen($s) ; $i++) {
            $num = $this->getChar($s, $i);
            $coded .= ($this->getCode($num));

            if ($i + 1 == strlen($s)){
                $coded .= ($this->dash);
            }
        }

        return $coded;
    }

    public function deOperate($svpos, $jvpos, $text, $length){

        $k = strlen($this->jAlphas());

        //Log.d("Your message", text);

        //Log.d("Your svpos", String.valueOf(svpos));

        //Log.d("Yoursvposlet", getAlpha(svpos));

        //Log.d("Yourjvposlet", getAlpha(jvpos));


        //Log.d("Your jval", String.valueOf(jvpos));


        //Log.d("Your k", String.valueOf(k));


        $length = $length % $k;
        //Log.d("Your length", String.valueOf(length));

        $s = $this->base5equi($text);
        //Log.d("Your bin5equi", s);

        $vpos = ($this->bas5to10($s));
        //Log.d("Your vpos", String.valueOf(vpos));

        $vpos = $vpos - $length;



        if ($jvpos == 1){
            $vpos = $vpos + $svpos;
        }
        if ($jvpos == 0){
            $vpos = $vpos - $svpos;
        }

        $vpos = ($vpos) % $k;
        $vpos = ($vpos + $k) % $k;

        //Log.d("Your final vpos", String.valueOf(vpos));




        return ($vpos);
    }



}
class MessageBody {
    public $mess = "INVALID";
    public $validity = false;

    public function getMessage() {
        return $this->mess;
    }

    public function setMess($mess) {
        $this->mess = $mess;
    }
    
    public function isValid() {
        return $this->validity;
    }

    public function setValidity($validity) {
        $this->validity = $validity;
    }

    public function __construct($mess, $validity) {
       
        if ($mess != ""){
            $this->mess = $mess;
        }
        $this->validity = $validity;
    }

    public function MessageBody() {

    }

}
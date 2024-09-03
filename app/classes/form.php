<?php

  class Form {

  // database connection and table name
    public $data = null;
    public $referer = null;

    // constructor
    public function __construct(array $data){

        $this->data = $data;
        $this->referer = $_SERVER['HTTP_REFERER'];

    }

    private function validate() {

        if(isset($this->data) && isset($this->referer)) return true;
        else return false;

    }

    public function sendToSalesForce() {

       if ($this->validate()) {
         $parser = parse_url($this->referer);
         $url = $parser['scheme']."://".$parser['host'].$parser['path'];
         $data = array();
         $data['oid'] = "00D09000003RrTq";
         $data['retURL'] = $url;
         if( isset($_SESSION['query']) ) $data['00N09000000omFh'] = $_SESSION['query'];
         foreach ($this->data as $key => $value) {
           $data[$key] = $value;
         }
         $sf_url = "http://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8";
         $curl = curl_init($sf_url);
         curl_setopt($curl, CURLOPT_POST, true);
         curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         $response = curl_exec($curl);
         var_dump($response);
       }
       else echo "Error";

    }

    public function sendToSlack($file = NULL) {

      if ($this->validate()) {
        $parser = parse_url($this->referer);
        $url = $parser['scheme']."://".$parser['host'].$parser['path'];

        if( isset($_SESSION['query']) ) $data['text'] = "Сбамит формы: ".$url."\nUTM: ".$_SESSION['query']."\n";

        else $data['text'] = "Сбамит формы: ".$url."\n";

        foreach ($this->data as $key => $value) {
          $data['text'] .= $key." - ".$value."\n";
        }

        // if()

        $data['username'] = "Малолетний Раб";
        $data['icon_emoji'] = ":child::skin-tone-6:";

        $json = json_encode($data);
        
        $slack_url = "https://hooks.slack.com/services/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";
        $ch = curl_init($slack_url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $results = curl_exec($ch);
        curl_close($ch);

        $slacktoken = "xoxp-2933831750999-2950752016948-2948584514851-70dacabb91335f9f489469d64636aa42";
        $header = array();
        $header[] = 'Content-Type: multipart/form-data';

        if($file != NULL) {
          $fileSlack = new CurlFile($file['tmp_name'] , $file['type']);
        }

        $postitems =  array(
            'token' => $slacktoken,
            'file' =>  $fileSlack,
            'channels' => "C02U97LC4HX",
            'title' => "прикрепленный файл от : " . $this->data['name'],
            'filename' => $file['name']
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, "https://slack.com/api/files.upload");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postitems);

        //Execute curl and store in variable
        $results = curl_exec($ch);
        curl_close($ch);
      }
    }


  }
?>

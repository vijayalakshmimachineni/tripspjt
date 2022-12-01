<?php
class Email {   
  public $To;
  public $From;
  public $Subject;
  public $Message;
  public $Attachment;
  public $TemplateId;
  public $Params = array();
  public function __construct() {
    $this->Attachment = NULL;    
    $this->From = ''; 
  }
  private function prepareTemplate() {
    $sql = "SELECT template_name, template_subject, template_content FROM ".DB_PREFIX."email_template WHERE template_id='".$this->TemplateId."'";
    $db = getDB();
    $stmt = $db->prepare($sql);  
    $res = $stmt->execute();
    $template = $stmt->fetch(PDO::FETCH_OBJ);
    $this->Message = strtr($template->template_content, $this->Params);
    $this->Subject = $template->template_subject;
    return true;
  }
  public function send() {
    $templete = $this->prepareTemplate();
    $post = array('from' => $this->From,
        'fromName' => '',
        'apikey' => '',
        'subject' => $this->Subject,
        'to' => $this->To,
        'bodyHtml' => $this->Message,
        'bodyText' => '',
        'isTransactional' => false);
    $ch = curl_init();
    curl_setopt_array($ch, array(
    CURLOPT_URL => 'https://api.elasticemail.com/v2/email/send',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $post,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => false,
    CURLOPT_SSL_VERIFYPEER => false
    ));
    $result=curl_exec ($ch);
    curl_close ($ch);
    //echo $result;   
  }    
}
?>
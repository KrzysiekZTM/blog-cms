<?php

class Media extends Dbh{

  private $limit;
  private $offset;

  function __construct($limit = null, $offset = null){
    $this->limit = $limit;
    $this->offset = $offset;
  }

  public function get_all_media(){
    try {
      $sql = "SELECT * FROM media";
      if($this->limit !== null && $this->offset !== null){
        $query = $this->connect()->prepare($sql." LIMIT ? OFFSET ?");
        $query->bindParam(1, $this->limit, PDO::PARAM_INT);
        $query->bindParam(2, $this->offset, PDO::PARAM_INT);
      }else{
        $query = $this->connect()->prepare($sql);
      }
      $query->execute();
      $output = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      $error_message = "Media Error: ".$e->getMessage();
    }

    if(isset($error_message)){
      return false;
    }else{
      return $output;
    }
  }

  public static function add_media($file_name, $alt_tag){
    $dbh = new Dbh;
    try {
      $sql = "INSERT INTO media VALUES(NULL, ?, ? )";
      $query = $dbh->connect()->prepare($sql);
      $query->bindParam(1, $file_name, PDO::PARAM_STR);
      $query->bindParam(2, $alt_tag, PDO::PARAM_STR);
      $query->execute();
    } catch (Exception $e) {
      $error_message = $e->getMessage();
    }

    if(isset($error_message)){
      return $error_message;
    }else{
      return "success";
    }

  }

  public function delete_media(){

  }
}

<?php
function errorCheck($sql,$conn,$result,$task,$name){
    if ($result == TRUE) {
      if($task == "update"){
        echo $name . "'s record updated successfully.";
      }else{
        echo $name . "'s record created successfully.";
      }
    } else {
      echo "Error:" . $sql . "<br>" . $conn->error;
    }
  }
?>
<?php
/*Created by : Lonwabo Tsipa, Asavela Mzilikazi, Zalisekile Coto*/
  session_start();
  //session_destroy();
  $page ='index.php';
  require 'Book.php';
  require 'connector.php';
      
  if (isset($_GET['id'])){    
        $bookspecific = mysqli_query($con,'SELECT isbn,price,id,ownerUsername FROM bookspecific WHERE id="'.$_GET['id'].'"');
        $result = mysqli_fetch_object($bookspecific);
        
        $resultG = mysqli_query($con,'SELECT title FROM bookgeneral WHERE isbn="'.$result->isbn.'"');
        $titleResult = mysqli_fetch_object($resultG);

        $resultGeneral = mysqli_query($con,'SELECT count(*) as rawNumber FROM bookspecific WHERE isbn="'.$result->isbn.'"');
        $count = mysqli_fetch_object($resultGeneral);
        $book =new Book();
        $book->setBookID($result->id);
        $book->setBookIsbn($result->isbn);
        $book->setQuantity(1);
        $book->setBookTitle($titleResult->title);
        $book->setBookPrice($result->price);
        $book->setBookTotPrice($result->price);
        $book->setUsername($result->ownerUsername);

        $index = -1;
        $flag = false;
        if(!isset($_SESSION['book'])){$_SESSION['book'] = array();}
        $cart = unserialize(serialize($_SESSION['book']));
        for ($i=0; $i <count($cart); $i++){
          if ($cart[$i]->getBookIsbn()==$result->isbn) { $index = $i; break; }
        }

        if ($index==-1) { $_SESSION['book'][]=$book; }
        else {
              if($count->rawNumber != $cart[$index]->getQuantity()){ // check the Quantity 
                for ($i=0; $i <count($cart); $i++) { 
                    if($cart[$i]->getBookID()==$result->id){$flag=true; break;} // check if the specific book has been add
                }
                if (!$flag==true) {
                  $cart[$index]->setQuantity($cart[$index]->getQuantity()+1); // increases Quantity
                  $cart[$index]->setBookPrice($result->price);
                  $cart[$index]->setBookTotPrice($cart[$index]->getBookTotPrice()+$cart[$index]->getBookPrice());
                  $_SESSION['book']=$cart;
                }
              }
            }
  }

  function getRemoveBtn($id,$isbn){
     if(!isset($_SESSION['book'])){$_SESSION['book'] = array();}
     $cart = unserialize(serialize($_SESSION['book']));
     for ($i=0; $i <count($cart); $i++) {
          if($cart[$i]->getBookID()==$id) { 
          echo '<a href="cart.php?remove='.$id.'"><input  type="button" name="removeFromCart" value="Remove from Cart"  class="cartDiv"/></a>';
          $i=count($cart);
        }
     }
    // header('Location:'.$page);//back to index
  }

  if(isset($_GET['remove'])){
    if(!isset($_SESSION['book'])){$_SESSION['book'] = array();}
    $cart = unserialize(serialize($_SESSION['book'])); 
    for ($i=0; $i <count($cart) ; $i++) { 
         if($cart[$i]->getQuantity()==1){ 
          unset($cart[$i]);
          $cart = array_values($cart);
          }  else{
            $cart[$i]->setQuantity($cart[$i]->getQuantity()-1);
           // $cart[$i]->setBookPrice($cart[$i]->getBookPrice());
            $cart[$i]->setBookTotPrice($cart[$i]->getBookTotPrice()-$cart[$i]->getBookPrice());
          }
          $_SESSION['book']=$cart;

    }
     header('Location:'.$page);//back to index
  }


  if (isset($_GET['delete'])){
     $cart = unserialize(serialize($_SESSION['book']));
     for ($i=0; $i <count($cart); $i++) { 
      if($cart[$i]->getBookIsbn()==$_GET['delete']){ unset($cart[$i]); break;} // check if the specific index
      }
      $cart = array_values($cart);
      $_SESSION['book']=$cart;
  }
  if (isset($_GET['CheckOut'])){
       if(!isset($_SESSION['book'])){$_SESSION['book'] = array();}
       $cart = unserialize(serialize($_SESSION['book']));
       for ($i=0; $i <count($cart); $i++) { 
        if($i>-1){
            $sql   ="UPDATE bookspecific SET status='reserved' WHERE id='".$cart[$i]->getBookID()."'";
            $order ='INSERT INTO orders values("'.getUsername().'","'.$cart[$i]->getBookID().'");';
            if ($con->query($sql) === TRUE) {
                $con->query($order);
                $_SESSION['book'] = array();
            }
         }
        }
     header('Location:'.$page);//back to index
  }
  if(isset($_GET['clear'])){
     if(!isset($_SESSION['book'])){$_SESSION['book'] = array();}
     else{$_SESSION['book'] = array();}
      header('Location:'.$page);//back to index
  }
  function totalCharges(){
    if(!isset($_SESSION['book'])){$_SESSION['book'] = array();}
     $cart = unserialize(serialize($_SESSION['book']));
     $sum= 0;
     for ($i=0; $i <count($cart); $i++) { 
          $sum += $cart[$i]->getBookTotPrice();
     }
    echo $sum; 
  }
  function clear(){
    if(!isset($_SESSION['book'])){$_SESSION['book'] = array();}
     $cart = unserialize(serialize($_SESSION['book']));
     for ($i=0; $i <count($cart); $i++){ 
      if($i>-1){
        echo '<a href="cart.php?clear"><button type="button" name="clear"class="clear">Clear Cart</button></a>';
        break;
        }
    }
  }
  function cart()
  {
    global $index;
    if(!isset($_SESSION['book'])){$_SESSION['book'] = array();}
     $cart = unserialize(serialize($_SESSION['book']));
     for ($i=0; $i <count($cart); $i++) { 
      echo '<tr>';
            echo '<td>R '.$cart[$i]->getBookTotPrice().'</td>';
            echo '<td align="center">'.$cart[$i]->getQuantity().' </td>' ; 
            echo '<td>'.substr($cart[$i]->getBookTitle(), 0,16).'..</td>'; 
            echo '<td align="center"> <a href="index.php?delete='.$cart[$i]->getBookIsbn().'"><img src="images/remove.png"></a></td>';
       echo '</tr>';
      $index++;
     }
  }

  function getUsername()
  {
    if (isset($_SESSION['username']))
    {
      return $_SESSION['username'];
    }
    else return false;
  }

?>

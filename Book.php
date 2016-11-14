<?php 
/*Created by : Lonwabo Tsipa, Asavela Mzilikazi, Zalisekile Coto*/
     class Book
	{
		 private $id;
		 private $title;
		 private $isbn;
		 private $quantity;
		 private $username;
		 private $price =0;
		 private $totalPrice=0;

		function setBookID($id){
			$this->id = $id;
		}
		function setBookTitle($title){
			$this->title = $title;
		}
		function setBookPrice($price){
			$this->price = $price;
		}
		function setBookIsbn($isbn){
			$this->isbn = $isbn;
		}
		function setQuantity($quantity){
			$this->quantity =$quantity;
		}
		function getQuantity(){
			return $this->quantity;
		}
		function getBookIsbn(){
			return $this->isbn;
		}
		function getBookID(){
			return $this->id ;
		}
		function getBookTitle(){
			return $this->title;
		}
		function getBookPrice(){
			return $this->price;
		}
		function setBookTotPrice($totalPrice){
			$this->totalPrice=$totalPrice;
		}
		function getBookTotPrice(){
			return $this->totalPrice;
		}
		function setUsername($username){
			$this->username=$username;
		}
		function getUsername(){
			return $this->username;
		}

	}
 ?>
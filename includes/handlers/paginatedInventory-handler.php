<?php 
  // include('../../config.php');


function get_products($con) {

$term = $_SESSION['retailerLoggedIn'];
$term = ucfirst($term);
$query = mysqli_query($con, "SELECT * FROM inventory WHERE supplierId = (SELECT id FROM retailer WHERE emailid = '$term')");
// confirm($query);

  if(!$query){
    echo "No data to show.";
    return "";
  }

$rows = mysqli_num_rows($query); // Get total of mumber of rows from the database


if(isset($_GET['page'])){ //get page from URL if its there

    $page = preg_replace('#[^0-9]#', '', $_GET['page']);//filter everything but numbers



} else{// If the page url variable is not present force it to be number 1

    $page = 1;

}


if(isset($_SESSION['perPage'])){
  $perPage = $_SESSION['perPage'];
}
else{
  $perPage = 5;
}

$lastPage = ceil($rows / $perPage); // Get the value of the last page


// Be sure URL variable $page(page number) is no lower than page 1 and no higher than $lastpage

if($page < 1){ // If it is less than 1

    $page = 1; // force if to be 1

}elseif($page > $lastPage){ // if it is greater than $lastpage

    $page = $lastPage; // force it to be $lastpage's value

}



$middleNumbers = ''; // Initialize this variable

// This creates the numbers to click in between the next and back buttons


$sub1 = $page - 1;
$sub2 = $page - 2;
$add1 = $page + 1;
$add2 = $page + 2;



if($page == 1){

      $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

      if($lastPage != 1){
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';
      }

} else if ($page == $lastPage) {
    
      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';
      $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

}else if ($page > 2 && $page < ($lastPage -1)) {

      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub2.'">' .$sub2. '</a></li>';

      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';

      $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

         $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';

      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'">' .$add2. '</a></li>';

     


} else if($page > 1 && $page < $lastPage){

     $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';

     $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
 
     $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';


     


}


// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query


$limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;




// $query2 is what we will use to to display products with out $limit variable

$term = ucfirst($term);
    $query2 = mysqli_query($con, "SELECT inventory.itemId, medicine.medId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack, inventory.quantity FROM inventory 
INNER JOIN medicine ON inventory.medId = medicine.medId

INNER JOIN brandname ON medicine.brandId = brandname.brandId
INNER JOIN manufacturer ON medicine.manId = manufacturer.manId
INNER JOIN dosageform ON medicine.formId = dosageform.formId
WHERE inventory.supplierId=(SELECT id FROM retailer WHERE emailid = '$term') $limit");
// confirm($query2);

    if(!$query2){
    echo "No data to show.";
    return "";
  }

$data = array();

    while($row = mysqli_fetch_array($query2)){
      array_push($data, $row);
    }

    //Fetch the drugnames included in the specific medicines
    //Fetch the strengths of each drug included in the medicine
    for ($x = 0; $x < sizeof($data) ; $x++){
      $medId = $data[$x]['medId'];
      $query2 = mysqli_query($con, "SELECT genericname.drugName, medigeneric.strength FROM genericname
      INNER JOIN medigeneric ON genericname.drugId = medigeneric.drugId
      WHERE medigeneric.medId = '$medId'");

      $data[$x]['drugs'] = array();
      $data[$x]['strengths'] = array();
      while($row = mysqli_fetch_array($query2)){
        // array_push($data, $row);
        array_push($data[$x]['drugs'],$row['drugName']);
        array_push($data[$x]['strengths'],$row['strength']);
      }
    }


$outputPagination = ""; // Initialize the pagination output variable


// if($lastPage != 1){

//    echo "Page $page of $lastPage";


// }


  // If we are not on page one we place the back link

if($page != 1){


    $prev  = $page - 1;

    $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'">Back</a></li>';
}

 // Lets append all our links to this variable that we can use this output pagination

$outputPagination .= $middleNumbers;


// If we are not on the very last page we the place the next link

if($page != $lastPage){


    $next = $page + 1;

    $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'">Next</a></li>';

}


// Doen with pagination



// Remember we use query 2 below :)
    $i=($page-1)*$perPage +1;
    $count=0; // number on the table to be used in edit-panel toggling

  foreach($data as $d){
    // echo $i; echo "<br>";
    // echo $d['brandName']; echo "<br>";
    $brandName = $d['brandName'];
    $manName = $d['manName'];
    $formName = $d['formName'];
    $pack = $d['pack'];
    $itemId = $d['itemId'];

    $quantity = $d['quantity'];

    $drugs = ''; $numDrugs = sizeof($d['drugs']);
    for($x=0; $x < $numDrugs; $x++){
      $drugs .= $d['drugs'][$x] . ': ' . $d['strengths'][$x];

      if(($x+1)!=$numDrugs){
        $drugs .= ", " . "<br>";
      }
    }

    $product = <<<DELIMETER

<tr>
  <td>$i</td>
  <td>$brandName</td>
  <td>$manName</td>
  <td>$drugs</td>
  <td>$formName</td>
  <td>$pack</td>
  <td>$quantity</td>
  <td class='edit-col'>
    <div class='row'>

      <div id='$count' style="display: none;"></div>
      <div id="$itemId" class="ti-pencil-alt zoom col-sm-6"></div>
      <div id="$itemId" class="ti-cut zoom col-sm-6"></div>
    
    </div>
  </td>

</tr>
<tr class='edit-container'></tr>
<tr></tr>

DELIMETER;
$i++; $count++;
echo $product;
  }


  
  return $outputPagination;

}

// <td colspan="8" class="edit-panel">
//     <form class="pull-right">
//       <input type="hidden" name="itemId">
//       <input type="number" name="quantity">
//       <input type="submit" name="submitChangeQuantity">
//     </form>
//   </td>


 ?>
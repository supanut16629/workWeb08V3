<?php
session_start();
$servername ="localhost";
$username="root";
$password="123456789";
$dbname="shop";
$per_page=5;
$start_page=0;
if(isset($_GET['page'])) $start_page=$_GET['page']*$per_page;
else $start_page=0;
//create connection
$con=mysqli_connect($servername,$username,$password,$dbname);
if(!$con){
    die("Connect mysql database fail !!".mysqli_connect_error());
}

//echo "Connect mysql successfully";
$sql="SELECT * FROM product";
$result=mysqli_query($con,$sql);
$numrow=mysqli_num_rows($result);
echo "<h1> FinalMouse Shop</h1>";
echo "<h3>  Finalmouse gaming mouse shop ,etc </h3>";
echo "There are ".$numrow." products in total.<br>";
echo "page".($_GET["page"]+1).'/'.($numrow/$per_page)."<br>";
//echo "<br>".$numrow." record<br>";

$prev = $_GET["page"]-1;
$next = $_GET["page"]+1;
if($prev ==-1)
    $prev = 0;
if($prev == ($numrow/$per_page))
    $next = $next-1;

//prev
echo "<button onclick=location.href='index.php?page=$prev'> previous </button>";
// paging 1-50 
for($i=0;$i<ceil($numrow/$per_page);$i++)
    echo "<a href='index.php?page=$i'>[".($i+1)."]</a>";
//next
echo "<button onclick=location.href='index.php?page=$next'> next </button>";


$sql="SELECT * FROM product LIMIT $start_page,$per_page";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0){
    echo "<table border=1><tr><th>id</th><th>name</th><th>description</th><th>price</th></tr>"; //<th></th>
    while($row=mysqli_fetch_assoc($result)){
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>";
        echo $row["description"]."</td><td>".$row["price"]."</td></tr>";
        //echo "<td><a href='add_product.php?id=".$row["id"]."'>ใส่ตะกร้า</td></tr>";
    }
    echo "</table>";
}else{
    echo "0result";
}
// if(isset($_SESSION["cart"])){
//     $total=0;
//     echo "<h1>ตระกร้าสินค้า</h1>";
//     echo "<table><tr><th>ลำดับ</th><th>id</th><th>name</th><th>description</th><th>price</th></tr>";
//         for($i=0;$i<count($_SESSION["cart"]);$i++)
//         {
//             $item=$_SESSION["cart"][$i];
//             echo "<tr><td>".($i+1)."</td>";
//             echo "<td>".$item['id']."</td>";
//             echo "<td>".$item['name']."</td>";
//             echo "<td>".$item['description']."</td>";
//             echo "<td>".$item['price']."</td>";
//             echo "<td><a href='del_cart.php?i=".$i."'>";
//             echo "<font color='red'>x</font></a></td></tr>";
//             $total+=$item['price'];
//         }
//     echo "</table>";
//     echo "<h1>ราคาสิ้นค้า $total บาท</h1>";
//     echo "<h2><a href='checkout.php'>สั่งซื้อ</h2>";
//     }
mysqli_close($con);
?>

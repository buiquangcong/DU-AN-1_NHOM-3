<?php
class AdminThongKeModel {
public function countTours() {
$sql = "SELECT COUNT(*) as total FROM dm_tours";
$result = pdo_query_one($sql); 
return $result['total'];
}
 public function countDanhMuc() {
  $sql = "SELECT COUNT(*) as total FROM dm_loai_tour";
   $result = pdo_query_one($sql);
   return $result['total'];
}
public function countTaiKhoan() {
    $sql = "SELECT COUNT(*) as total FROM dm_tai_khoan";
    $result = pdo_query_one($sql);
     return $result['total'];
}
 public function countBooking() {
    $sql = "SELECT COUNT(*) as total FROM booking"; 
    $result = pdo_query_one($sql);
    return $result['total'];
}
   public function getRecentTours() {
   $sql = "SELECT * FROM dm_tours ORDER BY ID_Tour DESC LIMIT 5";
   return pdo_query($sql);
}
}
?>

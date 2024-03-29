<?php
class Danhsach
{
    var $ten;
    var $email;
    var $sdt;
    function __construct ($ten, $email, $sdt) {
        $this->ten = $ten;
        $this->email = $email;
        $this->sdt = $sdt;
      
    }
    static function connect(){
        //B1: Tạo kết nối
        $conn = new mysqli("localhost","root","","danhba","3300");
        //B2: Thao tác với CSDL: CRUD
        if($conn->connect_error)
            die("Kết nối thất bại. Chi tiết:" . $conn->connect_error);
        $conn->set_charset("utf8"); //Hướng đối tượng
        //mysqli_set_charset($conn,"utf8"); -- Hướng thủ tục   
        return $conn;
    }
    static function getListFromDB(){
        $conn = Danhsach::connect();
        $sql = "SELECT * FROM Contact";
        $result = $conn->query($sql);
        $lsDs = array();
        if($result->num_rows > 0){
            while($row = $result -> fetch_assoc()){
               
                $ds = new Danhsach($row["Ten"],$row["Email"],$row["SDT"]);              
                array_push($lsDs, $ds);
            }
        }
        //B3: Giải phóng kết nối
        $conn->close();
        return $lsDs;
    }
    static function add(Danhsach $content){
        $conn = Danhsach::connect(); 
        $sql = "INSERT INTO contact (Ten,Email,SDT) VALUES ('$content->ten', '$content->email', $content->sdt)";
        $result = $conn->query($sql);
        if($result == true)
            echo 'Tạo thành công';
        // else echo 'Tạo thất bại';
        //B3: Giải phóng kết nối
        $conn->close();
       
    }
    static function edit(Danhsach $content){
        $conn = Danhsach::connect(); 
        $sql = "UPDATE contact SET Ten = '$content->ten' , Email = '$content->email' , SDT = '$content->sdt' WHERE Ten = '$content->ten'";
        $result = $conn->query($sql);
        // if($result == true)
        //     echo 'Sửa thành công';
        // else echo 'Sửa thất bại';
        //B3: Giải phóng kết nối
        $conn->close(); 
    }
    static function delete($ten){
        $conn = Danhsach::connect(); 
        $sql = "DELETE FROM contact WHERE Ten =' $ten'";
        $result = $conn->query($sql);
        if($result == true)
            echo 'Xóa thành công';
        else echo 'Xóa thất bại';
        //B3: Giải phóng kết nối
        $conn->close(); 
    }
    static function Timkiem($search)
    {
        $conn=Danhsach::connect();
        if (empty($search)) {
            echo "Yeu cau nhap du lieu vao o trong";
        } 
        else
        {
            // Dùng câu lênh like trong sql và sứ dụng toán tử % của php để tìm kiếm dữ liệu chính xác hơn.
            $sql = "SELECT * FROM Contact where $search->ten like '%$search%'";
            // Thực thi câu truy vấn
            $sql = $conn->query($sql);

            // Đếm số đong trả về trong sql.
            $num = mysql_num_rows($sql);

            // Nếu có kết quả thì hiển thị, ngược lại thì thông báo không tìm thấy kết quả
            if ($num > 0 && $search != "") 
            {
                // Dùng $num để đếm số dòng trả về.
                echo "$num ket qua tra ve voi tu khoa <b>$search</b>";

                // Vòng lặp while & mysql_fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
                echo '<table border="1" cellspacing="0" cellpadding="10">';
                while ($row = mysql_fetch_assoc($sql)) {
                    echo '<tr>';
                        echo "<td>{$row["Ten"]}</td>";
                        echo "<td>{$row['Email']}</td>";
                        echo "<td>{$row['SDT']}</td>";
                       
                    echo '</tr>';
                }
                echo '</table>';
            } 
            else {
                echo "Khong tim thay ket qua!";
            }
       
        }
    }
}
?>
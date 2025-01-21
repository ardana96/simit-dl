<?php
session_start();
// Koneksi ke database
$server = "localhost";
$username = "root";
$password = "dlris30g";
$database = "sitdl";

$conn = mysql_connect($server, $username, $password);
mysql_select_db($database, $conn);


// Mengambil data dari POST
$bulan = $_POST['bulan']; // Ambil bulan dari request
$idpc = $_POST['idpc'];
$user = $_POST['user'];
$lokasi = $_POST['lokasi'];
$tipe_perawatan_id = $_POST['tipe_perawatan_id'];
$tahun = $_POST['tahun'];
$selectedItems = $_POST['selected_items']; // Array checkbox yang dicentang
$unselectedItems = $_POST['unselected_items'];
$tanggal = date("Y-m-d");
//$treated_by=$_SESSION['user'];
$treated_by = $_POST['treated_by'];
$keterangan = $_POST['keterangan'];
$approve_by = $_POST['approve_by'];



//simpan ke tabel ket_perawatan 
$exist_ket_perawatan = mysql_query("SELECT * FROM ket_perawatan WHERE idpc = '$idpc' AND tahun = '$tahun' AND bulan = '$bulan' AND treated_by = '$treated_by' ");
$exist_ket_perawatan_count = mysql_num_rows($exist_ket_perawatan);

echo $exist_ket_perawatan_count;
if($exist_ket_perawatan_count == 0){
        $query_ket = "INSERT INTO ket_perawatan (idpc, treated_by, ket, tahun,bulan, approve_by ) 
                VALUES ('$idpc', '$treated_by', '$keterangan', '$tahun', '$bulan', '$approve_by')";
                mysql_query($query_ket, $conn);
                 
}else{
    $query_ket = "UPDATE ket_perawatan SET ket = '$keterangan', approve_by = '$approve_by' WHERE idpc = '$idpc' AND tahun = '$tahun' AND bulan = '$bulan' AND treated_by = '$treated_by' ";
    mysql_query($query_ket, $conn);
    
}
//add perawatan
if(count($selectedItems ) >0 ){
    foreach ($selectedItems as $itemId) {
        //$query_exist = "SELECT * FROM perawatan WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun'";
        $query_exist =  mysql_query( "SELECT id FROM perawatan WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun' AND bulan = '$bulan' ");
        $exist_count = mysql_num_rows($query_exist);

        
        if($exist_count == 0){
            $query = "INSERT INTO perawatan (idpc, tipe_perawatan_id, tipe_perawatan_item_id, tanggal_perawatan, bulan)
                VALUES ('$idpc', '$tipe_perawatan_id', '$itemId', '$tanggal' , '$bulan')";
                
        }else{
            continue;
        }
        
        mysql_query($query, $conn);
        
    }
}

//remove perawatan
if(count($unselectedItems ) >0 ){

    foreach ($unselectedItems as $itemId) {
        //$query_exist = "SELECT * FROM perawatan WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun'";
        $query_exist =  mysql_query( "SELECT id FROM perawatan WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun' AND bulan = '$bulan' ");
        $exist_count = mysql_num_rows($query_exist);
        // $row	= mysql_fetch_array($query_exist); 
        // $idperawatan = $row[0];
        
       
        // Jika data ditemukan, ambil ID perawatan
        if ($exist_count > 0) {
            $row = mysql_fetch_array($query_exist);
            $idperawatan = $row['id'];
            
            // Hapus data berdasarkan ID yang ditemukan
            $querydelete = "DELETE FROM perawatan WHERE id = '$idperawatan'";
            mysql_query($querydelete, $conn);
        }else{
            continue;
        }
        // if($exist_count == 0){
        //     $querydelete = "DELETE FROM perawatan WHERE id = '$idperawatan'  ";
        // }else{
        //     continue;
        // }
        
    
       // mysql_query($querydelete, $conn);
    }
}



// Cek jika ada data yang berhasil disimpan
if (mysql_affected_rows($conn) > 0) {
    echo "Data berhasil disimpan.";
    //echo $exist_count;
} else {
    echo "Gagal menyimpan data.";
}

// Tutup koneksi
mysql_close($conn);
?>
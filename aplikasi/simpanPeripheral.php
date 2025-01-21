<?php
include('../config.php'); // Pastikan config.php sudah dimuat

if(isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];
    $id_perangkat = $_POST['id_perangkat'];
    $perangkat = $_POST['perangkat'];
    $keterangan = $_POST['keterangan'];
    $divisi = $_POST['divisi'];
    $nama_user = $_POST['nama_user'];
    $lokasi = $_POST['lokasi'];
    $bulan = $_POST['bulan'];
    $tgl_perawatan = $_POST['tgl_perawatan'];
    $tipe = $_POST['tipe'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $pembelian_dari = $_POST['pembelian_dari'];
    $sn = $_POST['sn'];

    // Query INSERT tanpa TipePerawatan
    $query_insert = "INSERT INTO peripheral 
    (nomor, id_perangkat, perangkat, keterangan, divisi, user, lokasi, bulan, tgl_perawatan, tipe, brand, model, pembelian_dari, sn) 
    VALUES 
    ('".mysql_real_escape_string($nomor)."', 
     '".mysql_real_escape_string($id_perangkat)."', 
     '".mysql_real_escape_string($perangkat)."', 
     '".mysql_real_escape_string($keterangan)."', 
     '".mysql_real_escape_string($divisi)."', 
     '".mysql_real_escape_string($nama_user)."', 
     '".mysql_real_escape_string($lokasi)."', 
     '".mysql_real_escape_string($bulan)."', 
     '".mysql_real_escape_string($tgl_perawatan)."', 
     '".mysql_real_escape_string($tipe)."', 
     '".mysql_real_escape_string($brand)."', 
     '".mysql_real_escape_string($model)."', 
     '".mysql_real_escape_string($pembelian_dari)."', 
     '".mysql_real_escape_string($sn)."')"; // Hapus koma berlebih

    // Eksekusi query dengan MySQL lama
    $update = mysql_query($query_insert);

    // Cek apakah berhasil atau gagal
    if($update) {
        header("location:../user.php?menu=peripheral&stt=Simpan Berhasil");
        exit();
    } else {
        die("Error Query: " . mysql_error());
    }
}
?>






<?php
// // include('../config.php');
// // if(isset($_POST['tombol'])){
	
// // $nomor=$_POST['nomor'];
// // $id_perangkat=$_POST['id_perangkat'];
// // $perangkat=$_POST['perangkat'];
// // $keterangan=$_POST['keterangan'];
// // $divisi=$_POST['divisi'];
// // $nama_user = $_POST['nama_user'];
// // $lokasi = $_POST['lokasi'];
// // $bulan = $_POST['bulan'];
// // $tgl_perawatan = $_POST['tgl_perawatan'];
// // $tipe = $_POST['tipe'];
// // $brand = $_POST['brand'];
// // $model = $_POST['model'];
// // $pembelian_dari = $_POST['pembelian_dari'];
// // $sn = $_POST['sn'];


// // $query_insert="insert into peripheral (nomor,id_perangkat,perangkat,keterangan,divisi,user,lokasi, bulan, tgl_perawatan, tipe, brand, model, pembelian_dari, sn) 
// // values ('".$nomor."','".$id_perangkat."','".$perangkat."','".$keterangan."','".$divisi."','".$nama_user."','".$lokasi."','".$bulan."',
// // 		'".$tgl_perawatan."', '".$tipe."','".$brand."', '".$model."', '".$pembelian_dari."', '".$sn."')";	
// // $update=mysql_query($query_insert);
// // if($update){
// // header("location:../user.php?menu=peripheral&stt= Simpan Berhasil");}
// // else{
// // header("location:../user.php?menu=peripheral&stt=gagal");}}
?>
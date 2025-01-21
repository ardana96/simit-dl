<?php
session_start();
// Koneksi ke database
$server = "localhost";
$username = "root";
$password = "dlris30g";
$database = "sitdl";

$conn = mysql_connect($server, $username, $password);
mysql_select_db($database, $conn);

$query = "SELECT * FROM pcaktif WHERE nomor=0";

if (!empty($_GET['perangkat'])) {
    $perangkat = mysql_real_escape_string($_GET['perangkat']);
    $tahun = mysql_real_escape_string($_GET['tahun']);
    $bulan = mysql_real_escape_string($_GET['bulan']);
    $qry	= mysql_query("SELECT nama_perangkat FROM tipe_perawatan WHERE id = $perangkat");
    $row	= mysql_fetch_array($qry); 
    $tipe = strtolower($row[0]);


    $qry_item = mysql_query("SELECT id as jumlahperawatan FROM tipe_perawatan_item WHERE tipe_perawatan_id = $perangkat");
    $jumlahperawatan = mysql_num_rows($qry_item);


    if(strtolower($tipe) == 'pc dan laptop')
    {
        $query = "SELECT 
                    idpc, 
                    user, 
                    lokasi, 
                    model AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = pcaktif.idpc AND  YEAR(tanggal_perawatan) = $tahun ) AS hitung,
                    (SELECT tanggal_perawatan FROM perawatan WHERE perawatan.idpc = pcaktif.idpc AND  YEAR(tanggal_perawatan) = $tahun LIMIT 1) AS tanggal,
                    (SELECT ket FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND  tahun = $tahun LIMIT 1) AS keterangan,
                    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND  tahun = $tahun Order BY id desc LIMIT 1 ) AS treated_by,
                    (SELECT approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND  tahun = $tahun LIMIT 1) AS approve_by
                    FROM 
                    pcaktif WHERE 1=1";
 

    }else if(strtolower($tipe)  == 'printer'){
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, 'printer' AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = printer.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun ) AS hitung,
                    (SELECT tanggal_perawatan FROM perawatan WHERE perawatan.idpc = printer.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun LIMIT 1) AS tanggal,
                    (SELECT ket FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat  AND  tahun = $tahun LIMIT 1) AS keterangan,
                    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat AND tahun = $tahun Order BY id desc LIMIT 1) AS treated_by,
                    (SELECT approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat AND tahun = $tahun LIMIT 1) AS approve_by
                    FROM 
                    printer WHERE 1=1";
    }
    else if(strtolower($tipe)  == 'scaner'){

    
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, 'scaner' AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = scaner.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun ) AS hitung,
                    (SELECT tanggal_perawatan FROM perawatan WHERE perawatan.idpc = scaner.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun LIMIT 1) AS tanggal,
                    (SELECT ket FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND  tahun = $tahun LIMIT 1) AS keterangan,
                    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND  tahun = $tahun Order BY id desc limit 1) AS treated_by,
                    (SELECT approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND  tahun = $tahun limit 1) AS approve_by
                    FROM 
                    scaner WHERE 1=1";
    }

    else if(strtolower($tipe)  == 'ups'){

    
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, tipe AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun ) AND bulan = $bulan AS hitung,
                    (SELECT tanggal_perawatan FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun LIMIT 1)  AND bulan = $bulan  AS tanggal,
                    (SELECT ket FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = $bulan  AND  tahun = $tahun LIMIT 1)   AS keterangan,
                    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = $bulan  AND  tahun = $tahun  Order BY id desc LIMIT 1)  AS treated_by,
                    (SELECT approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = $bulan  AND  tahun = $tahun LIMIT 1)  AND bulan = $bulan AS approve_by
                    FROM 
                    peripheral WHERE tipe = '$tipe' and 1=1 ";
    }
    
    
    else {
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, tipe AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun ) AS hitung,
                    (SELECT tanggal_perawatan FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun LIMIT 1) AS tanggal,
                    (SELECT ket FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND  tahun = $tahun LIMIT 1) AS keterangan,
                    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND  tahun = $tahun  Order BY id desc LIMIT 1) AS treated_by,
                    (SELECT approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND  tahun = $tahun LIMIT 1) AS approve_by
                    FROM 
                    peripheral WHERE tipe = '$tipe' and 1=1 ";
    }

}

if (!empty($_GET['bulan'])) {
    $bulan = mysql_real_escape_string($_GET['bulan']);

    if ((strtolower($tipe) == 'ups' || strtolower($tipe) == 'server') && !empty($_GET['tahun'])) {
        $tahun = mysql_real_escape_string($_GET['tahun']);
        // Jika UPS atau Server, tetap tampil tetapi harus sesuai tahun
        $query .= " AND LEFT(tgl_perawatan, 4) = '$tahun' AND (tipe = 'ups' OR tipe = 'server')";
    } else {
        // Jika bukan UPS atau Server, hanya gunakan filter bulan
        $query .= " AND bulan LIKE '%$bulan%'";
    }
}






if (!empty($_GET['namadivisi'])) {
    $namadivisi = mysql_real_escape_string($_GET['namadivisi']);
    if(strtolower($tipe)  == 'printer' || strtolower($tipe)  == 'scaner'){
        $query .= " AND status LIKE '%$namadivisi%'";
    }else{
        $query .= " AND divisi LIKE '%$namadivisi%'";
    }
    
}


if (!empty($_GET['perangkat'])) {
$query .= " ORDER BY tanggal DESC";
}

$result = mysql_query($query, $conn) or die("Query Error: " . mysql_error());
if (!$result) {
    die("Error in SQL query: " . mysql_error());
}


$output = "";
if (mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_assoc($result)) {
        if(strtolower($row['perangkat']) == 'switch/router'){
            if ($row['hitung'] >=2 ) {
                $output .= "<tr style='background-color:#d4edda;'>";
            } else if ($row['hitung'] < 2 && $row['hitung'] > 0  ){
                $output .= "<tr style='background-color:#FFFF00;'>";
            } 
            else {
                $output .= "<tr>";
            }

        }else{
            if ($row['hitung'] ==  $jumlahperawatan ) {
                $output .= "<tr style='background-color:#d4edda;'>";
            } else if ($row['hitung'] < $jumlahperawatan && $row['hitung'] > 0  ){
                $output .= "<tr style='background-color:#FFFF00;'>";
            } 
            else {
                $output .= "<tr>";
            }

        }
            $output .= "<td>
                        
                        <button type='button' class='btn btn-warning' onclick='showEdit(" . json_encode($row) . ")'>Rawat</button>
                    </td>";
        $output .= "<td>" . $row['idpc'] . "</td>";
        $output .= "<td>" . $row['user'] . "</td>";
        $output .= "<td>" . $row['lokasi'] . "</td>";
        
        
        $output .= "<td>" . $row['treated_by'] . "</td>";
        $output .= "<td>" . $row['keterangan'] . "</td>";
        $output .= "<td>" . strtoupper($row['perangkat']) . "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='7'>Tidak ada data ditemukan.</td></tr>";
}

echo $output;

mysql_close($conn);
?>

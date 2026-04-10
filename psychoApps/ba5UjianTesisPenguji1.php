<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  $myquery = "SELECT * from dt_pegawai WHERE id='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dtDosen = mysqli_fetch_assoc($d);
  
  $myquery = "SELECT * from mag_peserta_ujtes WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qformnilai = "SELECT * from mag_nilai_ujtes WHERE id_pendaftaran='$dt[id]'";
  $rfn = mysqli_query($con,  $qformnilai )or die( mysqli_error($con) );
  $dfn = mysqli_fetch_assoc( $rfn );
  
  $qry_grade = "SELECT * FROM mag_grade_ujtes WHERE id_ujtes='$dt[id_ujtes]'";
  $res_grade = mysqli_query($con, $qry_grade);
  $dt_grade = mysqli_fetch_array($res_grade);
  
  $sqlmhssw =  "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$dt[nim]'";
  $rmhssw = mysqli_query($con, $sqlmhssw);
  $dmhssw = mysqli_fetch_array($rmhssw);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarDosen.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Penilaian</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dashboardBeritaAcaraUjTes.php?page=<?php echo $page;?>">Ujian Tesis</a></li>
                  <li class="breadcrumb-item active small">Form Berita Acara</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Form Berita Acara</h4>
                    <span class="small float-right"> <?php echo $dmhssw['nama'].' ['.$dmhssw['nim'].']';?></span>
                  </div>
                  <div class="card-body">
                    <?php include("petunjukPengisianBaUjtes.php");?>
                    <div class="table-responsive">
                      <table class="table table-sm custom mb-0">
                        <thead>
                          <tr>
                            <th width="50%" class="text-center pl-1">Aspek Penilaian</th>
                            <th colspan="10" class="text-center pr-1">Pilihan Nilai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <form action="updateBa5UjianTesisPenguji1.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <?php include ("itemPenilaian5BaUjtes.php");?>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==100) { echo '<button name="nilai_penguji1_5" value="100" class="btn btn-success btn-xs btn-block" type="input">100</button>';} else { echo '<button name="nilai_penguji1_5" value="100" class="btn btn-outline-success btn-xs btn-block" type="input">100</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==99) { echo '<button name="nilai_penguji1_5" value="99" class="btn btn-success btn-xs btn-block" type="input">99</button>';} else { echo '<button name="nilai_penguji1_5" value="99" class="btn btn-outline-success btn-xs btn-block" type="input">99</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==98) { echo '<button name="nilai_penguji1_5" value="98" class="btn btn-success btn-xs btn-block" type="input">98</button>';} else { echo '<button name="nilai_penguji1_5" value="98" class="btn btn-outline-success btn-xs btn-block" type="input">98</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==97) { echo '<button name="nilai_penguji1_5" value="97" class="btn btn-success btn-xs btn-block" type="input">97</button>';} else { echo '<button name="nilai_penguji1_5" value="97" class="btn btn-outline-success btn-xs btn-block" type="input">97</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==96) { echo '<button name="nilai_penguji1_5" value="96" class="btn btn-success btn-xs btn-block" type="input">96</button>';} else { echo '<button name="nilai_penguji1_5" value="96" class="btn btn-outline-success btn-xs btn-block" type="input">96</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==95) { echo '<button name="nilai_penguji1_5" value="95" class="btn btn-success btn-xs btn-block" type="input">95</button>';} else { echo '<button name="nilai_penguji1_5" value="95" class="btn btn-outline-success btn-xs btn-block" type="input">95</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==94) { echo '<button name="nilai_penguji1_5" value="94" class="btn btn-success btn-xs btn-block" type="input">94</button>';} else { echo '<button name="nilai_penguji1_5" value="94" class="btn btn-outline-success btn-xs btn-block" type="input">94</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==93) { echo '<button name="nilai_penguji1_5" value="93" class="btn btn-success btn-xs btn-block" type="input">93</button>';} else { echo '<button name="nilai_penguji1_5" value="93" class="btn btn-outline-success btn-xs btn-block" type="input">93</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==92) { echo '<button name="nilai_penguji1_5" value="92" class="btn btn-success btn-xs btn-block" type="input">92</button>';} else { echo '<button name="nilai_penguji1_5" value="92" class="btn btn-outline-success btn-xs btn-block" type="input">92</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==91) { echo '<button name="nilai_penguji1_5" value="91" class="btn btn-success btn-xs btn-block" type="input">91</button>';} else { echo '<button name="nilai_penguji1_5" value="91" class="btn btn-outline-success btn-xs btn-block" type="input">91</button>';};?></td>
                            </tr>
                            <tr>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==90) { echo '<button name="nilai_penguji1_5" value="90" class="btn btn-success btn-xs btn-block" type="input">90</button>';} else { echo '<button name="nilai_penguji1_5" value="90" class="btn btn-outline-success btn-xs btn-block" type="input">90</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==89) { echo '<button name="nilai_penguji1_5" value="89" class="btn btn-success btn-xs btn-block" type="input">89</button>';} else { echo '<button name="nilai_penguji1_5" value="89" class="btn btn-outline-success btn-xs btn-block" type="input">89</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==88) { echo '<button name="nilai_penguji1_5" value="88" class="btn btn-success btn-xs btn-block" type="input">88</button>';} else { echo '<button name="nilai_penguji1_5" value="88" class="btn btn-outline-success btn-xs btn-block" type="input">88</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==87) { echo '<button name="nilai_penguji1_5" value="87" class="btn btn-success btn-xs btn-block" type="input">87</button>';} else { echo '<button name="nilai_penguji1_5" value="87" class="btn btn-outline-success btn-xs btn-block" type="input">87</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==86) { echo '<button name="nilai_penguji1_5" value="86" class="btn btn-success btn-xs btn-block" type="input">86</button>';} else { echo '<button name="nilai_penguji1_5" value="86" class="btn btn-outline-success btn-xs btn-block" type="input">86</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==85) { echo '<button name="nilai_penguji1_5" value="85" class="btn btn-success btn-xs btn-block" type="input">85</button>';} else { echo '<button name="nilai_penguji1_5" value="85" class="btn btn-outline-success btn-xs btn-block" type="input">85</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==84) { echo '<button name="nilai_penguji1_5" value="84" class="btn btn-success btn-xs btn-block" type="input">84</button>';} else { echo '<button name="nilai_penguji1_5" value="84" class="btn btn-outline-success btn-xs btn-block" type="input">84</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==83) { echo '<button name="nilai_penguji1_5" value="83" class="btn btn-success btn-xs btn-block" type="input">83</button>';} else { echo '<button name="nilai_penguji1_5" value="83" class="btn btn-outline-success btn-xs btn-block" type="input">83</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==82) { echo '<button name="nilai_penguji1_5" value="82" class="btn btn-success btn-xs btn-block" type="input">82</button>';} else { echo '<button name="nilai_penguji1_5" value="82" class="btn btn-outline-success btn-xs btn-block" type="input">82</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==81) { echo '<button name="nilai_penguji1_5" value="81" class="btn btn-success btn-xs btn-block" type="input">81</button>';} else { echo '<button name="nilai_penguji1_5" value="81" class="btn btn-outline-success btn-xs btn-block" type="input">81</button>';};?></td>
                            </tr>
                            <tr>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==80) { echo '<button name="nilai_penguji1_5" value="80" class="btn btn-success btn-xs btn-block" type="input">80</button>';} else { echo '<button name="nilai_penguji1_5" value="80" class="btn btn-outline-success btn-xs btn-block" type="input">80</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==79) { echo '<button name="nilai_penguji1_5" value="79" class="btn btn-success btn-xs btn-block" type="input">79</button>';} else { echo '<button name="nilai_penguji1_5" value="79" class="btn btn-outline-success btn-xs btn-block" type="input">79</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==78) { echo '<button name="nilai_penguji1_5" value="78" class="btn btn-success btn-xs btn-block" type="input">78</button>';} else { echo '<button name="nilai_penguji1_5" value="78" class="btn btn-outline-success btn-xs btn-block" type="input">78</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==77) { echo '<button name="nilai_penguji1_5" value="77" class="btn btn-success btn-xs btn-block" type="input">77</button>';} else { echo '<button name="nilai_penguji1_5" value="77" class="btn btn-outline-success btn-xs btn-block" type="input">77</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==76) { echo '<button name="nilai_penguji1_5" value="76" class="btn btn-success btn-xs btn-block" type="input">76</button>';} else { echo '<button name="nilai_penguji1_5" value="76" class="btn btn-outline-success btn-xs btn-block" type="input">76</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==75) { echo '<button name="nilai_penguji1_5" value="75" class="btn btn-success btn-xs btn-block" type="input">75</button>';} else { echo '<button name="nilai_penguji1_5" value="75" class="btn btn-outline-success btn-xs btn-block" type="input">75</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==74) { echo '<button name="nilai_penguji1_5" value="74" class="btn btn-success btn-xs btn-block" type="input">74</button>';} else { echo '<button name="nilai_penguji1_5" value="74" class="btn btn-outline-success btn-xs btn-block" type="input">74</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==73) { echo '<button name="nilai_penguji1_5" value="73" class="btn btn-success btn-xs btn-block" type="input">73</button>';} else { echo '<button name="nilai_penguji1_5" value="73" class="btn btn-outline-success btn-xs btn-block" type="input">73</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==72) { echo '<button name="nilai_penguji1_5" value="72" class="btn btn-success btn-xs btn-block" type="input">72</button>';} else { echo '<button name="nilai_penguji1_5" value="72" class="btn btn-outline-success btn-xs btn-block" type="input">72</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==71) { echo '<button name="nilai_penguji1_5" value="71" class="btn btn-success btn-xs btn-block" type="input">71</button>';} else { echo '<button name="nilai_penguji1_5" value="71" class="btn btn-outline-success btn-xs btn-block" type="input">71</button>';};?></td>
                            </tr>
                            <tr>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==70) { echo '<button name="nilai_penguji1_5" value="70" class="btn btn-success btn-xs btn-block" type="input">70</button>';} else { echo '<button name="nilai_penguji1_5" value="70" class="btn btn-outline-success btn-xs btn-block" type="input">70</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==69) { echo '<button name="nilai_penguji1_5" value="69" class="btn btn-success btn-xs btn-block" type="input">69</button>';} else { echo '<button name="nilai_penguji1_5" value="69" class="btn btn-outline-success btn-xs btn-block" type="input">69</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==68) { echo '<button name="nilai_penguji1_5" value="68" class="btn btn-success btn-xs btn-block" type="input">68</button>';} else { echo '<button name="nilai_penguji1_5" value="68" class="btn btn-outline-success btn-xs btn-block" type="input">68</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==67) { echo '<button name="nilai_penguji1_5" value="67" class="btn btn-success btn-xs btn-block" type="input">67</button>';} else { echo '<button name="nilai_penguji1_5" value="67" class="btn btn-outline-success btn-xs btn-block" type="input">67</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==66) { echo '<button name="nilai_penguji1_5" value="66" class="btn btn-success btn-xs btn-block" type="input">66</button>';} else { echo '<button name="nilai_penguji1_5" value="66" class="btn btn-outline-success btn-xs btn-block" type="input">66</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==65) { echo '<button name="nilai_penguji1_5" value="65" class="btn btn-success btn-xs btn-block" type="input">65</button>';} else { echo '<button name="nilai_penguji1_5" value="65" class="btn btn-outline-success btn-xs btn-block" type="input">65</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==64) { echo '<button name="nilai_penguji1_5" value="64" class="btn btn-success btn-xs btn-block" type="input">64</button>';} else { echo '<button name="nilai_penguji1_5" value="64" class="btn btn-outline-success btn-xs btn-block" type="input">64</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==63) { echo '<button name="nilai_penguji1_5" value="63" class="btn btn-success btn-xs btn-block" type="input">63</button>';} else { echo '<button name="nilai_penguji1_5" value="63" class="btn btn-outline-success btn-xs btn-block" type="input">63</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==62) { echo '<button name="nilai_penguji1_5" value="62" class="btn btn-success btn-xs btn-block" type="input">62</button>';} else { echo '<button name="nilai_penguji1_5" value="62" class="btn btn-outline-success btn-xs btn-block" type="input">62</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==61) { echo '<button name="nilai_penguji1_5" value="61" class="btn btn-success btn-xs btn-block" type="input">61</button>';} else { echo '<button name="nilai_penguji1_5" value="61" class="btn btn-outline-success btn-xs btn-block" type="input">61</button>';};?></td>
                            </tr>
                            <tr>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==60) { echo '<button name="nilai_penguji1_5" value="60" class="btn btn-success btn-xs btn-block" type="input">60</button>';} else { echo '<button name="nilai_penguji1_5" value="60" class="btn btn-outline-success btn-xs btn-block" type="input">60</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==59) { echo '<button name="nilai_penguji1_5" value="59" class="btn btn-success btn-xs btn-block" type="input">59</button>';} else { echo '<button name="nilai_penguji1_5" value="59" class="btn btn-outline-success btn-xs btn-block" type="input">59</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==58) { echo '<button name="nilai_penguji1_5" value="58" class="btn btn-success btn-xs btn-block" type="input">58</button>';} else { echo '<button name="nilai_penguji1_5" value="58" class="btn btn-outline-success btn-xs btn-block" type="input">58</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==57) { echo '<button name="nilai_penguji1_5" value="57" class="btn btn-success btn-xs btn-block" type="input">57</button>';} else { echo '<button name="nilai_penguji1_5" value="57" class="btn btn-outline-success btn-xs btn-block" type="input">57</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==56) { echo '<button name="nilai_penguji1_5" value="56" class="btn btn-success btn-xs btn-block" type="input">56</button>';} else { echo '<button name="nilai_penguji1_5" value="56" class="btn btn-outline-success btn-xs btn-block" type="input">56</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==55) { echo '<button name="nilai_penguji1_5" value="55" class="btn btn-success btn-xs btn-block" type="input">55</button>';} else { echo '<button name="nilai_penguji1_5" value="55" class="btn btn-outline-success btn-xs btn-block" type="input">55</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==54) { echo '<button name="nilai_penguji1_5" value="54" class="btn btn-success btn-xs btn-block" type="input">54</button>';} else { echo '<button name="nilai_penguji1_5" value="54" class="btn btn-outline-success btn-xs btn-block" type="input">54</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==53) { echo '<button name="nilai_penguji1_5" value="53" class="btn btn-success btn-xs btn-block" type="input">53</button>';} else { echo '<button name="nilai_penguji1_5" value="53" class="btn btn-outline-success btn-xs btn-block" type="input">53</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==52) { echo '<button name="nilai_penguji1_5" value="52" class="btn btn-success btn-xs btn-block" type="input">52</button>';} else { echo '<button name="nilai_penguji1_5" value="52" class="btn btn-outline-success btn-xs btn-block" type="input">52</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==51) { echo '<button name="nilai_penguji1_5" value="51" class="btn btn-success btn-xs btn-block" type="input">51</button>';} else { echo '<button name="nilai_penguji1_5" value="51" class="btn btn-outline-success btn-xs btn-block" type="input">51</button>';};?></td>
                            </tr>
                            <tr>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==50) { echo '<button name="nilai_penguji1_5" value="50" class="btn btn-success btn-xs btn-block" type="input">50</button>';} else { echo '<button name="nilai_penguji1_5" value="50" class="btn btn-outline-success btn-xs btn-block" type="input">50</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==49) { echo '<button name="nilai_penguji1_5" value="49" class="btn btn-success btn-xs btn-block" type="input">49</button>';} else { echo '<button name="nilai_penguji1_5" value="49" class="btn btn-outline-success btn-xs btn-block" type="input">49</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==48) { echo '<button name="nilai_penguji1_5" value="48" class="btn btn-success btn-xs btn-block" type="input">48</button>';} else { echo '<button name="nilai_penguji1_5" value="48" class="btn btn-outline-success btn-xs btn-block" type="input">48</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==47) { echo '<button name="nilai_penguji1_5" value="47" class="btn btn-success btn-xs btn-block" type="input">47</button>';} else { echo '<button name="nilai_penguji1_5" value="47" class="btn btn-outline-success btn-xs btn-block" type="input">47</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==46) { echo '<button name="nilai_penguji1_5" value="46" class="btn btn-success btn-xs btn-block" type="input">46</button>';} else { echo '<button name="nilai_penguji1_5" value="46" class="btn btn-outline-success btn-xs btn-block" type="input">46</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==45) { echo '<button name="nilai_penguji1_5" value="45" class="btn btn-success btn-xs btn-block" type="input">45</button>';} else { echo '<button name="nilai_penguji1_5" value="45" class="btn btn-outline-success btn-xs btn-block" type="input">45</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==44) { echo '<button name="nilai_penguji1_5" value="44" class="btn btn-success btn-xs btn-block" type="input">44</button>';} else { echo '<button name="nilai_penguji1_5" value="44" class="btn btn-outline-success btn-xs btn-block" type="input">44</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==43) { echo '<button name="nilai_penguji1_5" value="43" class="btn btn-success btn-xs btn-block" type="input">43</button>';} else { echo '<button name="nilai_penguji1_5" value="43" class="btn btn-outline-success btn-xs btn-block" type="input">43</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==42) { echo '<button name="nilai_penguji1_5" value="42" class="btn btn-success btn-xs btn-block" type="input">42</button>';} else { echo '<button name="nilai_penguji1_5" value="42" class="btn btn-outline-success btn-xs btn-block" type="input">42</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==41) { echo '<button name="nilai_penguji1_5" value="41" class="btn btn-success btn-xs btn-block" type="input">41</button>';} else { echo '<button name="nilai_penguji1_5" value="41" class="btn btn-outline-success btn-xs btn-block" type="input">41</button>';};?></td>
                            </tr>
                            <tr>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==40) { echo '<button name="nilai_penguji1_5" value="40" class="btn btn-success btn-xs btn-block" type="input">40</button>';} else { echo '<button name="nilai_penguji1_5" value="40" class="btn btn-outline-success btn-xs btn-block" type="input">40</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==39) { echo '<button name="nilai_penguji1_5" value="39" class="btn btn-success btn-xs btn-block" type="input">39</button>';} else { echo '<button name="nilai_penguji1_5" value="39" class="btn btn-outline-success btn-xs btn-block" type="input">39</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==38) { echo '<button name="nilai_penguji1_5" value="38" class="btn btn-success btn-xs btn-block" type="input">38</button>';} else { echo '<button name="nilai_penguji1_5" value="38" class="btn btn-outline-success btn-xs btn-block" type="input">38</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==37) { echo '<button name="nilai_penguji1_5" value="37" class="btn btn-success btn-xs btn-block" type="input">37</button>';} else { echo '<button name="nilai_penguji1_5" value="37" class="btn btn-outline-success btn-xs btn-block" type="input">37</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==36) { echo '<button name="nilai_penguji1_5" value="36" class="btn btn-success btn-xs btn-block" type="input">36</button>';} else { echo '<button name="nilai_penguji1_5" value="36" class="btn btn-outline-success btn-xs btn-block" type="input">36</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==35) { echo '<button name="nilai_penguji1_5" value="35" class="btn btn-success btn-xs btn-block" type="input">35</button>';} else { echo '<button name="nilai_penguji1_5" value="35" class="btn btn-outline-success btn-xs btn-block" type="input">35</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==34) { echo '<button name="nilai_penguji1_5" value="34" class="btn btn-success btn-xs btn-block" type="input">34</button>';} else { echo '<button name="nilai_penguji1_5" value="34" class="btn btn-outline-success btn-xs btn-block" type="input">34</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==33) { echo '<button name="nilai_penguji1_5" value="33" class="btn btn-success btn-xs btn-block" type="input">33</button>';} else { echo '<button name="nilai_penguji1_5" value="33" class="btn btn-outline-success btn-xs btn-block" type="input">33</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==32) { echo '<button name="nilai_penguji1_5" value="32" class="btn btn-success btn-xs btn-block" type="input">32</button>';} else { echo '<button name="nilai_penguji1_5" value="32" class="btn btn-outline-success btn-xs btn-block" type="input">32</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==31) { echo '<button name="nilai_penguji1_5" value="31" class="btn btn-success btn-xs btn-block" type="input">31</button>';} else { echo '<button name="nilai_penguji1_5" value="31" class="btn btn-outline-success btn-xs btn-block" type="input">31</button>';};?></td>
                            </tr>
                            <tr>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==30) { echo '<button name="nilai_penguji1_5" value="30" class="btn btn-success btn-xs btn-block" type="input">30</button>';} else { echo '<button name="nilai_penguji1_5" value="30" class="btn btn-outline-success btn-xs btn-block" type="input">30</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==29) { echo '<button name="nilai_penguji1_5" value="29" class="btn btn-success btn-xs btn-block" type="input">29</button>';} else { echo '<button name="nilai_penguji1_5" value="29" class="btn btn-outline-success btn-xs btn-block" type="input">29</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==28) { echo '<button name="nilai_penguji1_5" value="28" class="btn btn-success btn-xs btn-block" type="input">28</button>';} else { echo '<button name="nilai_penguji1_5" value="28" class="btn btn-outline-success btn-xs btn-block" type="input">28</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==27) { echo '<button name="nilai_penguji1_5" value="27" class="btn btn-success btn-xs btn-block" type="input">27</button>';} else { echo '<button name="nilai_penguji1_5" value="27" class="btn btn-outline-success btn-xs btn-block" type="input">27</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==26) { echo '<button name="nilai_penguji1_5" value="26" class="btn btn-success btn-xs btn-block" type="input">26</button>';} else { echo '<button name="nilai_penguji1_5" value="26" class="btn btn-outline-success btn-xs btn-block" type="input">26</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==25) { echo '<button name="nilai_penguji1_5" value="25" class="btn btn-success btn-xs btn-block" type="input">25</button>';} else { echo '<button name="nilai_penguji1_5" value="25" class="btn btn-outline-success btn-xs btn-block" type="input">25</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==24) { echo '<button name="nilai_penguji1_5" value="24" class="btn btn-success btn-xs btn-block" type="input">24</button>';} else { echo '<button name="nilai_penguji1_5" value="24" class="btn btn-outline-success btn-xs btn-block" type="input">24</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==23) { echo '<button name="nilai_penguji1_5" value="23" class="btn btn-success btn-xs btn-block" type="input">23</button>';} else { echo '<button name="nilai_penguji1_5" value="23" class="btn btn-outline-success btn-xs btn-block" type="input">23</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==22) { echo '<button name="nilai_penguji1_5" value="22" class="btn btn-success btn-xs btn-block" type="input">22</button>';} else { echo '<button name="nilai_penguji1_5" value="22" class="btn btn-outline-success btn-xs btn-block" type="input">22</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==21) { echo '<button name="nilai_penguji1_5" value="21" class="btn btn-success btn-xs btn-block" type="input">21</button>';} else { echo '<button name="nilai_penguji1_5" value="21" class="btn btn-outline-success btn-xs btn-block" type="input">21</button>';};?></td>
                            </tr>
                            <tr>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==20) { echo '<button name="nilai_penguji1_5" value="20" class="btn btn-success btn-xs btn-block" type="input">20</button>';} else { echo '<button name="nilai_penguji1_5" value="20" class="btn btn-outline-success btn-xs btn-block" type="input">20</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==19) { echo '<button name="nilai_penguji1_5" value="19" class="btn btn-success btn-xs btn-block" type="input">19</button>';} else { echo '<button name="nilai_penguji1_5" value="19" class="btn btn-outline-success btn-xs btn-block" type="input">19</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==18) { echo '<button name="nilai_penguji1_5" value="18" class="btn btn-success btn-xs btn-block" type="input">18</button>';} else { echo '<button name="nilai_penguji1_5" value="18" class="btn btn-outline-success btn-xs btn-block" type="input">18</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==17) { echo '<button name="nilai_penguji1_5" value="17" class="btn btn-success btn-xs btn-block" type="input">17</button>';} else { echo '<button name="nilai_penguji1_5" value="17" class="btn btn-outline-success btn-xs btn-block" type="input">17</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==16) { echo '<button name="nilai_penguji1_5" value="16" class="btn btn-success btn-xs btn-block" type="input">16</button>';} else { echo '<button name="nilai_penguji1_5" value="16" class="btn btn-outline-success btn-xs btn-block" type="input">16</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==15) { echo '<button name="nilai_penguji1_5" value="15" class="btn btn-success btn-xs btn-block" type="input">15</button>';} else { echo '<button name="nilai_penguji1_5" value="15" class="btn btn-outline-success btn-xs btn-block" type="input">15</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==14) { echo '<button name="nilai_penguji1_5" value="14" class="btn btn-success btn-xs btn-block" type="input">14</button>';} else { echo '<button name="nilai_penguji1_5" value="14" class="btn btn-outline-success btn-xs btn-block" type="input">14</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==13) { echo '<button name="nilai_penguji1_5" value="13" class="btn btn-success btn-xs btn-block" type="input">13</button>';} else { echo '<button name="nilai_penguji1_5" value="13" class="btn btn-outline-success btn-xs btn-block" type="input">13</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==12) { echo '<button name="nilai_penguji1_5" value="12" class="btn btn-success btn-xs btn-block" type="input">12</button>';} else { echo '<button name="nilai_penguji1_5" value="12" class="btn btn-outline-success btn-xs btn-block" type="input">12</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==11) { echo '<button name="nilai_penguji1_5" value="11" class="btn btn-success btn-xs btn-block" type="input">11</button>';} else { echo '<button name="nilai_penguji1_5" value="11" class="btn btn-outline-success btn-xs btn-block" type="input">11</button>';};?></td>
                            </tr>
                            <tr>
                              <td width="5%" class="pr-1"><?php if($dfn['nilai_penguji1_5']==10) { echo '<button name="nilai_penguji1_5" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="nilai_penguji1_5" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==9) { echo '<button name="nilai_penguji1_5" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="nilai_penguji1_5" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==8) { echo '<button name="nilai_penguji1_5" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="nilai_penguji1_5" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==7) { echo '<button name="nilai_penguji1_5" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="nilai_penguji1_5" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==6) { echo '<button name="nilai_penguji1_5" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="nilai_penguji1_5" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==5) { echo '<button name="nilai_penguji1_5" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="nilai_penguji1_5" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==4) { echo '<button name="nilai_penguji1_5" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="nilai_penguji1_5" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==3) { echo '<button name="nilai_penguji1_5" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="nilai_penguji1_5" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==2) { echo '<button name="nilai_penguji1_5" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="nilai_penguji1_5" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['nilai_penguji1_5']==1) { echo '<button name="nilai_penguji1_5" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="nilai_penguji1_5" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td colspan="6">&nbsp;</td>
                              <td colspan="2" class="text-right pl-1"><strong>Total Nilai:</strong></td>
                              <td colspan="2" class="text-right pr-1"><strong><?php include "meanNilaiPenguji1PenilaianUjTes.php";?></strong></td>
                            </tr>
                          </form>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
            </div>
            <div class="row">
              <div class="col">
                <form action="updateCatatanBaUjtesPenguji1_5.php" method="post">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <h4 class="card-title">Catatan/Revisi Hasil</h4>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                      <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <div class="form-group">
                        <textarea id="textarea-custom-one" name="catatan_penguji1_5" class="form-control form-control-sm" style="height: 300px;"><?php echo $dfn['catatan_penguji1_5'];?></textarea>
                      </div>
                       <a href="ba4UjianTesisPenguji1.php?page=<?php echo $page;?>&id=<?php echo $id;?>" class="btn btn-outline-danger btn-sm"><i class="fas fa-arrow-left"></i> Sebelumnya</a>
                      <button  role="button" type="submit" class="btn btn-outline-danger btn-sm float-right">Simpan dan Lanjut <i class="fas fa-arrow-right"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>
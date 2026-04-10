<?php include( "contentsConAdm.php" );
   $id=uniqid();
   $page= mysqli_real_escape_string($con, $_POST['page']);
   $no_agenda_surat=mysqli_real_escape_string($con, $_POST['no_agenda_surat']);
   $perihal=mysqli_real_escape_string($con, $_POST['perihal']);
   $dasar=mysqli_real_escape_string($con, $_POST['dasar']);       
   $awal_berlaku=mysqli_real_escape_string($con, $_POST['awal_berlaku']);   
   $akhir_berlaku=mysqli_real_escape_string($con, $_POST['akhir_berlaku']);
   $tgl_ditetapkan=mysqli_real_escape_string($con, $_POST['tgl_ditetapkan']);
   $split = explode('-', $tgl_ditetapkan);
   $bulan= mysqli_real_escape_string($con, $split['1']);
   $tahun= mysqli_real_escape_string($con, $split['0']);
   $jenis_st='1';
   $executor= mysqli_real_escape_string($con, $_POST['executor']);
   
   $sql3 =  "SELECT * FROM dt_pegawai WHERE jabatan_instansi='1'";
   $result3 = mysqli_query($con, $sql3);
   $data3 = mysqli_fetch_array($result3);                         
   $dekan=mysqli_real_escape_string($con, $data3['id']);
   
   $nama1=mysqli_real_escape_string($con, $_POST['nama1']);
   $nama2=mysqli_real_escape_string($con, $_POST['nama2']);
   $nama3=mysqli_real_escape_string($con, $_POST['nama3']);
   $nama4=mysqli_real_escape_string($con, $_POST['nama4']);
   $nama5=mysqli_real_escape_string($con, $_POST['nama5']);
   $nama6=mysqli_real_escape_string($con, $_POST['nama6']);
   $nama7=mysqli_real_escape_string($con, $_POST['nama7']);
   $nama8=mysqli_real_escape_string($con, $_POST['nama8']);
   $nama9=mysqli_real_escape_string($con, $_POST['nama9']);
   $nama10=mysqli_real_escape_string($con, $_POST['nama10']);
   $nama11=mysqli_real_escape_string($con, $_POST['nama11']);
   $nama12=mysqli_real_escape_string($con, $_POST['nama12']);
   $nama13=mysqli_real_escape_string($con, $_POST['nama13']);
   $nama14=mysqli_real_escape_string($con, $_POST['nama14']);
   $nama15=mysqli_real_escape_string($con, $_POST['nama15']);
   $nama16=mysqli_real_escape_string($con, $_POST['nama16']);
   $nama17=mysqli_real_escape_string($con, $_POST['nama17']);
   $nama18=mysqli_real_escape_string($con, $_POST['nama18']);
   $nama19=mysqli_real_escape_string($con, $_POST['nama19']);
   $nama20=mysqli_real_escape_string($con, $_POST['nama20']);
   $nama21=mysqli_real_escape_string($con, $_POST['nama21']);
   $nama22=mysqli_real_escape_string($con, $_POST['nama22']);
   $nama23=mysqli_real_escape_string($con, $_POST['nama23']);
   $nama24=mysqli_real_escape_string($con, $_POST['nama24']);
   $nama25=mysqli_real_escape_string($con, $_POST['nama25']);
   $nama26=mysqli_real_escape_string($con, $_POST['nama26']);
   $nama27=mysqli_real_escape_string($con, $_POST['nama27']);
   $nama28=mysqli_real_escape_string($con, $_POST['nama28']);
   $nama29=mysqli_real_escape_string($con, $_POST['nama29']);
   $nama30=mysqli_real_escape_string($con, $_POST['nama30']);
   $nama31=mysqli_real_escape_string($con, $_POST['nama31']);
   $nama32=mysqli_real_escape_string($con, $_POST['nama32']);
   $nama33=mysqli_real_escape_string($con, $_POST['nama33']);
   $nama34=mysqli_real_escape_string($con, $_POST['nama34']);
   $nama35=mysqli_real_escape_string($con, $_POST['nama35']);
   $nama36=mysqli_real_escape_string($con, $_POST['nama36']);
   $nama37=mysqli_real_escape_string($con, $_POST['nama37']);
   $nama38=mysqli_real_escape_string($con, $_POST['nama38']);
   $nama39=mysqli_real_escape_string($con, $_POST['nama39']);
   $nama40=mysqli_real_escape_string($con, $_POST['nama40']);
   $nama41=mysqli_real_escape_string($con, $_POST['nama41']);
   $nama42=mysqli_real_escape_string($con, $_POST['nama42']);
   $nama43=mysqli_real_escape_string($con, $_POST['nama43']);
   $nama44=mysqli_real_escape_string($con, $_POST['nama44']);
   $nama45=mysqli_real_escape_string($con, $_POST['nama45']);
   $nama46=mysqli_real_escape_string($con, $_POST['nama46']);
   $nama47=mysqli_real_escape_string($con, $_POST['nama47']);
   $nama48=mysqli_real_escape_string($con, $_POST['nama48']);
   $nama49=mysqli_real_escape_string($con, $_POST['nama49']);
   $nama50=mysqli_real_escape_string($con, $_POST['nama50']);
   $nama51=mysqli_real_escape_string($con, $_POST['nama51']);
   $nama52=mysqli_real_escape_string($con, $_POST['nama52']);
   $nama53=mysqli_real_escape_string($con, $_POST['nama53']);
   $nama54=mysqli_real_escape_string($con, $_POST['nama54']);
   $nama55=mysqli_real_escape_string($con, $_POST['nama55']);
   $nama56=mysqli_real_escape_string($con, $_POST['nama56']);
   $nama57=mysqli_real_escape_string($con, $_POST['nama57']);
   $nama58=mysqli_real_escape_string($con, $_POST['nama58']);
   $nama59=mysqli_real_escape_string($con, $_POST['nama59']);
   $nama60=mysqli_real_escape_string($con, $_POST['nama60']);
   $nama61=mysqli_real_escape_string($con, $_POST['nama61']);
   $nama62=mysqli_real_escape_string($con, $_POST['nama62']);
   $nama63=mysqli_real_escape_string($con, $_POST['nama63']);
   $nama64=mysqli_real_escape_string($con, $_POST['nama64']);
   $nama65=mysqli_real_escape_string($con, $_POST['nama65']);
   
   $jabatan1=mysqli_real_escape_string($con, $_POST['jabatan1']);
   $jabatan2=mysqli_real_escape_string($con, $_POST['jabatan2']);
   $jabatan3=mysqli_real_escape_string($con, $_POST['jabatan3']);
   $jabatan4=mysqli_real_escape_string($con, $_POST['jabatan4']);
   $jabatan5=mysqli_real_escape_string($con, $_POST['jabatan5']);
   $jabatan6=mysqli_real_escape_string($con, $_POST['jabatan6']);
   $jabatan7=mysqli_real_escape_string($con, $_POST['jabatan7']);
   $jabatan8=mysqli_real_escape_string($con, $_POST['jabatan8']);
   $jabatan9=mysqli_real_escape_string($con, $_POST['jabatan9']);
   $jabatan10=mysqli_real_escape_string($con, $_POST['jabatan10']);
   $jabatan11=mysqli_real_escape_string($con, $_POST['jabatan11']);
   $jabatan12=mysqli_real_escape_string($con, $_POST['jabatan12']);
   $jabatan13=mysqli_real_escape_string($con, $_POST['jabatan13']);
   $jabatan14=mysqli_real_escape_string($con, $_POST['jabatan14']);
   $jabatan15=mysqli_real_escape_string($con, $_POST['jabatan15']);
   $jabatan16=mysqli_real_escape_string($con, $_POST['jabatan16']);
   $jabatan17=mysqli_real_escape_string($con, $_POST['jabatan17']);
   $jabatan18=mysqli_real_escape_string($con, $_POST['jabatan18']);
   $jabatan19=mysqli_real_escape_string($con, $_POST['jabatan19']);
   $jabatan20=mysqli_real_escape_string($con, $_POST['jabatan20']);
   $jabatan21=mysqli_real_escape_string($con, $_POST['jabatan21']);
   $jabatan22=mysqli_real_escape_string($con, $_POST['jabatan22']);
   $jabatan23=mysqli_real_escape_string($con, $_POST['jabatan23']);
   $jabatan24=mysqli_real_escape_string($con, $_POST['jabatan24']);
   $jabatan25=mysqli_real_escape_string($con, $_POST['jabatan25']);
   $jabatan26=mysqli_real_escape_string($con, $_POST['jabatan26']);
   $jabatan27=mysqli_real_escape_string($con, $_POST['jabatan27']);
   $jabatan28=mysqli_real_escape_string($con, $_POST['jabatan28']);
   $jabatan29=mysqli_real_escape_string($con, $_POST['jabatan29']);
   $jabatan30=mysqli_real_escape_string($con, $_POST['jabatan30']);
   $jabatan31=mysqli_real_escape_string($con, $_POST['jabatan31']);
   $jabatan32=mysqli_real_escape_string($con, $_POST['jabatan32']);
   $jabatan33=mysqli_real_escape_string($con, $_POST['jabatan33']);
   $jabatan34=mysqli_real_escape_string($con, $_POST['jabatan34']);
   $jabatan35=mysqli_real_escape_string($con, $_POST['jabatan35']);
   $jabatan36=mysqli_real_escape_string($con, $_POST['jabatan36']);
   $jabatan37=mysqli_real_escape_string($con, $_POST['jabatan37']);
   $jabatan38=mysqli_real_escape_string($con, $_POST['jabatan38']);
   $jabatan39=mysqli_real_escape_string($con, $_POST['jabatan39']);
   $jabatan40=mysqli_real_escape_string($con, $_POST['jabatan40']);
   $jabatan41=mysqli_real_escape_string($con, $_POST['jabatan41']);
   $jabatan42=mysqli_real_escape_string($con, $_POST['jabatan42']);
   $jabatan43=mysqli_real_escape_string($con, $_POST['jabatan43']);
   $jabatan44=mysqli_real_escape_string($con, $_POST['jabatan44']);
   $jabatan45=mysqli_real_escape_string($con, $_POST['jabatan45']);
   $jabatan46=mysqli_real_escape_string($con, $_POST['jabatan46']);
   $jabatan47=mysqli_real_escape_string($con, $_POST['jabatan47']);
   $jabatan48=mysqli_real_escape_string($con, $_POST['jabatan48']);
   $jabatan49=mysqli_real_escape_string($con, $_POST['jabatan49']);
   $jabatan50=mysqli_real_escape_string($con, $_POST['jabatan50']);
   $jabatan51=mysqli_real_escape_string($con, $_POST['jabatan51']);
   $jabatan52=mysqli_real_escape_string($con, $_POST['jabatan52']);
   $jabatan53=mysqli_real_escape_string($con, $_POST['jabatan53']);
   $jabatan54=mysqli_real_escape_string($con, $_POST['jabatan54']);
   $jabatan55=mysqli_real_escape_string($con, $_POST['jabatan55']);
   $jabatan56=mysqli_real_escape_string($con, $_POST['jabatan56']);
   $jabatan57=mysqli_real_escape_string($con, $_POST['jabatan57']);
   $jabatan58=mysqli_real_escape_string($con, $_POST['jabatan58']);
   $jabatan59=mysqli_real_escape_string($con, $_POST['jabatan59']);
   $jabatan60=mysqli_real_escape_string($con, $_POST['jabatan60']);
   $jabatan61=mysqli_real_escape_string($con, $_POST['jabatan61']);
   $jabatan62=mysqli_real_escape_string($con, $_POST['jabatan62']);
   $jabatan63=mysqli_real_escape_string($con, $_POST['jabatan63']);
   $jabatan64=mysqli_real_escape_string($con, $_POST['jabatan64']);
   $jabatan65=mysqli_real_escape_string($con, $_POST['jabatan65']);
   
   $urutan1="1";
   $urutan2="2";
   $urutan3="3";
   $urutan4="4";
   $urutan5="5";
   $urutan6="6";
   $urutan7="7";
   $urutan8="8";
   $urutan9="9";
   $urutan10="10";
   $urutan11="11";
   $urutan12="12";
   $urutan13="13";
   $urutan14="14";
   $urutan15="15";
   $urutan16="16";
   $urutan17="17";
   $urutan18="18";
   $urutan19="19";
   $urutan20="20";
   $urutan21="21";
   $urutan22="22";
   $urutan23="23";
   $urutan24="24";
   $urutan25="25";
   $urutan26="26";
   $urutan27="27";
   $urutan28="28";
   $urutan29="29";
   $urutan30="30";
   $urutan31="31";
   $urutan32="32";
   $urutan33="33";
   $urutan34="34";
   $urutan35="35";
   $urutan36="36";
   $urutan37="37";
   $urutan38="38";
   $urutan39="39";
   $urutan40="40";
   $urutan41="41";
   $urutan42="42";
   $urutan43="43";
   $urutan44="44";
   $urutan45="45";
   $urutan46="46";
   $urutan47="47";
   $urutan48="48";
   $urutan49="49";
   $urutan50="50";
   $urutan51="51";
   $urutan52="52";
   $urutan53="53";
   $urutan54="54";
   $urutan55="55";
   $urutan56="56";
   $urutan57="57";
   $urutan58="58";
   $urutan59="59";
   $urutan60="60";
   $urutan61="61";
   $urutan62="62";
   $urutan63="63";
   $urutan64="64";
   $urutan65="65";
   
   mysqli_query($con, "INSERT INTO st(id,no_agenda_surat,perihal,dasar,awal_berlaku,akhir_berlaku,tgl_ditetapkan,jenis_st,dekan,bulan,tahun,executor)" .
   "VALUES('$id','$no_agenda_surat','$perihal','$dasar','$awal_berlaku','$akhir_berlaku','$tgl_ditetapkan','$jenis_st','$dekan','$bulan','$tahun','$executor')") or die(mysqli_error($con));
   
   $qry=mysqli_query($con, "SELECT id FROM st WHERE id='$id'");
   $ambil=mysqli_fetch_assoc($qry);
   $idSt=$ambil['id'];
      
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan1','$nama1','$jabatan1')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan2','$nama2','$jabatan2')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan3','$nama3','$jabatan3')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan4','$nama4','$jabatan4')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan5','$nama5','$jabatan5')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan6','$nama6','$jabatan6')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan7','$nama7','$jabatan7')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan8','$nama8','$jabatan8')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan9','$nama9','$jabatan9')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan10','$nama10','$jabatan10')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan11','$nama11','$jabatan11')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan12','$nama12','$jabatan12')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan13','$nama13','$jabatan13')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan14','$nama14','$jabatan14')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan15','$nama15','$jabatan15')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan16','$nama16','$jabatan16')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan17','$nama17','$jabatan17')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan18','$nama18','$jabatan18')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan19','$nama19','$jabatan19')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan20','$nama20','$jabatan20')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan21','$nama21','$jabatan21')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan22','$nama22','$jabatan22')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan23','$nama23','$jabatan23')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan24','$nama24','$jabatan24')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan25','$nama25','$jabatan25')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan26','$nama26','$jabatan26')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan27','$nama27','$jabatan27')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan28','$nama28','$jabatan28')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan29','$nama29','$jabatan29')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan30','$nama30','$jabatan3O')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan31','$nama31','$jabatan31')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan32','$nama32','$jabatan32')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan33','$nama33','$jabatan33')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan34','$nama34','$jabatan34')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan35','$nama35','$jabatan35')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan36','$nama36','$jabatan36')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan37','$nama37','$jabatan37')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan38','$nama38','$jabatan38')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan39','$nama39','$jabatan39')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan40','$nama40','$jabatan40')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan41','$nama41','$jabatan41')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan42','$nama42','$jabatan42')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan43','$nama43','$jabatan43')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan44','$nama44','$jabatan44')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan45','$nama45','$jabatan45')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan46','$nama46','$jabatan46')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan47','$nama47','$jabatan47')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan48','$nama48','$jabatan48')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan49','$nama49','$jabatan49')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan50','$nama50','$jabatan50')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan51','$nama51','$jabatan51')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan52','$nama52','$jabatan52')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan53','$nama53','$jabatan53')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan54','$nama54','$jabatan54')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan55','$nama55','$jabatan55')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan56','$nama56','$jabatan56')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan57','$nama57','$jabatan57')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan58','$nama58','$jabatan58')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan59','$nama59','$jabatan59')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan60','$nama60','$jabatan60')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan61','$nama61','$jabatan61')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan62','$nama62','$jabatan62')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan63','$nama63','$jabatan63')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan64','$nama64','$jabatan64')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$idSt','$urutan65','$nama65','$jabatan65')")  or die(mysqli_error($con));

   header("location:rekapSuratTugasAdm.php?page=$page&message=notifInput");
   ?>
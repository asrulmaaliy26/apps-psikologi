<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  ?>
<div class="row">
  <div class="col-md-8 connectedSortable">
    <div class="callout callout-info pb-3">
      <h6>Petunjuk</h6>
      <ul style="padding-left:14px;" class="small">
        <li>Silahkan tekan tombol nilai pada tabel Pilihan Nilai dengan melihat Keterangan Konversi Nilai di sebelah kanan atas.</li>
        <li>Kolom catatan/revisi berada di bawah tabel Pilihan Nilai.</li>
      </ul>
    </div>
  </div>
  <div class="col-md-4 connectedSortable">
    <div class="callout callout-info pb-1">
      <h6>Keterangan Konversi Nilai</h6>
      <ul class="list-inline mb-2">
        <li class="list-inline-item small pr-4">85 sd. 100 : A <br/>
          75 sd. 84 : B+ <br/>
          70 sd. 74 : B
        </li>
        <li class="list-inline-item small">65 sd. 69 : C+ <br/>
          60 sd. 64 : C <br/>
          < 60 : D
        </li>
      </ul>
    </div>
  </div>
</div>
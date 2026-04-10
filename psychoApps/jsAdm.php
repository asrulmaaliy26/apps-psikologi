<?php include( "contentsConAdm.php" );?> 
<script src="../vendor/plugins/jquery/jquery.min.js"></script>
<script src="../vendor/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../vendor/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/plugins/chart.js/Chart.min.js"></script>
<script src="../vendor/plugins/sparklines/sparkline.js"></script>
<script src="../vendor/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../vendor/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="../vendor/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="../vendor/plugins/moment/moment.min.js"></script>
<script src="../vendor/plugins/daterangepicker/daterangepicker.js"></script>
<script src="../vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../vendor/plugins/summernote/summernote-bs4.min.js"></script>
<script src="../vendor/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../vendor/dist/js/adminlte.js"></script>
<script src="../vendor/dist/js/pages/dashboard.js"></script>
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
  })
  
  $('#alert').removeClass('d-none');
  
  setTimeout(() => {
    $('.alert').alert('close');
  }, 3000);

/* Fungsi tanggal kepegawaian */
$(function () {
  $('#tgl_dmy_one').datetimepicker({
  format: 'DD-MM-YYYY',
  icons: {
  previous: 'fas fa-chevron-left',
  next: 'fas fa-chevron-right'
  }
  });
  });

$(function () {
  $('#tgl_dmy_two').datetimepicker({
  format: 'DD-MM-YYYY',
  icons: {
  previous: 'fas fa-chevron-left',
  next: 'fas fa-chevron-right'
  }
  });
  });

$(function () {
  $('#tgl_ymd_one').datetimepicker({
  format: 'YYYY-MM-DD',
  icons: {
  previous: 'fas fa-chevron-left',
  next: 'fas fa-chevron-right'
  }
  });
  });

$(function () {
  $('#tgl_ymd_two').datetimepicker({
  format: 'YYYY-MM-DD',
  icons: {
  previous: 'fas fa-chevron-left',
  next: 'fas fa-chevron-right'
  }
  });
  });

$(function () {
  $('#jam_one').datetimepicker({
  format: 'HH:mm',
  icons: {
  time: "fas fa-clock",
  up: "fas fa-chevron-up",
  down: "fas fa-chevron-down"
  }
  });
  });

$(function () {
  $('#jam_two').datetimepicker({
  format: 'HH:mm',
  icons: {
  time: "fas fa-clock",
  up: "fas fa-chevron-up",
  down: "fas fa-chevron-down"
  }
  });
  });

$(function () {
  $('#jam_three').datetimepicker({
  format: 'HH:mm',
  icons: {
  time: "fas fa-clock",
  up: "fas fa-chevron-up",
  down: "fas fa-chevron-down"
  }
  });
  });

$(function () {
  $('#jam_four').datetimepicker({
  format: 'HH:mm',
  icons: {
  time: "fas fa-clock",
  up: "fas fa-chevron-up",
  down: "fas fa-chevron-down"
  }
  });
  });

$(function () {
  $('#tgl_ymd_jam_one').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }
  });
  });


$(function () {
  $('#tgl_ymd_jam_two').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }
  });
  });

$(function () {
  $('#tgl_cpns').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tmt').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_3a').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_3b').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_3c').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_3d').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_2a').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_2b').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_2c').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_2d').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_4a').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_4b').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_4c').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_4d').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#tgl_4e').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#th_sma').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#th_s1').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#th_s2').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#th_s3').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

$(function () {
  $('#th_gb').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
    time: "fas fa-clock",
    date: "fas fa-calendar-alt",
    up: "fas fa-chevron-up",
    down: "fas fa-chevron-down",
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right'
  }});
});

/* Fungsi textarea */
  $(function () {
        $('#textarea-custom-one').summernote()
      })
  $('#textarea-custom-one').on('summernote.paste', function(e, ne) {
        let inputText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData('Text');
        ne.preventDefault();
        let modifiedText = inputText .replace(/\r?\n/g, '<br>');
        document.execCommand('insertHtml', false, modifiedText );
    })

  $(function () {
    $('#textarea-custom-two').summernote()
      })
  $('#textarea-custom-two').on('summernote.paste', function(e, ne) {
        let inputText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData('Text');
        ne.preventDefault();
        let modifiedText = inputText .replace(/\r?\n/g, '<br>');
        document.execCommand('insertHtml', false, modifiedText );
    })

$(function () {
  $('#textarea-custom-three').summernote()
      })
  $('#textarea-custom-three').on('summernote.paste', function(e, ne) {
        let inputText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData('Text');
        ne.preventDefault();
        let modifiedText = inputText .replace(/\r?\n/g, '<br>');
        document.execCommand('insertHtml', false, modifiedText );
    })

  $(function () {
        $('#textarea-custom-four').summernote()
      })
  $('#textarea-custom-four').on('summernote.paste', function(e, ne) {
        let inputText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData('Text');
        ne.preventDefault();
        let modifiedText = inputText .replace(/\r?\n/g, '<br>');
        document.execCommand('insertHtml', false, modifiedText );
    })

  $(function () {
        $('#textarea-custom-five').summernote()
      })
  $('#textarea-custom-five').on('summernote.paste', function(e, ne) {
        let inputText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData('Text');
        ne.preventDefault();
        let modifiedText = inputText .replace(/\r?\n/g, '<br>');
        document.execCommand('insertHtml', false, modifiedText );
    })

  function IsiSama(f) {
  if(f.bilasama.checked == true) {
   f.tempat_ow.value = f.lembaga_tujuan_surat.value;
  }
  if(f.bilasama.checked == false) {
   f.tempat_ow.value = ""; 
  }
  }
  
  function IsiSamaNamaObyek(f) {
  if(f.bilasama.checked == true) {
   f.nama_obyek.value = f.lembaga_tujuan_surat.value;
  }
  if(f.bilasama.checked == false) {
   f.nama_obyek.value = ""; 
  }
  }

  $("#checkAll").click(function () {
  $('input:checkbox').not(this).prop('checked', this.checked);
  });

  $('#submit1,#submit2').prop("disabled", true);
  $('input:checkbox').click(function() {
  if ($(this).is(':checked')) {
  $('#submit1,#submit2').prop("disabled", false);
  } else {
  if ($('.chk').filter(':checked').length < 1){
  $('#submit1,#submit2').attr('disabled',true);}
  }
  });

  $('.table-responsive').on('show.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "inherit" );
      });
      
      $('.table-responsive').on('hide.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "auto" );
      })
</script>
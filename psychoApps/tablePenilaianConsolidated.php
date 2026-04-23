<?php
// tablePenilaianConsolidated.php - Integrated with AdminLTE UI
?>
<div id="formPenilaian" class="container-fluid">
    <form action="updateAllBaUjianTesisPenguji<?php echo $penguji_idx; ?>.php" method="post">
        <input type="hidden" name="id" value="<?php echo $dfn['id'];?>">
        <input type="hidden" name="id_pendaftaran" value="<?php echo $id;?>">
        <input type="hidden" name="page" value="<?php echo $page;?>">

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-success shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Input Penilaian Ujian Tesis</h3>
                        <div class="card-tools">
                             <span class="badge badge-info">Live Mean: <span id="liveMeanTop">0.00</span></span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th width="65%">Aspek Penilaian (Klik untuk Detail)</th>
                                        <th width="30%" class="text-center">Nilai (0-100)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $titles = [
                                        1 => "Judul Penelitian",
                                        2 => "Latar Penelitian",
                                        3 => "Theoritical Review",
                                        4 => "Method",
                                        5 => "Hasil",
                                        6 => "Pembahasan",
                                        7 => "Kesimpulan"
                                    ];
                                    ?>
                                    <?php for($i=1; $i<=7; $i++): ?>
                                    <tr style="cursor: pointer;" onclick="toggleRow(<?php echo $i; ?>)">
                                        <td class="text-center align-middle font-weight-bold"><?php echo $i; ?></td>
                                        <td class="align-middle">
                                            <div class="font-weight-bold text-primary">
                                                <?php echo $titles[$i]; ?>
                                                <i class="fas fa-chevron-down ml-2 text-muted small" id="icon-<?php echo $i; ?>"></i>
                                            </div>
                                            <div class="small text-muted font-italic">
                                                <i class="fas fa-info-circle mr-1"></i> Klik untuk melihat detail dan menulis catatan
                                            </div>
                                        </td>
                                        <td class="text-center align-middle" onclick="event.stopPropagation()">
                                            <input type="number" 
                                                   name="nilai_penguji<?php echo $penguji_idx; ?>_<?php echo $i; ?>" 
                                                   class="form-control form-control-lg text-center font-weight-bold score-input-integrated" 
                                                   value="<?php echo (float)$dfn["nilai_penguji{$penguji_idx}_{$i}"]; ?>" 
                                                   min="0" max="100" step="0.01" required
                                                   style="border: 2px solid #28a745;"
                                                   oninput="calculateMean()">
                                        </td>
                                    </tr>
                                    <tr id="details-<?php echo $i; ?>" style="display: none; background-color: #f9f9f9;">
                                        <td colspan="3">
                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <?php include ("itemPenilaian{$i}BaUjtes.php"); ?>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-muted small"><i class="fas fa-comment-dots mr-1"></i> Catatan / Revisi:</label>
                                                            <textarea name="catatan_penguji<?php echo $penguji_idx; ?>_<?php echo $i; ?>" 
                                                                      class="form-control summernote-catatan" 
                                                                      rows="4" placeholder="Tulis catatan atau revisi untuk aspek ini..."><?php echo $dfn["catatan_penguji{$penguji_idx}_{$i}"]; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="h4 mb-0">
                                    <span class="text-muted small text-uppercase font-weight-bold">Rata-rata:</span>
                                    <span id="liveMeanFinal" class="text-success font-weight-bold ml-2">0.00</span>
                                </div>
                                <div class="small text-muted">Status Database: <?php include "meanNilaiPenguji{$penguji_idx}PenilaianUjTes.php";?></div>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="dashboardBeritaAcaraUjTes.php?page=<?php echo $page;?>" class="btn btn-default mr-2">
                                    <i class="fas fa-times mr-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success px-5 font-weight-bold">
                                    <i class="fas fa-save mr-2"></i> SIMPAN PENILAIAN
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function toggleRow(id) {
    const details = document.getElementById('details-' + id);
    const icon = document.getElementById('icon-' + id);
    
    if (details.style.display === 'none') {
        details.style.display = 'table-row';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
        // Initialize summernote only when shown to improve performance
        initSummernote(id);
    } else {
        details.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}

function initSummernote(id) {
    const $textarea = $('#details-' + id).find('.summernote-catatan');
    if (!$textarea.hasClass('summernote-initialized')) {
        $textarea.summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ]
        });
        $textarea.addClass('summernote-initialized');
    }
}

function calculateMean() {
    const inputs = document.querySelectorAll('.score-input-integrated');
    let total = 0;
    let count = 0;
    
    inputs.forEach(input => {
        const val = parseFloat(input.value);
        if (!isNaN(val) && val > 0) {
            total += val;
            count++;
        }
    });
    
    const mean = count > 0 ? (total / count).toFixed(2) : "0.00";
    document.getElementById('liveMeanTop').innerText = mean;
    document.getElementById('liveMeanFinal').innerText = mean;
    
    // UI Feedback colors
    const meanDisplay = document.getElementById('liveMeanFinal');
    if (parseFloat(mean) >= 80) meanDisplay.className = "text-success font-weight-bold ml-2";
    else if (parseFloat(mean) >= 70) meanDisplay.className = "text-primary font-weight-bold ml-2";
    else if (parseFloat(mean) > 0) meanDisplay.className = "text-warning font-weight-bold ml-2";
    else meanDisplay.className = "text-danger font-weight-bold ml-2";
}

// Initialize on load
document.addEventListener('DOMContentLoaded', calculateMean);
</script>

<?php
include 'conAdm.php';
require_once 'configSA.php';

if (empty($_SESSION['is_superadmin'])) {
    header('location:superAdminLogin.php');
    exit;
}
$roles = sa_roles();
?>
<!DOCTYPE html>
<html lang="id">
<?php include 'headAdm.php'; ?>

<body class="hold-transition layout-fixed" style="background:linear-gradient(135deg,#0f0c29,#302b63,#24243e);min-height:100vh;">
    <div class="wrapper" style="background:transparent;">

        <nav class="main-header navbar navbar-expand navbar-dark" style="background:rgba(0,0,0,.4);border-bottom:1px solid rgba(255,255,255,.1);">
            <ul class="navbar-nav">
                <li class="nav-item"><span class="nav-link" style="color:#fff;font-weight:700;">⚡ Super Admin Panel</span></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="superAdminLogout.php" class="nav-link" style="color:rgba(255,100,100,.9);"><i class="fas fa-sign-out-alt"></i> Logout SA</a></li>
            </ul>
        </nav>

        <div style="padding:1.5rem;">

            <!-- Role Tab Pills -->
            <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1.2rem;">
                <?php foreach ($roles as $key => $role): ?>
                    <button class="role-tab" data-role="<?= $key ?>"
                        style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.14);border-radius:22px;
             color:#bbb;padding:.4rem 1rem;font-size:.8rem;cursor:pointer;transition:all .18s;white-space:nowrap;">
                        <?= $role['icon'] ?> <?= $role['label'] ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- User Panel -->
            <div id="user-panel" style="display:none;">
                <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:14px;overflow:hidden;">

                    <!-- Panel header -->
                    <div style="padding:.8rem 1.2rem;border-bottom:1px solid rgba(255,255,255,.08);display:flex;align-items:center;gap:.8rem;flex-wrap:wrap;">
                        <span style="color:#a78bfa;font-weight:700;" id="panel-title">—</span>
                        <div style="flex:1;min-width:200px;">
                            <input type="text" id="user-search" placeholder="🔍 Cari username / NIM / nama..."
                                style="width:100%;padding:.38rem .8rem;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.16);
                   border-radius:8px;color:#e2e8f0;font-size:.8rem;outline:none;" autocomplete="off">
                        </div>
                        <span id="user-meta" style="color:rgba(255,255,255,.3);font-size:.75rem;white-space:nowrap;"></span>
                    </div>

                    <!-- Table -->
                    <div style="overflow-x:auto;">
                        <table style="width:100%;border-collapse:collapse;font-size:.8rem;">
                            <thead>
                                <tr style="background:rgba(0,0,0,.25);color:rgba(255,255,255,.4);text-align:left;">
                                    <th style="padding:.5rem 1rem;width:36px;">#</th>
                                    <th style="padding:.5rem .8rem;">Username / Identitas</th>
                                    <th style="padding:.5rem .8rem;">Nama / Keterangan</th>
                                    <th style="padding:.5rem 1rem;width:100px;text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="user-tbody">
                                <tr>
                                    <td colspan="4" style="text-align:center;padding:2.5rem;color:rgba(255,255,255,.25);">Pilih role untuk melihat daftar pengguna</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Loading / Empty state -->
                    <div id="user-loading" style="display:none;text-align:center;padding:1.5rem;color:rgba(255,255,255,.35);font-size:.8rem;">
                        <i class="fas fa-spinner fa-spin"></i> Memuat...
                    </div>

                    <!-- Pagination -->
                    <div id="user-pag" style="display:none;padding:.6rem 1rem;border-top:1px solid rgba(255,255,255,.07);
           display:none;align-items:center;justify-content:space-between;">
                        <button id="pg-prev" onclick="DS.page(-1)"
                            style="background:rgba(255,255,255,.1);color:#ccc;border:none;border-radius:6px;padding:.3rem .9rem;font-size:.78rem;cursor:pointer;">
                            ‹ Sebelumnya
                        </button>
                        <span id="pg-info" style="font-size:.78rem;color:rgba(255,255,255,.4);"></span>
                        <button id="pg-next" onclick="DS.page(1)"
                            style="background:rgba(255,255,255,.1);color:#ccc;border:none;border-radius:6px;padding:.3rem .9rem;font-size:.78rem;cursor:pointer;">
                            Selanjutnya ›
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'jsAdm.php'; ?>
        <script>
            var DS = (function() {
                var cache = {};
                var curRole = '';
                var curPage = 1;
                var searchTimer;
                var isSearchMode = false;
                var LIMIT = 20;

                // Role tab click
                document.querySelectorAll('.role-tab').forEach(function(btn) {
                    btn.addEventListener('mouseenter', function() {
                        if (this.dataset.role !== curRole) {
                            this.style.background = 'rgba(167,139,250,.12)';
                            this.style.color = '#ddd';
                        }
                    });
                    btn.addEventListener('mouseleave', function() {
                        if (this.dataset.role !== curRole) {
                            this.style.background = 'rgba(255,255,255,.08)';
                            this.style.color = '#bbb';
                        }
                    });
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.role-tab').forEach(function(b) {
                            b.style.background = 'rgba(255,255,255,.08)';
                            b.style.borderColor = 'rgba(255,255,255,.14)';
                            b.style.color = '#bbb';
                        });
                        this.style.background = 'rgba(167,139,250,.22)';
                        this.style.borderColor = 'rgba(167,139,250,.6)';
                        this.style.color = '#fff';

                        if (curRole !== this.dataset.role) {
                            curRole = this.dataset.role;
                            cache = {}; // reset cache saat ganti role
                            curPage = 1;
                            isSearchMode = false;
                            document.getElementById('user-search').value = '';
                        }
                        document.getElementById('user-panel').style.display = 'block';
                        document.getElementById('panel-title').textContent = 'Masuk sebagai: ' + this.textContent.trim();
                        fetch_page(curRole, 1, '');
                    });
                });

                // Search
                document.getElementById('user-search').addEventListener('input', function() {
                    clearTimeout(searchTimer);
                    var q = this.value.trim();
                    searchTimer = setTimeout(function() {
                        if (q) {
                            isSearchMode = true;
                            fetch_page(curRole, 1, q);
                        } else {
                            isSearchMode = false;
                            fetch_page(curRole, curPage, '');
                        }
                    }, 350);
                });

                function fetch_page(role, page, q) {
                    var isSearch = (q !== '' && q !== '*');
                    var key = role + '_' + page;

                    if (!isSearch && cache[key]) {
                        render(cache[key], page, isSearch, role);
                        return;
                    }

                    document.getElementById('user-loading').style.display = 'block';
                    document.getElementById('user-tbody').innerHTML = '';
                    document.getElementById('user-pag').style.display = 'none';

                    var url = 'superAdminSearch.php?role=' + encodeURIComponent(role) +
                        '&q=' + encodeURIComponent(isSearch ? q : '*') +
                        '&page=' + page + '&limit=' + LIMIT;

                    fetch(url)
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(d) {
                            if (!isSearch) cache[key] = d;
                            render(d, page, isSearch, role);
                        })
                        .catch(function() {
                            document.getElementById('user-loading').style.display = 'none';
                            document.getElementById('user-tbody').innerHTML =
                                '<tr><td colspan="4" style="text-align:center;padding:1.5rem;color:#f87171;">Gagal memuat data.</td></tr>';
                        });
                }

                function render(d, page, isSearch, role) {
                    document.getElementById('user-loading').style.display = 'none';
                    var tbody = document.getElementById('user-tbody');
                    var pag = document.getElementById('user-pag');

                    if (!d.data || !d.data.length) {
                        tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;padding:2rem;color:rgba(255,255,255,.3);">' +
                            (isSearch ? 'Tidak ada hasil.' : 'Tidak ada data.') + '</td></tr>';
                        pag.style.display = 'none';
                        document.getElementById('user-meta').textContent = '0 data';
                        return;
                    }

                    var offset = isSearch ? 0 : (page - 1) * LIMIT;
                    document.getElementById('user-meta').textContent = isSearch ?
                        d.data.length + ' hasil pencarian' :
                        d.total + ' total · hal ' + page + '/' + d.pages;

                    tbody.innerHTML = d.data.map(function(u, i) {
                        var parts = u.text.split(' — ');
                        var id = parts[0] || u.val;
                        var nama = parts[1] || '—';
                        return '<tr class="u-row" data-role="' + role + '" data-val="' + u.val + '"' +
                            ' style="border-bottom:1px solid rgba(255,255,255,.05);cursor:pointer;">' +
                            '<td style="padding:.5rem 1rem;color:rgba(255,255,255,.25);">' + (offset + i + 1) + '</td>' +
                            '<td style="padding:.5rem .8rem;color:#a78bfa;font-weight:700;font-family:monospace;">' + id + '</td>' +
                            '<td style="padding:.5rem .8rem;color:#e2e8f0;">' + nama + '</td>' +
                            '<td style="padding:.5rem 1rem;text-align:center;">' +
                            '<button class="u-btn" data-role="' + role + '" data-val="' + u.val + '"' +
                            ' style="background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border:none;' +
                            'border-radius:6px;padding:.28rem .8rem;font-size:.75rem;font-weight:700;cursor:pointer;">⇄ Masuk</button>' +
                            '</td></tr>';
                    }).join('');

                    // Hover
                    tbody.querySelectorAll('.u-row').forEach(function(r) {
                        r.addEventListener('mouseenter', function() {
                            this.style.background = 'rgba(167,139,250,.07)';
                        });
                        r.addEventListener('mouseleave', function() {
                            this.style.background = '';
                        });
                        r.addEventListener('click', function() {
                            doSwitch(this.dataset.role, this.dataset.val);
                        });
                    });
                    tbody.querySelectorAll('.u-btn').forEach(function(b) {
                        b.addEventListener('click', function(e) {
                            e.stopPropagation();
                            this.textContent = '…';
                            doSwitch(this.dataset.role, this.dataset.val);
                        });
                    });

                    // Pagination (mode list saja)
                    if (!isSearch && d.pages > 1) {
                        pag.style.display = 'flex';
                        document.getElementById('pg-info').textContent = 'Halaman ' + page + ' dari ' + d.pages;
                        document.getElementById('pg-prev').disabled = (page <= 1);
                        document.getElementById('pg-next').disabled = (page >= d.pages);
                        curPage = page;
                    } else {
                        pag.style.display = 'none';
                    }
                }

                function doSwitch(role, val) {
                    fetch('superAdminSwitch.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'role=' + encodeURIComponent(role) + '&val=' + encodeURIComponent(val)
                        })
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(d) {
                            if (d.redirect) location.href = d.redirect;
                            else alert(d.error || 'Gagal.');
                        });
                }

                return {
                    page: function(dir) {
                        if (isSearchMode) return;
                        var np = curPage + dir;
                        if (np < 1) return;
                        fetch_page(curRole, np, '');
                    }
                };
            })();
        </script>
        <style>
            input:focus {
                border-color: rgba(167, 139, 250, .55) !important;
            }

            input::placeholder {
                color: rgba(255, 255, 255, .3) !important;
            }

            button:disabled {
                opacity: .35;
                cursor: default !important;
            }

            ::-webkit-scrollbar {
                width: 5px;
            }

            ::-webkit-scrollbar-thumb {
                background: rgba(167, 139, 250, .35);
                border-radius: 4px;
            }
        </style>
</body>

</html>
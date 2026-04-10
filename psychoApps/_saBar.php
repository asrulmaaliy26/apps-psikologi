<?php

/**
 * _saBar.php — Super Admin Floating Role Switcher
 * Include di navtopAdm.php: if(!empty($_SESSION['is_superadmin'])) include __DIR__.'/_saBar.php';
 */
if (empty($_SESSION['is_superadmin'])) return;
require_once __DIR__ . '/configSA.php';
$roles      = sa_roles();
$activeRole = $_SESSION['sa_role_active'] ?? '';
$curLabel   = !empty($activeRole) && isset($roles[$activeRole])
    ? $roles[$activeRole]['icon'] . ' ' . $roles[$activeRole]['label']
    : '— Pilih Role';
?>
<style>
    #sa-bar {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 99999;
        width: 370px;
        background: rgba(10, 8, 32, .96);
        border: 1px solid rgba(167, 139, 250, .3);
        border-radius: 14px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .65);
        backdrop-filter: blur(14px);
        font-family: system-ui, sans-serif;
        font-size: 12.5px;
        color: #e2e8f0;
    }

    #sa-bar.sa-col #sa-bd {
        display: none;
    }

    #sa-hd {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 7px 12px;
        cursor: pointer;
        user-select: none;
        border-bottom: 1px solid rgba(255, 255, 255, .07);
    }

    .sa-badge {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        font-weight: 800;
        font-size: 10px;
        padding: 2px 7px;
        border-radius: 20px;
        margin-right: 7px;
    }

    #sa-cur {
        color: #a78bfa;
        font-weight: 600;
        font-size: 11.5px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 220px;
    }

    #sa-tog {
        background: none;
        border: none;
        color: rgba(255, 255, 255, .4);
        cursor: pointer;
        font-size: 13px;
        padding: 0;
    }

    #sa-bd {
        padding: 10px 12px;
    }

    #sa-role-sel,
    #sa-search {
        width: 100%;
        padding: 5px 8px;
        background: rgba(255, 255, 255, .07);
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 7px;
        color: #e2e8f0;
        font-size: 12px;
        outline: none;
        box-sizing: border-box;
    }

    #sa-role-sel {
        margin-bottom: 7px;
        cursor: pointer;
    }

    #sa-role-sel option {
        background: #1a1535;
    }

    #sa-search {
        display: none;
        margin-bottom: 6px;
    }

    #sa-search:focus {
        border-color: rgba(167, 139, 250, .55);
    }

    #sa-tbl-wrap {
        display: none;
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    #sa-status {
        text-align: center;
        padding: .75rem;
        color: rgba(255, 255, 255, .35);
        font-size: 11.5px;
    }

    #sa-rows-wrap {
        max-height: 210px;
        overflow-y: auto;
    }

    #sa-rows-wrap::-webkit-scrollbar {
        width: 4px;
    }

    #sa-rows-wrap::-webkit-scrollbar-thumb {
        background: rgba(167, 139, 250, .4);
        border-radius: 4px;
    }

    #sa-tbl {
        width: 100%;
        border-collapse: collapse;
    }

    #sa-tbl tr {
        border-bottom: 1px solid rgba(255, 255, 255, .05);
        cursor: pointer;
    }

    #sa-tbl tr:hover td {
        background: rgba(167, 139, 250, .1);
    }

    #sa-tbl td {
        padding: 5px 7px;
        vertical-align: middle;
    }

    .sa-n {
        color: rgba(255, 255, 255, .25);
        width: 24px;
        text-align: right;
        font-size: 11px;
    }

    .sa-v {
        color: #a78bfa;
        font-weight: 700;
        font-family: monospace;
        font-size: 11.5px;
    }

    .sa-nm {
        color: #cbd5e1;
        font-size: 11.5px;
        max-width: 130px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .sa-in {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 2px 7px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
    }

    .sa-in:hover {
        opacity: .8;
    }

    /* Paginasi */
    #sa-pag {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px 8px;
        border-top: 1px solid rgba(255, 255, 255, .07);
        font-size: 11px;
    }

    .sa-pag-btn {
        background: rgba(255, 255, 255, .1);
        color: #ccc;
        border: none;
        border-radius: 5px;
        padding: 2px 9px;
        cursor: pointer;
        font-size: 11px;
    }

    .sa-pag-btn:disabled {
        opacity: .35;
        cursor: default;
    }

    .sa-pag-btn:not(:disabled):hover {
        background: rgba(167, 139, 250, .25);
        color: #fff;
    }

    /* Bottom */
    #sa-acts {
        display: flex;
        gap: 5px;
    }

    .sa-act {
        flex: 1;
        padding: 5px;
        border: none;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 600;
        cursor: pointer;
    }

    .sa-a-dash {
        background: rgba(255, 255, 255, .1);
        color: #e2e8f0;
    }

    .sa-a-dash:hover {
        background: rgba(255, 255, 255, .18);
    }

    .sa-a-out {
        background: rgba(239, 68, 68, .15);
        color: #fca5a5;
    }

    .sa-a-out:hover {
        background: rgba(239, 68, 68, .3);
    }

    input::placeholder {
        color: rgba(255, 255, 255, .3) !important;
    }
</style>

<div id="sa-bar">
    <div id="sa-hd" onclick="SA.toggle()">
        <span style="display:flex;align-items:center;">
            <span class="sa-badge">SA</span>
            <span id="sa-cur"><?= htmlspecialchars($curLabel) ?></span>
        </span>
        <button id="sa-tog">▴</button>
    </div>

    <div id="sa-bd">
        <select id="sa-role-sel" onchange="SA.roleChange()">
            <option value="">— Pilih Role —</option>
            <?php foreach ($roles as $k => $r): ?>
                <option value="<?= $k ?>" <?= $k === $activeRole ? 'selected' : '' ?>>
                    <?= $r['icon'] ?> <?= $r['label'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" id="sa-search" placeholder="🔍 Cari username / NIM / nama..."
            autocomplete="off" oninput="SA.onSearch()">

        <div id="sa-tbl-wrap">
            <div id="sa-status">Pilih role terlebih dahulu</div>
            <div id="sa-rows-wrap" style="display:none;">
                <table id="sa-tbl">
                    <tbody id="sa-body"></tbody>
                </table>
            </div>
            <div id="sa-pag" style="display:none;">
                <button class="sa-pag-btn" id="sa-prev" onclick="SA.page(-1)">‹ Prev</button>
                <span id="sa-pag-info" style="color:rgba(255,255,255,.4);"></span>
                <button class="sa-pag-btn" id="sa-next" onclick="SA.page(1)">Next ›</button>
            </div>
        </div>

        <div id="sa-acts">
            <button class="sa-act sa-a-dash" id="sa-dash-btn">⊞ Dashboard</button>
            <button class="sa-act sa-a-out" id="sa-out-btn">✕ Logout SA</button>
        </div>
    </div>
</div>

<script>
    var SA = (function() {
        // Tentukan base path ke psychoApps/
        var base = (window.location.href.indexOf('/simagis/') !== -1) ? '../psychoApps/' : '';

        // Setup link buttons
        document.getElementById('sa-dash-btn').onclick = function() {
            location.href = base + 'superAdminDashboard.php';
        };
        document.getElementById('sa-out-btn').onclick = function() {
            location.href = base + 'superAdminLogout.php';
        };

        // Restore collapse
        if (localStorage.getItem('sa_col') === '1') {
            document.getElementById('sa-bar').classList.add('sa-col');
            document.getElementById('sa-tog').textContent = '▾';
        }

        var cache = {}; // cache[role][page] = { data, total, pages }
        var curRole = '<?= addslashes($activeRole) ?>';
        var curPage = 1;
        var curSearch = '';
        var searchTimer;
        var LIMIT = 12;

        function fetchPage(role, page, q) {
            var cacheKey = role + '_' + page;
            var isSearch = (q && q !== '*' && q !== '');

            // Jika tidak search dan sudah di-cache, render langsung
            if (!isSearch && cache[cacheKey]) {
                render(cache[cacheKey], page, isSearch);
                return;
            }

            setStatus('⏳');
            var url = base + 'superAdminSearch.php?role=' + encodeURIComponent(role) +
                '&q=' + encodeURIComponent(isSearch ? q : '*') +
                '&page=' + page +
                '&limit=' + LIMIT;

            fetch(url)
                .then(function(r) {
                    return r.json();
                })
                .then(function(d) {
                    if (!isSearch) cache[cacheKey] = d; // simpan cache hanya untuk mode list
                    render(d, page, isSearch);
                })
                .catch(function() {
                    setStatus('❌ Gagal memuat data');
                });
        }

        function render(d, page, isSearch) {
            var tbody = document.getElementById('sa-body');
            var rowWrap = document.getElementById('sa-rows-wrap');
            var pag = document.getElementById('sa-pag');
            var status = document.getElementById('sa-status');

            if (!d.data || !d.data.length) {
                status.textContent = isSearch ? 'Tidak ada hasil untuk pencarian ini.' : 'Tidak ada data.';
                status.style.display = 'block';
                rowWrap.style.display = 'none';
                pag.style.display = 'none';
                return;
            }

            status.style.display = 'none';
            rowWrap.style.display = 'block';

            // Offset nomor urut
            var startNum = isSearch ? 1 : (page - 1) * LIMIT + 1;

            tbody.innerHTML = d.data.map(function(u, i) {
                var parts = u.text.split(' — ');
                var id = parts[0] || u.val;
                var nama = parts[1] || '—';
                return '<tr data-val="' + u.val + '">' +
                    '<td class="sa-n">' + (startNum + i) + '</td>' +
                    '<td class="sa-v">' + id + '</td>' +
                    '<td class="sa-nm" title="' + nama + '">' + nama + '</td>' +
                    '<td><button class="sa-in" data-val="' + u.val + '">⇄</button></td>' +
                    '</tr>';
            }).join('');

            // Events
            tbody.querySelectorAll('tr').forEach(function(tr) {
                tr.onclick = function() {
                    doSwitch(this.dataset.val);
                };
            });
            tbody.querySelectorAll('.sa-in').forEach(function(btn) {
                btn.onclick = function(e) {
                    e.stopPropagation();
                    this.textContent = '…';
                    doSwitch(this.dataset.val);
                };
            });

            // Pagination (hanya saat mode list)
            if (!isSearch && d.pages > 1) {
                pag.style.display = 'flex';
                document.getElementById('sa-pag-info').textContent = page + ' / ' + d.pages + ' (' + d.total + ')';
                document.getElementById('sa-prev').disabled = (page <= 1);
                document.getElementById('sa-next').disabled = (page >= d.pages);
                curPage = page;
            } else {
                pag.style.display = 'none';
                if (isSearch) {
                    var info = document.createElement('div');
                    info.style.cssText = 'text-align:center;padding:3px;font-size:11px;color:rgba(255,255,255,.3);';
                    info.textContent = d.data.length + ' hasil pencarian';
                    pag.parentNode.insertBefore(info, pag);
                    setTimeout(function() {
                        if (info.parentNode) info.parentNode.removeChild(info);
                    }, 3000);
                }
            }
        }

        function setStatus(msg) {
            document.getElementById('sa-status').textContent = msg;
            document.getElementById('sa-status').style.display = 'block';
            document.getElementById('sa-rows-wrap').style.display = 'none';
            document.getElementById('sa-pag').style.display = 'none';
        }

        function doSwitch(val) {
            if (!curRole) return;
            fetch(base + 'superAdminSwitch.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'role=' + encodeURIComponent(curRole) + '&val=' + encodeURIComponent(val)
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
            toggle: function() {
                var bar = document.getElementById('sa-bar');
                bar.classList.toggle('sa-col');
                var isc = bar.classList.contains('sa-col');
                document.getElementById('sa-tog').textContent = isc ? '▾' : '▴';
                localStorage.setItem('sa_col', isc ? '1' : '0');
            },

            roleChange: function() {
                curRole = document.getElementById('sa-role-sel').value;
                curPage = 1;
                curSearch = '';
                cache = {}; // reset cache saat ganti role
                document.getElementById('sa-search').value = '';
                var srch = document.getElementById('sa-search');
                var tbl = document.getElementById('sa-tbl-wrap');
                srch.style.display = curRole ? 'block' : 'none';
                tbl.style.display = curRole ? 'block' : 'none';
                if (curRole) fetchPage(curRole, 1, '');
            },

            onSearch: function() {
                clearTimeout(searchTimer);
                var q = document.getElementById('sa-search').value.trim();
                searchTimer = setTimeout(function() {
                    curSearch = q;
                    if (q) {
                        // Search mode: langsung ke server
                        fetchPage(curRole, 1, q);
                    } else {
                        // Kembali ke list mode, gunakan cache jika ada
                        fetchPage(curRole, 1, '');
                    }
                }, 350);
            },

            page: function(dir) {
                var newPage = curPage + dir;
                if (newPage < 1) return;
                fetchPage(curRole, newPage, '');
            }
        };
    })();

    // Load role aktif saat pertama kali jika ada
    <?php if ($activeRole): ?>
        document.getElementById('sa-search').style.display = 'block';
        document.getElementById('sa-tbl-wrap').style.display = 'block';
        SA.roleChange();
    <?php endif; ?>
</script>
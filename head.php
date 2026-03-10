<!-- head.php — include di setiap halaman (CSS & JS libraries) -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<style>
    :root { --primary:#1a56db; --primary-dark:#1344b8; --bg:#f1f5f9; --border:#e2e8f0; --text:#1e293b; --muted:#64748b; }
    * { font-family:'Plus Jakarta Sans',sans-serif; }
    body { background:var(--bg); color:var(--text); }

    /* Navbar */
    .navbar { background:linear-gradient(135deg,#1a56db,#1344b8); box-shadow:0 2px 12px rgba(26,86,219,0.3); }
    .navbar-brand { font-weight:800; font-size:1rem; text-decoration:none; }
    .nav-btn { color:rgba(255,255,255,0.7); text-decoration:none; padding:5px 12px; border-radius:8px; font-size:0.82rem; font-weight:600; transition:all 0.15s; }
    .nav-btn:hover, .nav-btn.active { background:rgba(255,255,255,0.18); color:white; }

    /* Page header */
    .page-header { background:white; border-radius:16px; padding:1.2rem 1.5rem; margin-bottom:1.2rem; border:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
    .page-header h5 { font-weight:800; margin:0; }
    .page-header .breadcrumb { margin:0; font-size:0.8rem; }

    /* Stat cards */
    .stat-card { border:2px solid transparent; border-radius:16px; padding:1.2rem; transition:all 0.2s; cursor:pointer; background:white; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
    .stat-card:hover { transform:translateY(-3px); box-shadow:0 6px 20px rgba(0,0,0,0.1); border-color:var(--primary); }
    .stat-card .icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; }
    .stat-card .number { font-size:1.9rem; font-weight:800; line-height:1; }
    .stat-card .label { font-size:0.78rem; color:var(--muted); font-weight:600; margin-top:3px; }

    /* Cards */
    .card { border:1px solid var(--border); border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
    .card-header { background:white; border-bottom:1px solid var(--border); border-radius:16px 16px 0 0 !important; padding:1rem 1.25rem; font-weight:700; }

    /* Laptop cards */
    .laptop-card { border:1.5px solid var(--border); border-radius:14px; padding:1rem; transition:all 0.2s; background:white; position:relative; }
    .laptop-card.tersedia { cursor:pointer; }
    .laptop-card.tersedia:hover { border-color:var(--primary); box-shadow:0 4px 16px rgba(26,86,219,0.12); transform:translateY(-2px); }
    .laptop-card.dipinjam { border-color:#fed7aa; background:#fffbeb; }
    .laptop-card.maintenance { border-color:#e2e8f0; background:#f8fafc; }
    .laptop-card .kode { font-size:0.72rem; font-weight:700; color:var(--primary); background:#eff6ff; padding:2px 8px; border-radius:6px; }
    .laptop-card .nama { font-weight:700; font-size:0.92rem; margin:6px 0 2px; }
    .laptop-card .spek { font-size:0.76rem; color:var(--muted); }
    .laptop-card .action-icons { position:absolute; top:10px; right:10px; display:flex; gap:4px; opacity:0; transition:opacity 0.2s; }
    .laptop-card:hover .action-icons { opacity:1; }
    .btn-icon { width:28px; height:28px; border-radius:7px; border:none; display:flex; align-items:center; justify-content:center; font-size:0.8rem; cursor:pointer; }
    .btn-edit { background:#eff6ff; color:var(--primary); }
    .btn-edit:hover { background:var(--primary); color:white; }
    .btn-del { background:#fef2f2; color:#dc2626; }
    .btn-del:hover { background:#dc2626; color:white; }

    /* Badges */
    .badge-tersedia { background:#d1fae5; color:#065f46; font-size:0.7rem; font-weight:700; padding:2px 9px; border-radius:20px; }
    .badge-dipinjam { background:#fed7aa; color:#92400e; font-size:0.7rem; font-weight:700; padding:2px 9px; border-radius:20px; }
    .badge-maintenance { background:#e2e8f0; color:#475569; font-size:0.7rem; font-weight:700; padding:2px 9px; border-radius:20px; }
    .badge-dikembalikan { background:#d1fae5; color:#065f46; font-size:0.7rem; font-weight:700; padding:2px 9px; border-radius:20px; }

    /* User info */
    .user-info { background:#fff7ed; border-radius:8px; padding:7px 9px; margin-top:8px; font-size:0.76rem; }
    .user-info .user-name { font-weight:700; color:#92400e; }

    /* Table */
    .table th { font-size:0.75rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.4px; }
    .table td { font-size:0.83rem; vertical-align:middle; }

    /* Buttons */
    .btn { border-radius:10px; font-weight:600; font-size:0.85rem; }
    .btn-primary { background:var(--primary); border-color:var(--primary); }
    .btn-primary:hover { background:var(--primary-dark); }

    /* Modal */
    .modal-content { border-radius:20px; border:none; }
    .modal-header { border-bottom:1px solid var(--border); }
    .modal-title { font-weight:700; }
    .form-label { font-size:0.83rem; font-weight:600; }
    .form-control, .form-select { border-radius:10px; border-color:var(--border); font-size:0.86rem; }
    .form-control:focus, .form-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(26,86,219,0.1); }

    /* Empty state */
    .empty-state { text-align:center; padding:3rem; color:var(--muted); }
    .empty-state i { font-size:2.5rem; opacity:0.25; }
</style>

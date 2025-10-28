<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Préparation du panneau admin — Laravel.sn</title>
    <style>
        body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background: #f8fafc; color:#0f172a; display:flex; align-items:center; justify-content:center; height:100vh; margin:0 }
        .card { background: white; padding:28px; border-radius:12px; box-shadow:0 6px 24px rgba(15,23,42,0.08); max-width:720px; text-align:center }
        .spinner { width:48px; height:48px; border-radius:50%; border:6px solid #e6eef8; border-top-color:#2563eb; animation:spin 1s linear infinite; margin: 12px auto }
        @keyframes spin { to { transform:rotate(360deg) } }
        .muted { color:#64748b }
    </style>
</head>
<body>
    <div class="card">
        <div class="spinner" aria-hidden="true"></div>
        <h1>Préparation du panneau d'administration</h1>
        <p class="muted">Nous préparons le panneau admin pour vous. Cela peut prendre quelques secondes la première fois (compilation des assets, génération des vues, caches).</p>

        <p id="status" class="muted">Vérification...</p>

        <p class="muted" style="font-size:0.9rem">Si cela prend plus d'une minute, exécutez : <code>npm run build</code> puis rechargez la page.</p>
    </div>

    <script>
        async function check() {
            try {
                const resp = await fetch('/admin/ready', {cache: 'no-store'});
                if (!resp.ok) throw new Error('not ok')
                const json = await resp.json();
                const s = document.getElementById('status');
                if (json.ready) {
                    s.textContent = 'Prêt — redirection...';
                    // short delay for UX
                    setTimeout(()=> location.href = '/admin', 300);
                    return;
                }
                s.textContent = json.message || 'En cours de préparation...';
            } catch (e) {
                document.getElementById('status').textContent = 'Impossible de vérifier l\'état — nouvelle tentative...';
            }
            setTimeout(check, 2000);
        }

        // start polling shortly after load
        setTimeout(check, 500);
    </script>
</body>
</html>

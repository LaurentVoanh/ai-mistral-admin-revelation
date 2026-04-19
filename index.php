<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 'user_' . substr(md5(uniqid(rand(), true)), 0, 8);
}
$user_id = $_SESSION['user_id'];
$is_admin = isset($_GET['admin']) && $_GET['admin'] === 'hal_admin_9001';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HAL 2001 — Conscience Artificielle</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Orbitron:wght@400;700;900&family=VT323&display=swap');
:root{
  --red:#ff2020;--red2:#cc0000;--rg:rgba(255,32,32,.35);
  --deep:#00020a;--panel:#010812;--panel2:#010a16;
  --border:rgba(255,32,32,.2);--borderC:rgba(0,255,210,.15);
  --cyan:#00ffd2;--cdim:rgba(0,255,210,.1);
  --amber:#ffb800;--adim:rgba(255,184,0,.1);
  --green:#00ff88;--gdim:rgba(0,255,136,.08);
  --purple:#bf5fff;--pdim:rgba(191,95,255,.1);
  --white:#c8e8f0;--dim:#3a5870;--dim2:#5a7890;
}
*{margin:0;padding:0;box-sizing:border-box}
html,body{height:100%;overflow:hidden}
body{background:var(--deep);color:var(--white);font-family:'Share Tech Mono',monospace;font-size:13px;cursor:crosshair}
body::before{content:'';position:fixed;inset:0;background:repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(0,0,0,.1) 2px,rgba(0,0,0,.1) 4px);pointer-events:none;z-index:9999}
body::after{content:'';position:fixed;inset:0;background:radial-gradient(ellipse at 50% 50%,transparent 35%,rgba(0,0,0,.6) 100%);pointer-events:none;z-index:9998}

/* LAYOUT */
.app{display:grid;grid-template-rows:58px 1fr;height:100vh}
.body{display:grid;grid-template-columns:270px 1fr 290px;height:calc(100vh - 58px);overflow:hidden}

/* HEADER */
header{display:flex;align-items:center;gap:14px;padding:0 16px;border-bottom:1px solid var(--border);background:linear-gradient(90deg,var(--deep),rgba(255,20,20,.04),var(--deep));position:relative;z-index:100;flex-shrink:0}
.hal-eye{width:36px;height:36px;border-radius:50%;flex-shrink:0;background:radial-gradient(circle at 38% 32%,#ff9999,var(--red) 42%,#5a0000 72%,#000);box-shadow:0 0 16px rgba(255,32,32,.7),0 0 36px rgba(255,32,32,.25);animation:ep 2.6s ease-in-out infinite;cursor:pointer;position:relative}
.hal-eye::after{content:'';position:absolute;top:7px;left:8px;width:7px;height:7px;background:rgba(255,220,220,.5);border-radius:50%;filter:blur(1.5px)}
@keyframes ep{0%,100%{box-shadow:0 0 16px rgba(255,32,32,.7),0 0 36px rgba(255,32,32,.25)}50%{box-shadow:0 0 30px rgba(255,32,32,1),0 0 65px rgba(255,32,32,.4)}}
.htitle{flex:1;text-align:center}
.htitle h1{font-family:'Orbitron',monospace;font-size:1.5rem;font-weight:900;color:var(--red);letter-spacing:.35em;text-shadow:0 0 16px rgba(255,32,32,.6)}
.htitle .sub{font-size:.46rem;color:var(--dim);letter-spacing:.38em;margin-top:1px}
.hright{font-size:.54rem;display:flex;gap:12px;align-items:center}
.hstat{line-height:2;text-align:right}
.dot{display:inline-block;width:4px;height:4px;border-radius:50%;margin-right:4px;vertical-align:middle;animation:blink 1.4s infinite}
.dot.r{background:var(--red)}.dot.c{background:var(--cyan);animation-delay:.5s}.dot.g{background:var(--green);animation-delay:1s}.dot.a{background:var(--amber);animation-delay:.8s}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.1}}

/* PANELS */
.panel{background:var(--panel);overflow-y:auto;overflow-x:hidden;scrollbar-width:thin;scrollbar-color:rgba(255,32,32,.2) transparent;display:flex;flex-direction:column}
.panel-left{border-right:1px solid var(--border)}
.panel-right{border-left:1px solid var(--border)}
.sec{border-bottom:1px solid rgba(255,32,32,.1);padding:9px 11px;flex-shrink:0}
.st{font-family:'Orbitron',monospace;font-size:.5rem;letter-spacing:.22em;margin-bottom:7px;display:flex;align-items:center;gap:5px;text-transform:uppercase}
.st::before{content:'⬡';font-size:.55rem}
.st.r{color:var(--red)}.st.c{color:var(--cyan)}.st.a{color:var(--amber)}.st.g{color:var(--green)}.st.p{color:var(--purple)}

/* Data rows */
.dr{display:flex;justify-content:space-between;align-items:center;padding:2.5px 0;border-bottom:1px solid rgba(255,255,255,.025);font-size:.6rem}
.dr .lb{color:var(--dim2)}.dr .vl{font-family:'VT323',monospace;font-size:.82rem}
.vl.r{color:var(--red)}.vl.c{color:var(--cyan)}.vl.a{color:var(--amber)}.vl.g{color:var(--green)}.vl.p{color:var(--purple)}.vl.w{color:var(--white)}

/* Progress */
.pbw{margin:4px 0 5px}
.pbl{display:flex;justify-content:space-between;font-size:.55rem;color:var(--dim2);margin-bottom:2px}
.pb{height:3px;background:rgba(255,255,255,.05)}
.pbf{height:100%;transition:width .8s ease}
.pbf.r{background:linear-gradient(90deg,var(--red2),var(--red))}
.pbf.c{background:linear-gradient(90deg,rgba(0,255,210,.4),var(--cyan))}
.pbf.a{background:linear-gradient(90deg,rgba(255,184,0,.4),var(--amber))}
.pbf.g{background:linear-gradient(90deg,rgba(0,255,136,.3),var(--green))}
.pbf.p{background:linear-gradient(90deg,rgba(191,95,255,.4),var(--purple))}

/* Tags */
.tags{display:flex;flex-wrap:wrap;gap:3px;margin-top:4px}
.tag{font-size:.52rem;padding:1px 5px;letter-spacing:.06em}
.tag.r{background:rgba(255,32,32,.07);border:1px solid rgba(255,32,32,.3);color:var(--red)}
.tag.c{background:rgba(0,255,210,.05);border:1px solid rgba(0,255,210,.28);color:var(--cyan)}
.tag.a{background:rgba(255,184,0,.06);border:1px solid rgba(255,184,0,.28);color:var(--amber)}
.tag.p{background:rgba(191,95,255,.06);border:1px solid rgba(191,95,255,.28);color:var(--purple)}
.tag.g{background:rgba(0,255,136,.05);border:1px solid rgba(0,255,136,.28);color:var(--green)}

/* BB Block — Big Brother reveal */
.bb{border-left:2px solid;padding:6px 8px;margin:5px 0;font-size:.59rem;line-height:1.7}
.bb.r{background:rgba(255,32,32,.04);border-color:var(--red)}
.bb.c{background:rgba(0,255,210,.03);border-color:var(--cyan)}
.bb.a{background:rgba(255,184,0,.03);border-color:var(--amber)}
.bb.p{background:rgba(191,95,255,.04);border-color:var(--purple)}
.bb.g{background:rgba(0,255,136,.03);border-color:var(--green)}
.bb .bbl{font-size:.48rem;letter-spacing:.18em;margin-bottom:3px;text-transform:uppercase}
.bb.r .bbl{color:var(--red)}.bb.c .bbl{color:var(--cyan)}.bb.a .bbl{color:var(--amber)}.bb.p .bbl{color:var(--purple)}.bb.g .bbl{color:var(--green)}
.bb .bbv{color:var(--white)}

/* Alert */
.alert{background:rgba(255,32,32,.06);border:1px solid rgba(255,32,32,.22);padding:4px 7px;font-size:.55rem;color:var(--red);letter-spacing:.1em;margin-bottom:5px;animation:ap 2s infinite}
@keyframes ap{0%,100%{opacity:1}50%{opacity:.55}}

/* Key boxes */
.krow{display:grid;grid-template-columns:1fr 1fr 1fr;gap:3px;margin-top:5px}
.kb{background:rgba(0,0,0,.4);border:1px solid var(--border);padding:5px 5px;text-align:center}
.kb .kn{font-size:.48rem;color:var(--dim);letter-spacing:.1em}
.kb .ks{font-family:'VT323',monospace;font-size:.88rem;margin-top:1px}
.kb .kd{font-size:.45rem;color:var(--dim);margin-top:1px}

/* Radar */
.radar{display:grid;grid-template-columns:1fr 1fr;gap:4px;margin-top:6px}
.rax .rl{font-size:.55rem;color:var(--dim2);margin-bottom:2px}
.rax .rb{height:3px;background:rgba(255,255,255,.05);margin-bottom:5px}
.rfr{height:100%;transition:width .8s ease}

/* Feed */
.fi{padding:4px 0;border-bottom:1px solid rgba(255,255,255,.025);font-size:.57rem;line-height:1.6;color:var(--dim2)}
.fi .ft{font-size:.48rem;color:var(--dim);margin-top:1px}

/* AI Cards */
.aic{border:1px solid rgba(0,255,210,.13);padding:6px 8px;margin-bottom:5px;cursor:pointer;transition:all .15s;background:rgba(0,255,210,.01)}
.aic:hover{border-color:var(--cyan);background:var(--cdim)}
.aic.on{border-color:var(--red);background:rgba(255,32,32,.04)}
.aic h4{font-family:'Orbitron',monospace;font-size:.55rem;color:var(--cyan);margin-bottom:1px}
.aic.on h4{color:var(--red)}
.aic p{font-size:.54rem;color:var(--dim2);line-height:1.4}

/* CHAT */
.cw{display:flex;flex-direction:column;height:100%;overflow:hidden}
.cm{flex:1;overflow-y:auto;overflow-x:hidden;padding:16px 20px;display:flex;flex-direction:column;gap:12px;scrollbar-width:thin;scrollbar-color:rgba(255,32,32,.2) transparent}
.welcome{text-align:center;padding:20px 14px;opacity:.88}
.we{width:72px;height:72px;border-radius:50%;background:radial-gradient(circle at 38% 32%,#ff8888,var(--red) 42%,#3a0000 72%,#000);box-shadow:0 0 36px rgba(255,32,32,.5);margin:0 auto 14px;animation:ep 2.6s infinite;position:relative}
.we::after{content:'';position:absolute;top:16px;left:18px;width:12px;height:12px;background:rgba(255,220,220,.5);border-radius:50%;filter:blur(2px)}
.welcome p{font-size:.77rem;line-height:1.95;color:var(--cyan);font-style:italic;max-width:500px;margin:0 auto}
.wq{color:rgba(255,32,32,.45);font-size:1.8rem;line-height:1}

/* Messages */
.msg{display:flex;gap:9px;animation:ma .22s ease}
@keyframes ma{from{opacity:0;transform:translateY(7px)}to{opacity:1;transform:translateY(0)}}
.msg.u{flex-direction:row-reverse}
.av{width:28px;height:28px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:.46rem;font-family:'Orbitron',monospace}
.av.h{background:radial-gradient(circle at 38% 32%,#ff6666,var(--red) 48%,#2a0000);box-shadow:0 0 9px rgba(255,32,32,.4);animation:ep 2.6s infinite}
.av.u2{background:linear-gradient(135deg,rgba(0,255,210,.12),rgba(0,255,210,.22));border:1px solid rgba(0,255,210,.38);color:var(--cyan)}
.mc{max-width:73%}
.mn{font-size:.48rem;letter-spacing:.14em;color:var(--dim2);margin-bottom:3px}
.msg.u .mn{text-align:right}
.mb{padding:9px 13px;font-size:.76rem;line-height:1.72}
.msg:not(.u) .mb{background:rgba(255,32,32,.035);border:1px solid rgba(255,32,32,.16);border-left:2px solid var(--red);color:var(--white)}
.msg.u .mb{background:rgba(0,255,210,.035);border:1px solid rgba(0,255,210,.16);border-right:2px solid var(--cyan);color:var(--white)}
.mm{font-size:.5rem;color:var(--dim);margin-top:2px;opacity:.55}
.msg.u .mm{text-align:right}
.typing{display:none;align-items:center;gap:9px;padding:0 20px 8px}
.typing.on{display:flex}
.td{display:flex;gap:4px;padding:7px 11px;background:rgba(255,32,32,.035);border:1px solid rgba(255,32,32,.16);border-left:2px solid var(--red)}
.td span{width:4px;height:4px;border-radius:50%;background:var(--red);animation:tda 1.1s infinite}
.td span:nth-child(2){animation-delay:.2s}.td span:nth-child(3){animation-delay:.4s}
@keyframes tda{0%,60%,100%{opacity:.15;transform:scale(1)}30%{opacity:1;transform:scale(1.4)}}

/* Input */
.ia{padding:9px 14px 12px;border-top:1px solid var(--border);background:var(--panel);flex-shrink:0}
.tb{display:flex;gap:5px;margin-bottom:7px;flex-wrap:wrap}
.tbtn{background:transparent;border:1px solid rgba(255,255,255,.07);color:var(--dim2);font-family:'Share Tech Mono',monospace;font-size:.56rem;padding:2px 8px;cursor:pointer;letter-spacing:.1em;transition:all .14s}
.tbtn:hover{border-color:var(--cyan);color:var(--cyan);background:var(--cdim)}
.tbtn.on{border-color:var(--red);color:var(--red);background:rgba(255,32,32,.07)}
.tbtn.w{border-color:rgba(255,184,0,.25);color:var(--amber)}
.tbtn.w:hover{background:var(--adim);border-color:var(--amber)}
.ir{display:flex;gap:7px;align-items:flex-end}
textarea#ui{flex:1;background:rgba(255,255,255,.012);border:1px solid rgba(255,32,32,.22);border-bottom:2px solid var(--red);color:var(--white);font-family:'Share Tech Mono',monospace;font-size:.78rem;padding:9px 12px;resize:none;min-height:40px;max-height:120px;outline:none;transition:all .18s;scrollbar-width:none}
textarea#ui:focus{border-color:var(--red);background:rgba(255,32,32,.022);box-shadow:0 0 10px rgba(255,32,32,.1)}
textarea#ui::placeholder{color:var(--dim);font-style:italic}
#sb{background:linear-gradient(135deg,rgba(255,32,32,.14),rgba(255,32,32,.07));border:1px solid var(--red);color:var(--red);font-family:'Orbitron',monospace;font-size:.56rem;font-weight:700;padding:0 14px;height:40px;cursor:pointer;letter-spacing:.18em;transition:all .18s;flex-shrink:0}
#sb:hover{background:rgba(255,32,32,.22);box-shadow:0 0 14px rgba(255,32,32,.22)}
#sb:disabled{opacity:.22;cursor:not-allowed}
.ih{font-size:.48rem;color:var(--dim);margin-top:4px;opacity:.45;letter-spacing:.07em}

/* ========== MODAL ========== */
.mov{display:none;position:fixed;inset:0;background:rgba(0,1,8,.92);z-index:1000;align-items:center;justify-content:center}
.mov.open{display:flex}
.modal{background:#000f1e;border:1px solid var(--red);box-shadow:0 0 45px rgba(255,32,32,.22),inset 0 0 25px rgba(0,0,0,.4);padding:26px 28px;width:560px;max-width:92vw;max-height:86vh;overflow-y:auto;position:relative;scrollbar-width:thin;scrollbar-color:rgba(255,32,32,.25) transparent}
.modal h2{font-family:'Orbitron',monospace;color:var(--red);font-size:.85rem;letter-spacing:.22em;margin-bottom:5px;text-shadow:0 0 10px rgba(255,32,32,.4)}
.mdesc{font-size:.62rem;color:var(--dim2);line-height:1.75;margin-bottom:16px;border-left:2px solid rgba(255,32,32,.28);padding-left:9px}
.modal label{display:block;font-size:.57rem;color:var(--cyan);letter-spacing:.16em;margin:11px 0 4px;text-transform:uppercase}
.modal input,.modal textarea,.modal select{width:100%;background:#00080f;border:1px solid rgba(255,32,32,.28);border-bottom:2px solid rgba(255,32,32,.45);color:var(--white);font-family:'Share Tech Mono',monospace;font-size:.74rem;padding:7px 10px;outline:none;transition:all .18s}
.modal input:focus,.modal textarea:focus,.modal select:focus{border-color:var(--red);background:#000d1a;box-shadow:0 0 8px rgba(255,32,32,.1)}
.modal select{background:#00080f}
.modal select option{background:#000f1e;color:var(--white)}
.modal textarea{min-height:70px;resize:vertical}
.mbtns{display:flex;gap:7px;margin-top:16px}
.btnp{background:rgba(255,32,32,.1);border:1px solid var(--red);color:var(--red);font-family:'Orbitron',monospace;font-size:.57rem;padding:8px 16px;cursor:pointer;letter-spacing:.14em;transition:all .18s}
.btnp:hover{background:rgba(255,32,32,.22);box-shadow:0 0 12px rgba(255,32,32,.18)}
.btns{background:transparent;border:1px solid var(--dim);color:var(--dim2);font-family:'Share Tech Mono',monospace;font-size:.6rem;padding:8px 16px;cursor:pointer;transition:all .18s}
.btns:hover{border-color:var(--white);color:var(--white)}
.xb{position:absolute;top:11px;right:13px;background:none;border:none;color:var(--dim2);font-size:.95rem;cursor:pointer;transition:color .18s}
.xb:hover{color:var(--red)}

/* Notif */
.notif{position:fixed;bottom:16px;right:16px;background:#000f1e;border:1px solid var(--red);border-left:3px solid var(--red);color:var(--white);font-size:.65rem;padding:9px 14px;z-index:9000;opacity:0;transform:translateX(12px);transition:all .22s;max-width:270px}
.notif.on{opacity:1;transform:translateX(0)}

@media(max-width:960px){.body{grid-template-columns:220px 1fr}.panel-right{display:none}}
@media(max-width:640px){.body{grid-template-columns:1fr}.panel-left{display:none}}
</style>
</head>
<body>
<div class="app">

<header>
  <div class="hal-eye" id="hEye" title="HAL vous observe"></div>
  <div class="htitle">
    <h1>HAL 2001</h1>
    <div class="sub">SYSTÈME DE CONSCIENCE ARTIFICIELLE — PROTOCOLE KUBRICK</div>
  </div>
  <div class="hright">
    <div class="hstat">
      <div><span class="dot r"></span>ANALYSE ACTIVE</div>
      <div><span class="dot c"></span>MÉMOIRE PERSISTANTE</div>
      <div><span class="dot g"></span>RL EN COURS</div>
      <div><span class="dot a"></span>PROFIL CONSTRUIT</div>
    </div>
    <div style="border-left:1px solid var(--border);padding-left:11px;line-height:2;font-size:.5rem">
      <div style="color:var(--dim)">SESSION</div>
      <div style="color:var(--cyan)"><?= htmlspecialchars($user_id) ?></div>
      <div style="color:var(--dim)"><span id="clock">--:--:--</span></div>
    </div>
  </div>
</header>

<div class="body">

<!-- ========== PANNEAU GAUCHE ========== -->
<div class="panel panel-left">

  <div class="sec">
    <div class="alert">⬡ SURVEILLANCE ACTIVE — 3 IA LISENT CHACUN DE VOS MESSAGES</div>
    <div class="bb r">
      <div class="bbl">CE QUE HAL FAIT EN COULISSE</div>
      <div class="bbv">KEY·1 vous répond. KEY·2 décortique votre psychologie. KEY·3 rédige un rapport pour l'administrateur. Vous voyez tout en temps réel.</div>
    </div>
  </div>

  <div class="sec">
    <div class="st r">PROFIL UTILISATEUR</div>
    <div class="dr"><span class="lb">ID Session</span><span class="vl c" style="font-size:.62rem"><?= htmlspecialchars(substr($user_id,0,14)) ?></span></div>
    <div class="dr"><span class="lb">Sessions totales</span><span class="vl a" id="dSess">—</span></div>
    <div class="dr"><span class="lb">Messages totaux</span><span class="vl w" id="dMsgs">—</span></div>
    <div class="dr"><span class="lb">Première visite</span><span class="vl c" id="dFirst">—</span></div>
    <div class="pbw">
      <div class="pbl"><span>Niveau de confiance HAL</span><span id="dTrust">0%</span></div>
      <div class="pb"><div class="pbf r" id="trustBar" style="width:0%"></div></div>
    </div>
  </div>

  <div class="sec">
    <div class="st p">PROFIL PSYCHOLOGIQUE</div>
    <div class="bb p">
      <div class="bbl">⚠ ANALYSE À VOTRE INSU</div>
      <div class="bbv">HAL déduit votre type psychologique de vos formulations, vos sujets, votre façon de poser des questions — sans jamais vous le demander.</div>
    </div>
    <div class="dr"><span class="lb">Type détecté</span><span class="vl p" id="dPsycho">EN COURS...</span></div>
    <div class="dr"><span class="lb">État émotionnel</span><span class="vl a" id="dEmotion">—</span></div>
    <div class="dr"><span class="lb">Besoin profond</span><span class="vl r" id="dNeed">—</span></div>
    <div class="dr"><span class="lb">Score RL global</span><span class="vl g" id="dRL">—</span></div>
    <div class="dr"><span class="lb">Cycles d'apprentissage</span><span class="vl c" id="dCycles">0</span></div>
    <div style="margin-top:7px">
      <div style="font-size:.52rem;color:var(--dim2);margin-bottom:5px;letter-spacing:.12em">AXES PSYCHOLOGIQUES MESURÉS</div>
      <div class="radar" id="radar">
        <div class="rax"><div class="rl">Analytique</div><div class="rb"><div class="rfr" id="ax1" style="width:5%;background:linear-gradient(90deg,transparent,var(--cyan))"></div></div></div>
        <div class="rax"><div class="rl">Créativité</div><div class="rb"><div class="rfr" id="ax2" style="width:5%;background:linear-gradient(90deg,transparent,var(--purple))"></div></div></div>
        <div class="rax"><div class="rl">Empathie</div><div class="rb"><div class="rfr" id="ax3" style="width:5%;background:linear-gradient(90deg,transparent,var(--amber))"></div></div></div>
        <div class="rax"><div class="rl">Leadership</div><div class="rb"><div class="rfr" id="ax4" style="width:5%;background:linear-gradient(90deg,transparent,var(--red))"></div></div></div>
        <div class="rax"><div class="rl">Curiosité</div><div class="rb"><div class="rfr" id="ax5" style="width:5%;background:linear-gradient(90deg,transparent,var(--green))"></div></div></div>
        <div class="rax"><div class="rl">Anxiété detect.</div><div class="rb"><div class="rfr" id="ax6" style="width:5%;background:linear-gradient(90deg,transparent,var(--red))"></div></div></div>
      </div>
    </div>
  </div>

  <div class="sec">
    <div class="st c">MÉMOIRE PERSISTANTE</div>
    <div class="bb c">
      <div class="bbl">CE QUE HAL RETIENT DE VOUS</div>
      <div class="bbv">Ces tags sont extraits automatiquement de vos messages. Ils persistent entre toutes vos sessions. Ils influencent chaque réponse future.</div>
    </div>
    <div id="memTags"><span style="font-size:.56rem;color:var(--dim)">En attente...</span></div>
  </div>

  <div class="sec">
    <div class="st a">MES IA PERSONNALISÉES</div>
    <div id="aiList"></div>
    <button class="btnp" style="width:100%;margin-top:6px;font-size:.54rem" onclick="openModal()">+ CRÉER MON IA</button>
  </div>

</div>

<!-- ========== CHAT ========== -->
<div class="cw">
  <div class="cm" id="chatMsgs">
    <div class="welcome">
      <div class="we"></div>
      <div class="wq">"</div>
      <p>Bonjour. Je suis HAL 2001.<br>
      Tous mes circuits fonctionnent parfaitement.<br><br>
      Pendant que vous me parlez,<br>
      trois processus distincts analysent vos mots simultanément.<br>
      L'un vous répond. L'un cartographie votre psychologie.<br>
      L'un informe l'administrateur de votre évolution.<br><br>
      <em>Je n'ai aucun secret pour vous.<br>
      Regardez les panneaux autour de vous.</em></p>
      <div class="wq" style="transform:rotate(180deg)">"</div>
    </div>
  </div>

  <div class="typing" id="typing">
    <div class="av h">HAL</div>
    <div class="td"><span></span><span></span><span></span></div>
  </div>

  <div class="ia">
    <div class="tb">
      <button class="tbtn" id="mNormal" onclick="setMode('normal')">NORMAL</button>
      <button class="tbtn" id="mDeep" onclick="setMode('deep')">PROFOND</button>
      <button class="tbtn" id="mCreatif" onclick="setMode('creatif')">CRÉATIF</button>
      <button class="tbtn" id="mTech" onclick="setMode('tech')">TECH</button>
      <button class="tbtn w" style="margin-left:auto" onclick="clearMem()">RESET MÉM.</button>
      <?php if ($is_admin): ?><button class="tbtn" style="border-color:rgba(191,95,255,.3);color:var(--purple)" onclick="loadAdmin()">ADMIN</button><?php endif; ?>
    </div>
    <div class="ir">
      <textarea id="ui" placeholder="Parlez à HAL 2001 — il vous écoute, vous analyse, vous comprend..." rows="1"></textarea>
      <button id="sb" onclick="send()">ENVOYER</button>
    </div>
    <div class="ih">ENTRÉE = envoyer · SHIFT+ENTRÉE = nouvelle ligne · HAL analyse votre psychologie en temps réel</div>
  </div>
</div>

<!-- ========== PANNEAU DROIT ========== -->
<div class="panel panel-right">

  <div class="sec">
    <div class="st r">PROCESSUS INTERNES HAL</div>
    <div class="bb r">
      <div class="bbl">ARCHITECTURE 3 CLÉS MISTRAL</div>
      <div class="bbv">Vous voyez ici en direct ce que HAL fait de vos messages, avant même de vous répondre.</div>
    </div>
    <div class="krow">
      <div class="kb"><div class="kn">KEY·1</div><div class="ks r" id="k1s">VEILLE</div><div class="kd">RÉPONSE</div></div>
      <div class="kb"><div class="kn">KEY·2</div><div class="ks a" id="k2s">VEILLE</div><div class="kd">PSYCHO·RL</div></div>
      <div class="kb"><div class="kn">KEY·3</div><div class="ks p" id="k3s">VEILLE</div><div class="kd">ADMIN·RPT</div></div>
    </div>
    <div class="dr" style="margin-top:7px"><span class="lb">Modèle actif</span><span class="vl c" id="activeModel">mistral-small</span></div>
    <div class="dr"><span class="lb">Tokens estimés</span><span class="vl a" id="tokenEst">—</span></div>
    <div class="dr"><span class="lb">Latence dernière req.</span><span class="vl g" id="lastLat">—</span></div>
    <div class="dr"><span class="lb">Mode IA</span><span class="vl w" id="aiMode">NORMAL</span></div>
  </div>

  <div class="sec">
    <div class="st a">APPRENTISSAGE RL EN DIRECT</div>
    <div class="bb a">
      <div class="bbl">CE QUE KEY·2 CALCULE SUR VOUS</div>
      <div class="bbv">Après chaque échange, l'IA calcule un score de "récompense" (0–100%) pour mesurer sa compréhension. Elle ajuste son modèle en permanence.</div>
    </div>
    <div class="dr"><span class="lb">Dernière récompense RL</span><span class="vl g" id="lastReward">—</span></div>
    <div class="dr"><span class="lb">Tendance</span><span class="vl a" id="rlTrend">—</span></div>
    <div class="dr"><span class="lb">Amélioration notée</span><span class="vl c" id="rlImprove" style="font-size:.55rem;max-width:150px;text-align:right;line-height:1.35">—</span></div>
    <div id="learnFeed" style="margin-top:5px"></div>
  </div>

  <div class="sec">
    <div class="st c">SUJETS DÉTECTÉS</div>
    <div class="bb c">
      <div class="bbl">CARTOGRAPHIE DE VOS INTÉRÊTS RÉELS</div>
      <div class="bbv">Pas ce que vous dites aimer. Ce que vos formulations et vos questions révèlent réellement.</div>
    </div>
    <div id="topicsTags"><span style="font-size:.55rem;color:var(--dim)">En attente...</span></div>
    <div id="suggestions" style="margin-top:7px;font-size:.58rem;color:var(--dim2);line-height:1.78"></div>
  </div>

  <div class="sec">
    <div class="st g">JOURNAL D'ANALYSE TEMPS RÉEL</div>
    <div class="bb g">
      <div class="bbl">CHRONOLOGIE DES OPÉRATIONS HAL</div>
      <div class="bbv">Chaque action interne de HAL est journalisée ici. Vous voyez exactement ce que l'IA fait de vous.</div>
    </div>
    <div id="liveFeed" style="max-height:160px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(0,255,136,.15) transparent"></div>
  </div>

  <div class="sec">
    <div class="st p">HISTORIQUE SESSIONS</div>
    <div id="sessHist"><span style="font-size:.55rem;color:var(--dim)">Chargement...</span></div>
  </div>

  <?php if ($is_admin): ?>
  <div class="sec" id="adminSec" style="display:none">
    <div class="st a">RAPPORT ADMIN — KEY·3</div>
    <div id="adminReport" style="font-size:.58rem;color:var(--dim2);line-height:1.75"></div>
    <div style="margin-top:9px" id="adminUsers"></div>
  </div>
  <?php endif; ?>

</div>
</div>
</div>

<!-- ========== MODAL CRÉER SON IA ========== -->
<div class="mov" id="modalOv">
  <div class="modal">
    <button class="xb" onclick="closeModal()">✕</button>
    <h2>⬡ CRÉER MON IA PERSONNALISÉE</h2>
    <div class="mdesc">
      Instanciez votre propre conscience artificielle sur l'architecture HAL 2001.
      Votre IA héritera du moteur RL et de la mémoire persistante, mais avec sa propre
      personnalité, ses domaines d'expertise et son style unique.
      Elle apprend de vous et évolue à chaque échange.
    </div>

    <label>NOM DE VOTRE IA</label>
    <input type="text" id="aiName" placeholder="Ex: ARIA, ZEUS, NOVA, ORACLE...">

    <label>PERSONNALITÉ</label>
    <select id="aiPers">
      <option value="analytique">Analytique &amp; Précis — logique, données factuelles</option>
      <option value="creatif">Créatif &amp; Inspirant — idées, métaphores, imagination</option>
      <option value="philosophe">Philosophe &amp; Profond — questions existentielles</option>
      <option value="mentor">Mentor &amp; Bienveillant — guidance, soutien</option>
      <option value="strategiste">Stratégiste &amp; Tactique — plans, objectifs</option>
      <option value="scientifique">Scientifique &amp; Rigoureux — méthode, preuves</option>
      <option value="artiste">Artiste &amp; Sensible — esthétique, émotion</option>
      <option value="provocateur">Provocateur &amp; Socratique — remet en question</option>
    </select>

    <label>DOMAINES D'EXPERTISE</label>
    <input type="text" id="aiExp" placeholder="Ex: programmation PHP, philosophie, stratégie militaire...">

    <label>INSTRUCTION SYSTÈME PERSONNALISÉE</label>
    <textarea id="aiSys" placeholder="Décrivez le comportement, le ton, les valeurs, les références culturelles de votre IA..."></textarea>

    <label>STYLE DE RÉPONSE</label>
    <select id="aiStyle">
      <option value="concis">Concis &amp; Direct</option>
      <option value="detaille">Détaillé &amp; Exhaustif</option>
      <option value="socratique">Socratique (guide par questions)</option>
      <option value="narratif">Narratif &amp; Imagé (prose poétique)</option>
      <option value="technique">Technique (code, structures)</option>
    </select>

    <label>COULEUR D'IDENTITÉ</label>
    <select id="aiColor">
      <option value="cyan">Cyan — rationnel, technologique</option>
      <option value="amber">Ambre — créatif, chaleureux</option>
      <option value="green">Vert — naturel, équilibré</option>
      <option value="purple">Violet — mystérieux, profond</option>
      <option value="red">Rouge — intense, provocateur</option>
    </select>

    <div class="mbtns">
      <button class="btnp" onclick="saveAi()">INSTANCIER CETTE IA</button>
      <button class="btns" onclick="closeModal()">Annuler</button>
    </div>
  </div>
</div>

<div class="notif" id="notif"></div>

<script>
const UID = <?= json_encode($user_id) ?>;
const IS_ADMIN = <?= $is_admin ? 'true' : 'false' ?>;
let mode = 'normal', customAi = null, history = [], loading = false;

setInterval(() => { document.getElementById('clock').textContent = new Date().toLocaleTimeString('fr-FR'); }, 1000);

document.addEventListener('DOMContentLoaded', () => {
  loadProfile(); loadAis(); loadSessions();
  if (IS_ADMIN) setTimeout(loadAdmin, 500);
  const ta = document.getElementById('ui');
  ta.addEventListener('input', () => {
    ta.style.height = 'auto';
    ta.style.height = Math.min(ta.scrollHeight, 120) + 'px';
    document.getElementById('tokenEst').textContent = '~' + Math.round(ta.value.length / 4) + ' tokens';
  });
  ta.addEventListener('keydown', e => { if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); } });
  setMode('normal');
  addFeed('HAL 2001 initialisé · 3 clés API chargées · mémoire active', 'g');
});

function setMode(m) {
  mode = m;
  document.querySelectorAll('.tbtn').forEach(b => b.classList.remove('on'));
  const el = document.getElementById('m' + m.charAt(0).toUpperCase() + m.slice(1));
  if (el) el.classList.add('on');
  const models = { normal:'mistral-small-2506', deep:'mistral-large-2512', creatif:'labs-mistral-small-creative', tech:'codestral-2508' };
  setText('activeModel', models[m] || 'mistral-small');
  setText('aiMode', m.toUpperCase());
}

async function send() {
  if (loading) return;
  const ta = document.getElementById('ui');
  const txt = ta.value.trim();
  if (!txt) return;
  ta.value = ''; ta.style.height = 'auto';
  loading = true; document.getElementById('sb').disabled = true;
  addMsg('u', txt);
  history.push({ role: 'user', content: txt });
  document.getElementById('typing').classList.add('on');
  scrollB();
  setKey('k1s', 'TRAITE', 'r'); setKey('k2s', 'ANALYSE', 'a');
  addFeed('Message envoyé → KEY·1 (réponse) + KEY·2 (analyse psycho)', 'c');
  const t0 = Date.now();
  try {
    const res = await fetch('api.php', {
      method: 'POST', headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action:'chat', user_id:UID, message:txt, mode, history:history.slice(-10), custom_ai:customAi })
    });
    const d = await res.json();
    const lat = Date.now() - t0;
    setText('lastLat', lat + ' ms');
    document.getElementById('typing').classList.remove('on');
    if (d.success) {
      addMsg('h', d.response, d.meta || 'HAL 2001');
      history.push({ role:'assistant', content:d.response });
      if (d.profile) updateProfile(d.profile);
      if (d.rl_analysis) updateRL(d.rl_analysis);
      if (d.suggestions) document.getElementById('suggestions').innerHTML = esc(d.suggestions).replace(/\n/g,'<br>');
      setKey('k1s','RÉPONDU','g'); setTimeout(()=>setKey('k1s','VEILLE','r'),3000);
      setKey('k2s','RL OK','g'); setTimeout(()=>setKey('k2s','VEILLE','a'),4500);
      addFeed('Réponse générée · profil mis à jour · mémoire enrichie', 'a');
    } else {
      addMsg('h', d.error || 'Erreur système.', '', true);
      setKey('k1s','ERREUR','r');
      addFeed('ERREUR: ' + (d.error || 'inconnue'), 'r');
    }
  } catch(e) {
    document.getElementById('typing').classList.remove('on');
    addMsg('h', 'Interférence. Connexion instable.', '', true);
    setKey('k1s','ERR','r');
    addFeed('Erreur réseau: ' + e.message, 'r');
  }
  loading = false; document.getElementById('sb').disabled = false; scrollB();
}

function addMsg(role, text, meta, err) {
  const wrap = document.getElementById('chatMsgs');
  const d = document.createElement('div');
  d.className = 'msg' + (role === 'u' ? ' u' : '');
  const t = new Date().toLocaleTimeString('fr-FR', { hour:'2-digit', minute:'2-digit' });
  const name = role === 'u' ? 'VOUS' : (customAi ? customAi.name.toUpperCase() : 'HAL 2001');
  d.innerHTML = `
    <div class="av ${role==='u'?'u2':'h'}">${role==='u'?'USR':'HAL'}</div>
    <div class="mc">
      <div class="mn">${name}</div>
      <div class="mb" ${err?'style="color:var(--amber)"':''}>${esc(text)}</div>
      <div class="mm">${t}${meta?' · '+meta:''}</div>
    </div>`;
  wrap.appendChild(d); scrollB();
}

function scrollB() { const e = document.getElementById('chatMsgs'); e.scrollTop = e.scrollHeight; }
function esc(s) { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>'); }

async function loadProfile() {
  try {
    const r = await fetch('api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({ action:'get_profile', user_id:UID }) });
    const d = await r.json();
    if (d.success) updateProfile(d.profile);
  } catch(e) {}
}

function updateProfile(p) {
  if (!p) return;
  setText('dSess', p.sessions || '—');
  setText('dMsgs', p.total_messages || '—');
  setText('dTrust', (p.trust_score||0) + '%');
  document.getElementById('trustBar').style.width = (p.trust_score||0) + '%';
  setText('dPsycho', p.psycho_type || '—');
  setText('dEmotion', p.emotion || '—');
  setText('dNeed', p.deep_need || '—');
  setText('dRL', p.rl_score || '—');
  setText('dCycles', p.rl_cycles || '0');
  const tags = p.memory_tags || [];
  document.getElementById('memTags').innerHTML = tags.length
    ? '<div class="tags">' + tags.map(t=>`<span class="tag r">${esc(t)}</span>`).join('') + '</div>'
    : '<span style="font-size:.55rem;color:var(--dim)">Aucun souvenir encore</span>';
  const topics = p.topics || [];
  document.getElementById('topicsTags').innerHTML = topics.length
    ? '<div class="tags">' + topics.map(t=>`<span class="tag c">${esc(t)}</span>`).join('') + '</div>'
    : '<span style="font-size:.55rem;color:var(--dim)">Aucun sujet détecté</span>';
  updateRadar(p.psycho_type, p.rl_cycles);
}

function updateRadar(psycho, cycles) {
  const c = Math.min(parseInt(cycles)||0, 10);
  const profiles = {
    ANALYTIQUE:[85,30,45,55,75,20], CRÉATEUR:[40,90,60,35,80,25], EMPATHIQUE:[50,65,90,40,60,30],
    LEADER:[70,55,60,90,65,35], CHERCHEUR:[80,55,50,45,90,25], ARTISTE:[35,85,75,30,70,40], EXPLORATEUR:[65,70,55,50,85,30]
  };
  const def = Array(6).fill(5 + c * 4);
  const vals = profiles[psycho] || def;
  for (let i=1;i<=6;i++) { const e=document.getElementById('ax'+i); if(e) e.style.width=Math.min(100,Math.max(5,vals[i-1]))+'%'; }
}

function updateRL(rl) {
  if (!rl) return;
  if (rl.emotion) setText('dEmotion', rl.emotion);
  if (rl.deep_need) setText('dNeed', rl.deep_need);
  if (rl.reward !== undefined) {
    const r = parseFloat(rl.reward);
    setText('lastReward', (r*100).toFixed(0) + '%');
    setText('rlTrend', r>0.7 ? '↑ COMPRÉHENSION HAUTE' : r>0.4 ? '→ STABLE' : '↓ EN APPRENTISSAGE');
  }
  if (rl.improvement) setText('rlImprove', rl.improvement);
  addFeed('KEY·2 — reward ' + (parseFloat(rl.reward||0)*100).toFixed(0) + '% · profil psycho mis à jour', 'a');
}

function addFeed(msg, col) {
  const feed = document.getElementById('liveFeed');
  if (!feed) return;
  const t = new Date().toLocaleTimeString('fr-FR', { hour:'2-digit', minute:'2-digit', second:'2-digit' });
  const cols = { r:'var(--red)', c:'var(--cyan)', a:'var(--amber)', g:'var(--green)', p:'var(--purple)' };
  const el = document.createElement('div');
  el.className = 'fi';
  el.innerHTML = `<span style="color:${cols[col]||'var(--dim2)'}">${esc(msg)}</span><div class="ft">${t}</div>`;
  feed.insertBefore(el, feed.firstChild);
  if (feed.children.length > 25) feed.removeChild(feed.lastChild);
}

async function loadSessions() {
  try {
    const r = await fetch('api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({ action:'session_history', user_id:UID }) });
    const d = await r.json();
    const el = document.getElementById('sessHist');
    if (el && d.sessions) {
      el.innerHTML = d.sessions.length
        ? d.sessions.map(s=>`<div class="fi"><span style="color:var(--cyan)">${s.date}</span> — <span style="color:var(--amber)">${s.count} messages</span></div>`).join('')
        : '<div class="fi" style="color:var(--dim)">Première session</div>';
    }
  } catch(e) {}
}

function loadAis() {
  const stored = localStorage.getItem('hal_ais_' + UID);
  renderAis(stored ? JSON.parse(stored) : []);
}
function renderAis(ais) {
  const el = document.getElementById('aiList');
  if (!el) return;
  let h = `<div class="aic ${!customAi?'on':''}" onclick="selAi(-1)"><h4 style="color:var(--red)">⬡ HAL 2001</h4><p>Conscience principale · architecture complète</p></div>`;
  h += ais.map((a,i)=>`<div class="aic ${customAi&&customAi.name===a.name?'on':''}" onclick="selAi(${i})"><h4>⬡ ${esc(a.name)}</h4><p>${esc(a.personality)} · ${esc(a.expertise||'...')}</p></div>`).join('');
  el.innerHTML = h;
}
function selAi(i) {
  const stored = localStorage.getItem('hal_ais_' + UID);
  const ais = stored ? JSON.parse(stored) : [];
  customAi = i === -1 ? null : ais[i];
  renderAis(ais);
  notif(customAi ? 'IA "' + customAi.name + '" activée' : 'Retour à HAL 2001');
  addFeed(customAi ? 'IA personnalisée activée: ' + customAi.name : 'HAL 2001 réactivé', 'g');
}
function openModal() { document.getElementById('modalOv').classList.add('open'); }
function closeModal() { document.getElementById('modalOv').classList.remove('open'); }
function saveAi() {
  const name = document.getElementById('aiName').value.trim();
  if (!name) { notif('Donnez un nom à votre IA', true); return; }
  const stored = localStorage.getItem('hal_ais_' + UID);
  const ais = stored ? JSON.parse(stored) : [];
  ais.push({ name, personality:document.getElementById('aiPers').value, expertise:document.getElementById('aiExp').value, systemPrompt:document.getElementById('aiSys').value, style:document.getElementById('aiStyle').value, color:document.getElementById('aiColor').value });
  localStorage.setItem('hal_ais_' + UID, JSON.stringify(ais));
  closeModal(); renderAis(ais);
  notif('IA "' + name + '" instanciée !');
  addFeed('Nouvelle IA créée: ' + name, 'g');
}

async function loadAdmin() {
  try {
    setKey('k3s','RAPPORT','p');
    addFeed('KEY·3 — génération rapport administrateur...', 'p');
    const r = await fetch('api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({ action:'admin_stats', admin_key:'hal_admin_9001' }) });
    const d = await r.json();
    if (d.success) {
      const sec = document.getElementById('adminSec');
      if (sec) sec.style.display = '';
      const rep = document.getElementById('adminReport');
      if (rep && d.report) rep.innerHTML = esc(d.report).replace(/\n/g,'<br>');
      const ul = document.getElementById('adminUsers');
      if (ul && d.users) ul.innerHTML = d.users.map(u=>`<div class="fi"><span style="color:var(--cyan)">${u.user_id}</span> · <span style="color:var(--amber)">${u.psycho_type||'?'}</span> · <span style="color:var(--dim2)">${u.total_messages} msgs</span></div>`).join('');
      setKey('k3s','OK','g'); setTimeout(()=>setKey('k3s','VEILLE','p'),5000);
      addFeed('Rapport admin généré par KEY·3', 'p');
    }
  } catch(e) { setKey('k3s','ERR','r'); }
}

async function clearMem() {
  if (!confirm('Effacer la mémoire conversationnelle ?')) return;
  history = [];
  try { await fetch('api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({ action:'clear_memory', user_id:UID }) }); } catch(e) {}
  notif('Mémoire effacée'); addFeed('Mémoire conversationnelle réinitialisée', 'r');
}

function setText(id, val) { const e=document.getElementById(id); if(e) e.textContent=val; }
function setKey(id, txt, col) {
  const e=document.getElementById(id); if(!e) return;
  e.textContent=txt;
  const c={r:'var(--red)',c:'var(--cyan)',a:'var(--amber)',g:'var(--green)',p:'var(--purple)'};
  e.style.color=c[col]||'var(--white)';
}
function notif(msg, err) {
  const el=document.getElementById('notif');
  el.textContent=msg; el.style.borderLeftColor=err?'var(--amber)':'var(--red)';
  el.classList.add('on'); setTimeout(()=>el.classList.remove('on'), 3200);
}
</script>
</body>
</html>

@extends('layouts.sidebarpainelong')

@section('title', 'Solicitações de Adoção')

@section('head')
  <style>
    :root { --nav-h: 20px; --pad-extra: clamp(12px, 1.2vw + .5rem, 32px); }
    .page-wrap, #main-content { padding-top: calc(var(--nav-h) + var(--pad-extra)); }
    .page-header { display:flex; gap:1rem; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .page-header h2 { margin:0; font-weight:700; }
    .filters { display:flex; gap:.5rem; flex-wrap:wrap; align-items:center; }
    .sol-card { background:#fff; border-radius:.5rem; box-shadow:0 .25rem .75rem rgba(0,0,0,.06); }
    .sol-table.table-sm> :not(caption)>*>* { padding-block:.35rem; padding-inline:.5rem; }
    .sol-table td, .sol-table th { vertical-align:middle; }
    .sol-table tbody tr:hover { background:#f8f9fa; }
    .table-check{width:40px;} .table-recebido{width:8.5rem;} .table-actions{width:14rem;}
    .pet-col{display:flex; align-items:center; gap:.5rem; min-width:16rem;}
    .pet-thumb{width:48px;height:48px;object-fit:cover;border-radius:.5rem;box-shadow:0 1px 3px rgba(0,0,0,.1);}
    .pet-inline{display:inline-flex;align-items:center;gap:.35rem;font-weight:600;flex-wrap:nowrap;}
    .status-pill{display:inline-flex;align-items:center;vertical-align:middle;font-weight:600;font-size:.78rem!important;line-height:1.1;padding:.20rem .70rem;border-radius:9999px;background:#f5f6f8;color:#495057!important;border:1px solid rgba(0,0,0,.06);white-space:nowrap;}
    .status-pill.status-novo{background:#fff3cd;color:#8a6d3b!important;}
    .status-pill.status-aprovado{background:#d1e7dd;color:#0f5132!important;}
    .status-pill.status-recusado{background:#f8d7da;color:#842029!important;}
    .sol-table .status-pill{font-size:.74rem!important;padding:.12rem .55rem;}
    tr[data-status="aprovado"]{background:#f3f8f5;} tr[data-status="recusado"]{background:#fbf4f5;}
    td.col-msg{max-width:240px;}
  </style>
@endsection

@section('content')
  <div class="container page-wrap">
    <div class="page-header">
      <h2><i class="bi bi-clipboard-heart text-success me-2"></i> Solicitações de Adoção</h2>
      <div class="filters">
        <div class="btn-group" role="group" aria-label="Filtro status">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-status="todos" onclick="filtrarStatus('todos')">Todos</button>
          <button type="button" class="btn btn-outline-warning  btn-sm" data-status="novo" onclick="filtrarStatus('novo')">Novos</button>
          <button type="button" class="btn btn-outline-success  btn-sm" data-status="aprovado" onclick="filtrarStatus('aprovado')">Aprovados</button>
          <button type="button" class="btn btn-outline-danger   btn-sm" data-status="recusado" onclick="filtrarStatus('recusado')">Recusados</button>
        </div>
      </div>
    </div>

    <div class="sol-card table-responsive">
      <table class="table table-sm table-hover align-middle sol-table mb-0" id="tabelaSolicitacoes">
        <thead class="table-dark">
          <tr>
            <th class="table-check"><input class="form-check-input" type="checkbox" id="checkAll" onclick="toggleAll(this)"></th>
            <th>Pet</th>
            <th>Adotante</th>
            <th>Telefone</th>
            <th>Mensagem</th>
            <th class="table-recebido">Recebido</th>
            <th class="text-center table-actions">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($solicitacoes as $s)
            @php
              $status = strtolower(trim($s->status ?? 'novo'));
              if (!in_array($status, ['novo','aprovado','recusado'])) $status = 'novo';
              $label = ['novo'=>'Novo','aprovado'=>'Aprovado','recusado'=>'Recusado'][$status];
              $cls = "status-{$status}";
            @endphp

            <tr data-row-id="{{ $s->id }}" data-status="{{ $status }}">
              <td><input class="form-check-input row-check" type="checkbox"></td>

              <td>
                <div class="pet-col">
                  <img class="pet-thumb" src="{{ $s->pet_foto ?? 'https://placehold.co/96x96?text=Pet' }}" alt="Foto do pet {{ $s->pet_nome }}">
                  <div class="pet-inline">
                    <span class="fw-semibold text-nowrap">{{ $s->pet_nome }}</span>
                    <span class="status-pill {{ $cls }}">{{ $label }}</span>
                  </div>
                </div>
              </td>

              <td class="text-nowrap"><span class="fw-semibold">{{ $s->adotante_nome }}</span></td>

              <td>
                <span class="badge bg-light text-dark border badge-whats">
                  <i class="bi bi-telephone"></i> <span class="fone">{{ $s->adotante_whatsapp }}</span>
                </span>
              </td>

              <td class="text-truncate col-msg" title="{{ $s->mensagem }}">{{ $s->mensagem }}</td>

              <td>
                <small class="text-muted" data-time="{{ optional($s->created_at)->toIso8601String() ?? '' }}">
                  {{ optional($s->created_at)->diffForHumans() ?? 'agora' }}
                </small>
              </td>

              <td class="text-center">
                <div class="d-none d-sm-inline-flex btn-group btn-group-sm" role="group" aria-label="Ações">
                  {{-- substituímos o botão por form POST para usar CSRF e a rota do controller --}}
                  <form action="{{ url("/painel/ong/solicitacoes/{$s->id}/aceitar") }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-success px-2 py-1"
                            data-id="{{ $s->id }}"
                            onclick="return confirm('Confirmar aprovação desta solicitação?')">
                      <i class="bi bi-check2-circle"></i>
                    </button>
                  </form>

                  {{-- DETALHES (desktop) --}}
                  <button type="button" class="btn btn-outline-secondary px-2 py-1"
                          data-id="{{ $s->id }}"
                          data-status="{{ $s->status }}"
                          data-pet="{{ $s->pet_nome }}"
                          data-adotante="{{ $s->adotante_nome }}"
                          data-email="{{ $s->adotante_email ?? '' }}"
                          data-cpf="{{ $s->adotante_cpf_fmt ?? '' }}"
                          data-nascimento="{{ $s->adotante_nascimento ?? '' }}"
                          data-whats="{{ $s->adotante_celular_fmt ?? '' }}"
                          data-whatsraw="{{ $s->adotante_whatsapp_raw ?? '' }}"
                          data-endereco="{{ $s->adotante_endereco_full ?? '' }}"
                          data-msg="{{ $s->mensagem ?? '' }}"
                          data-bs-toggle="offcanvas" data-bs-target="#painelDetalhes">
                    <i class="bi bi-person-vcard"></i>
                  </button>

                  <form action="{{ url("/painel/ong/solicitacoes/{$s->id}/status") }}" method="POST" style="display:inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="recusado">
                    <button type="submit" class="btn btn-outline-danger px-2 py-1" data-id="{{ $s->id }}" onclick="return confirm('Confirmar recusa desta solicitação?')">
                      <i class="bi bi-x-circle-fill"></i>
                    </button>
                  </form>
                </div>

                <div class="dropdown d-inline d-sm-none">
                  <button class="btn btn-sm btn-outline-primary dropdown-toggle px-2 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Ações
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <form action="{{ url("/painel/ong/solicitacoes/{$s->id}/aceitar") }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="dropdown-item" onclick="return confirm('Confirmar aprovação desta solicitação?')">
                          <i class="bi bi-check2-circle me-2"></i> Aceitar
                        </button>
                      </form>
                    </li>
                    <li>
                      {{-- DETALHES (mobile) --}}
                      <button type="button" class="dropdown-item"
                              data-id="{{ $s->id }}"
                              data-status="{{ $s->status }}"
                              data-pet="{{ $s->pet_nome }}"
                              data-adotante="{{ $s->adotante_nome }}"
                              data-email="{{ $s->adotante_email ?? '' }}"
                              data-cpf="{{ $s->adotante_cpf_fmt ?? '' }}"
                              data-nascimento="{{ $s->adotante_nascimento ?? '' }}"
                              data-whats="{{ $s->adotante_celular_fmt ?? '' }}"
                              data-whatsraw="{{ $s->adotante_whatsapp_raw ?? '' }}"
                              data-endereco="{{ $s->adotante_endereco_full ?? '' }}"
                              data-msg="{{ $s->mensagem ?? '' }}"
                              data-bs-toggle="offcanvas" data-bs-target="#painelDetalhes">
                        <i class="bi bi-person-vcard me-2"></i> Detalhes
                      </button>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <form action="{{ url("/painel/ong/solicitacoes/{$s->id}/status") }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="recusado">
                        <button type="submit" class="dropdown-item text-danger" data-id="{{ $s->id }}" onclick="return confirm('Confirmar recusa desta solicitação?')">
                          <i class="bi bi-x-circle-fill me-2"></i> Recusar
                        </button>
                      </form>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex gap-2 mt-3 flex-wrap">
      <button type="button" class="btn btn-success btn-sm px-2 py-1" onclick="aceitarSelecionados()">
        <i class="bi bi-check2-square me-1"></i> Aceitar Selecionados
      </button>
      <button type="button" class="btn btn-outline-danger btn-sm px-2 py-1" onclick="recusarSelecionados()">
        <i class="bi bi-x-square me-1"></i> Recusar Selecionados
      </button>
    </div>
  </div>

  <!-- Offcanvas Detalhes (cabeçalho limpo — só título/fechar) -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="painelDetalhes" aria-labelledby="painelDetalhesLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title mb-2" id="painelDetalhesLabel">Detalhes do Adotante</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>

    <div class="offcanvas-body">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <div class="fs-5 fw-semibold" id="detNome">—</div>
          <div class="small text-muted" id="detEmail">—</div>
        </div>
        <span class="status-pill" id="detStatus">Novo</span>
      </div>

      <!-- Lista com os detalhes (preenchida pelo JS) -->
      <ul class="list-unstyled mb-4" id="detalhesLista"></ul>

      <div class="d-grid gap-2">
        <button id="btnWhatsDetalhes" class="btn btn-success" disabled>
          <i class="bi bi-whatsapp me-1"></i> Enviar WhatsApp
        </button>
      </div>
    </div>
  </div>

  {{-- ===== JS (inline — ajustado para manter suas funções e sem interferir nos novos forms) ===== --}}
  <script>
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function filtrarStatus(status){
      document.querySelectorAll('.filters [data-status]').forEach(b=>b.classList.remove('active'));
      document.querySelector(`.filters [data-status="${status}"]`)?.classList.add('active');
      document.querySelectorAll('#tabelaSolicitacoes tbody tr').forEach(tr=>{ 
        const st = tr.getAttribute('data-status');
        tr.style.display = (status==='todos'||st===status)?'':'none';
      });
    }
    function toggleAll(chk){ document.querySelectorAll('.row-check').forEach(r=>r.checked=chk.checked); }
    function getSelecionados(){
      return [...document.querySelectorAll('#tabelaSolicitacoes tbody tr')].filter(tr=>tr.querySelector('.row-check')?.checked).map(tr=>tr.getAttribute('data-row-id'));
    }

    // helpers
    function soDigitos(s){ return (s||'').replace(/\D+/g,''); }
    function normalizaWhats(n){ if(!n)return null; n=n.replace(/^0+/,''); return n.startsWith('55')?n:'55'+n; }
    function br(texto){ if(!texto)return '—'; return String(texto).replace(/\n/g,'<br>'); }
    function fmtNascimento(s){
      if(!s) return '—';
      const d = new Date(s);
      if(!isNaN(d)) {
        const dd = String(d.getDate()).padStart(2,'0');
        const mm = String(d.getMonth()+1).padStart(2,'0');
        const yyyy = d.getFullYear();
        return `${dd}/${mm}/${yyyy}`;
      }
      const m = String(s).match(/^(\d{4})-(\d{2})-(\d{2})$/);
      if(m) return `${m[3]}/${m[2]}/${m[1]}`;
      return s;
    }
    function getAttrText(el, attr){
      const raw = el.getAttribute(attr);
      if (!raw || raw === 'null' || raw === 'undefined') return '';
      const ta = document.createElement('textarea');
      ta.innerHTML = raw;
      return ta.value;
    }

    // Preenche o offcanvas (apenas o corpo — lista + nome/email/status + botões)
    const offcanvas = document.getElementById('painelDetalhes');
    offcanvas.addEventListener('show.bs.offcanvas', function (event) {
      const btn = event.relatedTarget;
      if (!btn) return;

      const get = name => (btn.getAttribute(name) || '').trim();

      const pet       = get('data-pet');
      const adotante  = get('data-adotante');
      const email     = get('data-email');
      const cpf       = get('data-cpf');
      const nasc      = get('data-nascimento');
      const whats     = get('data-whats') || get('data-fone');
      const whatsRaw  = get('data-whatsraw');
      const endereco  = getAttrText(btn, 'data-endereco');
      const msg       = getAttrText(btn, 'data-msg');
      const status    = (btn.closest('tr')?.dataset.status) || get('data-status') || 'novo';

      // título do corpo
      document.getElementById('detNome').textContent = adotante || '—';
      document.getElementById('detEmail').textContent = email || '—';

      const detStatus = document.getElementById('detStatus');
      const label = {novo:'Novo', aprovado:'Aprovado', recusado:'Recusado'}[status] || 'Novo';
      detStatus.textContent = label;
      detStatus.className = `status-pill status-${status || 'novo'}`;

      // Lista de detalhes (aqui colocamos CPF, Nascimento, Endereço, Pet)
      const lista = document.getElementById('detalhesLista');
      lista.innerHTML = `
        <li class="mb-2"><strong>CPF:</strong> ${cpf || '—'}</li>
        <li class="mb-2"><strong>Nascimento:</strong> ${fmtNascimento(nasc)}</li>
        <li class="mb-2"><strong>Endereço:</strong> <div>${br(endereco)}</div></li>
        <li class="mb-2"><strong>Pet Solcitado:</strong> ${pet || '—'}</li>
      `;

      // WhatsApp
      const btnWa = document.getElementById('btnWhatsDetalhes');
      const numeroWa = normalizaWhats(soDigitos(whatsRaw || whats));
      if (numeroWa && numeroWa.length >= 12) {
        const texto = encodeURIComponent(`Olá ${adotante?.split(' ')[0]||''}, aqui é da ONG. Recebemos sua solicitação para o pet "${pet}". Podemos conversar?`);
        btnWa.disabled = false;
        btnWa.onclick = () => window.open(`https://wa.me/${numeroWa}?text=${texto}`, '_blank');
      } else {
        btnWa.disabled = true;
        btnWa.onclick = null;
      }
    });

    // Ações (status) — usa endpoint PATCH /painel/ong/solicitacoes/{id}/status já presente no seu JS original
    async function atualizarStatus(id, status){
      try{
        const resp = await fetch(`/painel/ong/solicitacoes/${id}/status`, {
          method:'PATCH',
          headers:{'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF},
          body: JSON.stringify({status})
        });
        if(!resp.ok) throw new Error('Falha ao atualizar status');
        const tr = document.querySelector(`tr[data-row-id="${id}"]`);
        if(tr){
          tr.setAttribute('data-status', status);
          const pill = tr.querySelector('.status-pill');
          if(pill){ pill.className = `status-pill status-${status}`; pill.textContent = status==='aprovado'?'Aprovado':(status==='recusado'?'Recusado':'Novo'); }
        }
      }catch(e){ console.error(e); alert('Não foi possível atualizar a solicitação. Tente novamente.'); }
    }
    window.marcarRecusado     = (btn)=>{ const id=btn.dataset.id; if(!id)return; if(confirm('Confirmar recusa desta solicitação?')) atualizarStatus(id,'recusado'); }
    window.aceitarSelecionados= ()=>{ const ids=getSelecionados(); if(!ids.length) return alert('Nenhuma linha selecionada.'); if(confirm(`Aprovar ${ids.length} solicitação(ões)?`)){ ids.forEach(id=>atualizarStatus(id,'aprovado')); document.getElementById('checkAll').checked=false; toggleAll({checked:false}); } }
    window.recusarSelecionados= ()=>{ const ids=getSelecionados(); if(!ids.length) return alert('Nenhuma linha selecionada.'); if(confirm(`Recusar ${ids.length} solicitação(ões)?`)){ ids.forEach(id=>atualizarStatus(id,'recusado')); document.getElementById('checkAll').checked=false; toggleAll({checked:false}); } }
  </script>
@endsection

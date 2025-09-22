   @php
                        // WhatsApp da ONG (fallback)
                        $numeroOng = preg_replace('/\D/', '', optional($pet->ong)->telefone ?? '');
                        if ($numeroOng && !str_starts_with($numeroOng, '55')) {
                            $numeroOng = '55' . $numeroOng;
                        }

                        // Mensagem padrão
                        $nomeUsuario   = auth('adotante')->user()->nome_completo ?? 'Adotante';
                        $cidadeUsuario = auth('adotante')->user()->cidade ?? 'sua cidade';
                        $mensagemUrl   = urlencode("Olá, meu nome é $nomeUsuario e tenho interesse no pet {$pet->nome}. Moro em $cidadeUsuario.");

                        // Desabilitar se não disponível
                        $desabilitar = in_array($pet->status, ['reservado','adotado']);
                    @endphp

                    @auth('adotante')
                        <form method="POST" action="{{ route('solicitacoes.store') }}" class="d-grid gap-2">
                            @csrf
                            <input type="hidden" name="pet_id" value="{{ $pet->id }}">

                            {{-- (Opcional) mensagem curta para a ONG
                            <textarea name="mensagem" class="form-control" rows="2"
                                      placeholder="Mensagem opcional para a ONG (ex.: breve apresentação)"></textarea>
                            --}}

                            <button type="submit"
                                    class="btn btn-primary w-100 fw-bold"
                                    {{ $desabilitar ? 'disabled' : '' }}>
                                Quero Adotar!
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                           class="btn btn-primary w-100 fw-bold">
                            Faça login para solicitar
                        </a>
                    @endauth

                    @if($numeroOng)
                        <a href="https://wa.me/{{ $numeroOng }}?text={{ $mensagemUrl }}"
                           target="_blank" class="btn btn-success w-100 fw-bold mt-2">
                            Falar no WhatsApp
                        </a>
                    @else
                        <button class="btn btn-secondary w-100 mt-2" disabled>WhatsApp indisponível</button>
                    @endif
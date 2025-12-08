import json, os, sys, requests


def obter_api_key() -> str:
    """Recupera a chave da API de uma variável de ambiente segura."""
    chave = os.getenv("OPENAI_API_KEY")
    if not chave:
        raise EnvironmentError("Variável de ambiente OPENAI_API_KEY não definida.")
    return chave

INSTRUCOES = """
Você é um especialista em adoção responsável de animais.

Receberá:
1. As características do adotante (trabalho, tempo em casa, espaço, lazer, moradia, experiência, tolerância a cuidados, renda).
2. A lista de pets disponíveis (id, nome, espécie, raça, porte, temperamento, faixa etária, idade, descrição, vacinado, vermifugado).

Sua tarefa:
- Escolher APENAS 1 pet que seja o mais compatível com o adotante.
- Justifique em UMA frase curta.

Formato da resposta: SOMENTE em JSON
{
  "id": <id do pet>,
  "nome": "nome do pet",
  "motivo": "frase curta explicando o encaixe"
}
"""

def escolher_pet(adotante: dict, pets: list) -> dict:
    prompt = f"""{INSTRUCOES}

Dados do adotante: {adotante}
Pets disponíveis: {pets}
"""
    try:
        api_key = obter_api_key()
        resp = requests.post(
            "https://api.openai.com/v1/chat/completions",
            headers={
                "Content-Type": "application/json",
                "Authorization": f"Bearer {api_key}"
            },
            json={
                "model": "gpt-4.1-mini",
                "temperature": 0.2,
                "messages": [
                    {"role": "user", "content": prompt}
                ]
            },
            timeout=30
        )

        # log pro laravel
        sys.stderr.write(">>> DEBUG: resposta bruta da API:\n" + resp.text + "\n")

        resp.raise_for_status()

        content = resp.json()["choices"][0]["message"]["content"]

        # confirma se foi json
        if "{" in content:
            start = content.find("{")
            end = content.rfind("}") + 1
            content = content[start:end]

        return json.loads(content)
    except Exception as e:
        return {
            "id": None,
            "nome": "Indefinido",
            "motivo": f"Erro ao processar resposta: {e}"
        }

if __name__ == "__main__":
    try:
        payload = json.load(sys.stdin)
    except Exception as e:
        print(json.dumps({
            "id": None,
            "nome": "Indefinido",
            "motivo": f"Erro ao carregar payload: {e}"
        }, ensure_ascii=False))
        sys.exit(1)

    adotante = payload.get("adotante", {})
    pets     = payload.get("pets", [])

    resultado = escolher_pet(adotante, pets)

    # imprime JSON puro e em UTF-8
    print(json.dumps(resultado, ensure_ascii=False))
    sys.stdout.flush()

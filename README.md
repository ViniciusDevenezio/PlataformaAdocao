<h1 align="center">Plataforma de Adoção Inteligente com Automação</h1>

<p align="center"><strong>Projeto de Trabalho de Conclusão de Curso (TCC) - Sistemas de Informação - FHO | 2025</strong></p>

---

## 💡 Sobre o Projeto

Este projeto tem como finalidade otimizar o processo de adoção de animais em Organizações Não Governamentais (ONGs) por meio de uma plataforma web intuitiva, gratuita e acessível.

Utilizando recursos de **inteligência artificial**, o sistema fornece recomendações personalizadas, conectando adotantes aos pets mais compatíveis com seu perfil, contribuindo para adoções mais conscientes e duradouras.

Além disso, a plataforma oferece **ferramentas de automação** para facilitar a divulgação dos animais em redes sociais, ampliando o alcance das ONGs e aumentando as chances de adoção.

---

## 🛠️ Tecnologias Utilizadas

- **Laravel** — Framework PHP para desenvolvimento web  
- **MySQL** — Banco de dados relacional  
- **Blade** — Ferramenta do Laravel para gerar páginas HTML de forma dinâmica.
- **Bootstrap** — Framework CSS para estilização agil e responsiva 
- **OpenAI API** — Match inteligente de pets via IA  
- **Facebook Graph API** — Automação da divulgação nas redes sociais  
- **Composer** — Gerenciador de dependências PHP  
- **XAMPP** — Ambiente de desenvolvimento local (Apache + MySQL + PHP)
- 
---

## ⚙️ Funcionalidades Principais

- Cadastro e gerenciamento de animais disponíveis para adoção  
- Cadastro de adotantes
- Cadastro de ongs via Administração 
- Sistema inteligente de recomendação de pets  
- Automação de postagens de animais para adoção no Facebook (Graph API) 
- Interface Web
- Painel administrativo para as ONGs  

---

## 🚧 Em Desenvolvimento

- Integração completa com a IA para sugerir pets ideais  
- Animais para publicação com um click via Graph IA
- Painel das ONGs

---

## ▶️ Como Executar o Projeto

1. Clone este repositório  
   ```bash
   git clone https://github.com/seu-usuario/plataforma-adocao-inteligente.git
   ```

2. Acesse o diretório do projeto  
   ```bash
   cd plataforma-adocao-inteligente
   ```

3. Instale as dependências  
   ```bash
   composer install
   ```

4. Configure o arquivo `.env` e configure com seu usuario e senha do banco de dados

5. Gere a chave da aplicação  
   ```bash
   php artisan key:generate
   ```

7. Execute as migrações do banco de dados  
   ```bash
   php artisan migrate
   ```

7. Tenha certeza que a um servidor MYSQL phpmyadmin sendo executado na maquina com a porta corretamente  

8. Inicie o servidor local  
   ```bash
   php artisan serve
   ```

---

## 👨‍💻 Autores

- Vinicius Fernandes Devenezio 
- César Henrique Santos Duarte
```

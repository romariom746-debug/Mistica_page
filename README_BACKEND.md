# 📋 Backend do Formulário de Contato - Instruções

## 📝 Descrição

O backend foi desenvolvido em PHP e processa as mensagens de contato enviadas através do formulário da página.

## 🔧 Arquivos Criados

### contact.php

- Localização: `c:\Users\romar\Desktop\cliente\contact.php`
- Responsável por: Receber, validar e processar as mensagens de contato

## ⚙️ Como Funciona

### 1. Validação de Dados

O formulário valida:

- **Nome**: 3 a 100 caracteres
- **Email**: Formato válido de email
- **Mensagem**: 10 a 5000 caracteres

### 2. Envio de Email

Quando um formulário é enviado com sucesso:

- Email é enviado para `contato@mystica.com.br`
- Retorna resposta em JSON para a página

### 3. Registro de Mensagens

- Todas as mensagens são registradas em `contact_log.txt`
- Arquivo fica na mesma pasta do contact.php

## 🚀 Configuração Necessária

### 1. Alterar Email de Destino

Abra o arquivo `contact.php` e localize a linha:

```php
$to_email = 'contato@mystica.com.br'; // Altere para seu email
```

Substitua `contato@mystica.com.br` pelo seu email.

### 2. Configurar Servidor PHP

A página precisa de um servidor com PHP habilitado:

#### Opção 1: XAMPP (Recomendado)

1. Baixe e instale [XAMPP](https://www.apachefriends.org/)
2. Coloque a pasta do projeto em `C:\xampp\htdocs\cliente`
3. Inicie Apache
4. Acesse em: `http://localhost/cliente`

#### Opção 2: PHP Built-in Server

```bash
cd c:\Users\romar\Desktop\cliente
php -S localhost:8000
```

Acesse em: `http://localhost:8000`

#### Opção 3: Hospedagem Online

Envie os arquivos para um host que suporte PHP.

## 📊 Testando o Formulário

1. Acesse a página no navegador
2. Vá para a seção "Contato"
3. Preencha o formulário com:
   - Nome
   - Email
   - Mensagem
4. Clique em "Enviar Mensagem"
5. Você verá uma mensagem de sucesso ou erro

## 📧 Email Recebido

Quando um email é enviado com sucesso, você receberá um email formatado com:

- Nome do contato
- Email de resposta
- Mensagem completa
- Data/hora do envio

## 🔍 Visualizar Registro de Mensagens

Abra o arquivo `contact_log.txt` para ver todas as mensagens recebidas com:

- Data e hora
- Nome
- Email
- Primeira parte da mensagem

## ⚠️ Troubleshooting

### "Erro ao enviar mensagem"

- Verifique se o arquivo `contact.php` está na mesma pasta que `index.html`
- Confirme se o servidor PHP está rodando
- Verifique se o email está corretamente configurado

### "Validação falhou"

- Verificar se preencheu todos os campos
- Nome deve ter pelo menos 3 caracteres
- Mensagem deve ter pelo menos 10 caracteres

### Email não chegando

- Verifique o endereço de email em `contact.php`
- Verifique a pasta de spam
- Configure as credenciais SMTP se necessário (leia seção avançada)

## 🔐 Segurança

O código já inclui:

- ✅ Sanitização de dados (htmlspecialchars)
- ✅ Validação de email (filter_var)
- ✅ Validação de comprimento de texto
- ✅ Proteção contra CORS

## 📤 Envio de Email Avançado (SMTP)

Se o servidor não tem mail() configurado, você pode usar SMTP:

1. Instale o Composer:

```bash
composer require phpmailer/phpmailer
```

2. Solicite um arquivo contact-smtp.php atualizado

## 📞 Suporte

Para dúvidas ou problemas, revise o arquivo `contact_log.txt` para verificar se as mensagens estão sendo registradas corretamente.

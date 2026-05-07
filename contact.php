<?php
// =========================================
// BACKEND DO FORMULÁRIO DE CONTATO
// =========================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Configurações
$to_email = 'romariom746@gmail.com'; // Altere para seu email
$log_file = 'contact_log.txt'; // Arquivo para registrar mensagens

// Valida se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido']);
    exit;
}

// Recebe e sanitiza os dados
$name = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'])) : '';
$email = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
$message = isset($_POST['message']) ? trim(htmlspecialchars($_POST['message'])) : '';

// Array para armazenar erros
$errors = [];

// Validação: Nome
if (empty($name)) {
    $errors[] = 'Nome é obrigatório';
} elseif (strlen($name) < 3) {
    $errors[] = 'Nome deve ter pelo menos 3 caracteres';
} elseif (strlen($name) > 100) {
    $errors[] = 'Nome não pode ter mais de 100 caracteres';
}

// Validação: Email
if (empty($email)) {
    $errors[] = 'Email é obrigatório';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email inválido';
}

// Validação: Mensagem
if (empty($message)) {
    $errors[] = 'Mensagem é obrigatória';
} elseif (strlen($message) < 10) {
    $errors[] = 'Mensagem deve ter pelo menos 10 caracteres';
} elseif (strlen($message) > 5000) {
    $errors[] = 'Mensagem não pode ter mais de 5000 caracteres';
}

// Se houver erros, retorna resposta com erro
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Validação falhou',
        'errors' => $errors
    ]);
    exit;
}

// =========================================
// ENVIAR EMAIL
// =========================================

$subject = 'Novo contato - Mística & Estratégia';

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// HTML do email
$email_body = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        .header { color: #0f172a; border-bottom: 3px solid #c5a059; padding-bottom: 15px; }
        .content { margin: 20px 0; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #c5a059; }
        .footer { text-align: center; color: #999; font-size: 12px; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 15px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>📧 Novo Contato Recebido</h2>
        </div>
        <div class='content'>
            <div class='field'>
                <span class='label'>Nome:</span>
                <p>" . nl2br($name) . "</p>
            </div>
            <div class='field'>
                <span class='label'>Email:</span>
                <p><a href='mailto:$email'>$email</a></p>
            </div>
            <div class='field'>
                <span class='label'>Mensagem:</span>
                <p>" . nl2br($message) . "</p>
            </div>
        </div>
        <div class='footer'>
            <p>Mensagem enviada em: " . date('d/m/Y H:i:s') . "</p>
            <p>Mística & Estratégia | Consultoria</p>
        </div>
    </div>
</body>
</html>
";

// Tenta enviar o email
$email_sent = mail($to_email, $subject, $email_body, $headers);

// =========================================
// REGISTRA A MENSAGEM EM ARQUIVO
// =========================================

$log_entry = "[" . date('Y-m-d H:i:s') . "] Nome: $name | Email: $email | Mensagem: " . substr($message, 0, 50) . "...\n";

if (!file_exists($log_file)) {
    file_put_contents($log_file, $log_entry);
} else {
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

// =========================================
// RESPOSTA AO CLIENTE
// =========================================

if ($email_sent) {
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Mensagem enviada com sucesso! Entraremos em contato em breve.'
    ]);
} else {
    // Email falhou, mas a mensagem foi registrada no arquivo
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Mensagem recebida! Entraremos em contato em breve.'
    ]);
}

exit;

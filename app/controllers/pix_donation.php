<?php

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../services/PixPayloadService.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'ok' => false,
        'message' => 'Metodo nao permitido.',
    ]);
    exit;
}

try {
    $input = $_POST;

    if (empty($input)) {
        $rawBody = file_get_contents('php://input');
        $decoded = json_decode($rawBody ?: '', true);
        $input = is_array($decoded) ? $decoded : [];
    }

    $amount = parse_pix_amount($input['amount'] ?? '');
    $minAmount = (float) env('PIX_MIN_AMOUNT', '5');
    $maxAmount = (float) env('PIX_MAX_AMOUNT', '5000');

    if ($amount < $minAmount) {
        throw new InvalidArgumentException('Informe um valor a partir de R$ ' . format_brl($minAmount) . '.');
    }

    if ($amount > $maxAmount) {
        throw new InvalidArgumentException('Informe um valor ate R$ ' . format_brl($maxAmount) . '.');
    }

    $pixKey = (string) env('PIX_KEY', '');
    $receiverName = (string) env('PIX_RECEIVER_NAME', 'AMORABI');
    $receiverCity = (string) env('PIX_RECEIVER_CITY', 'JOINVILLE');
    $txidPrefix = (string) env('PIX_TXID_PREFIX', 'AMORABI');

    $payload = (new PixPayloadService())->build($amount, $pixKey, $receiverName, $receiverCity, $txidPrefix);
    $whatsappMessage = 'Ola, fiz uma doação para a AMORABI no valor de R$ ' . format_brl($amount) . ' e gostaria de enviar o comprovante.';
    $whatsappUrl = 'https://api.whatsapp.com/send/?phone=47991987821&text=' . rawurlencode($whatsappMessage) . '&type=phone_number&app_absent=0';

    echo json_encode([
        'ok' => true,
        'amount' => number_format($amount, 2, '.', ''),
        'amount_label' => 'R$ ' . format_brl($amount),
        'payload' => $payload,
        'qr_image_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=320x320&margin=12&data=' . rawurlencode($payload),
        'whatsapp_url' => $whatsappUrl,
        'message' => 'Pix gerado com sucesso.',
    ]);
} catch (Throwable $exception) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => $exception->getMessage(),
    ]);
}

function parse_pix_amount(mixed $value): float
{
    $value = trim((string) $value);

    if ($value === '') {
        throw new InvalidArgumentException('Escolha ou informe um valor para doar.');
    }

    $value = str_replace(['R$', ' '], '', $value);

    if (str_contains($value, ',') && str_contains($value, '.')) {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
    } else {
        $value = str_replace(',', '.', $value);
    }

    if (!is_numeric($value)) {
        throw new InvalidArgumentException('Valor da doacao invalido.');
    }

    return round((float) $value, 2);
}

function format_brl(float $value): string
{
    return number_format($value, 2, ',', '.');
}

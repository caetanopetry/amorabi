<?php

class PixPayloadService
{
    public function build(
        float $amount,
        string $pixKey,
        string $receiverName,
        string $receiverCity,
        string $txidPrefix = 'AMORABI'
    ): string {
        $pixKey = trim($pixKey);
        $receiverName = $this->sanitizeReceiverName($receiverName);
        $receiverCity = $this->sanitizeReceiverCity($receiverCity);
        $txid = $this->buildTxid($txidPrefix, $amount);

        if ($amount <= 0) {
            throw new InvalidArgumentException('Valor da doacao invalido.');
        }

        if ($pixKey === '') {
            throw new InvalidArgumentException('Chave Pix nao configurada.');
        }

        if ($receiverName === '') {
            throw new InvalidArgumentException('Nome do recebedor nao configurado.');
        }

        if ($receiverCity === '') {
            throw new InvalidArgumentException('Cidade do recebedor nao configurada.');
        }

        $merchantAccount = $this->emv('00', 'br.gov.bcb.pix') . $this->emv('01', $pixKey);
        $merchantInfo = $this->emv('26', $merchantAccount);
        $transactionAmount = $this->emv('54', number_format($amount, 2, '.', ''));
        $additionalData = $this->emv('62', $this->emv('05', $txid));

        $payload = $this->emv('00', '01')
            . $this->emv('01', '12')
            . $merchantInfo
            . $this->emv('52', '0000')
            . $this->emv('53', '986')
            . $transactionAmount
            . $this->emv('58', 'BR')
            . $this->emv('59', $receiverName)
            . $this->emv('60', $receiverCity)
            . $additionalData;

        $payloadForCrc = $payload . '6304';

        return $payloadForCrc . strtoupper(str_pad(dechex($this->crc16($payloadForCrc)), 4, '0', STR_PAD_LEFT));
    }

    private function emv(string $id, string $value): string
    {
        return $id . str_pad((string) strlen($value), 2, '0', STR_PAD_LEFT) . $value;
    }

    private function crc16(string $payload): int
    {
        $crc = 0xFFFF;
        $length = strlen($payload);

        for ($i = 0; $i < $length; $i++) {
            $crc ^= ord($payload[$i]) << 8;

            for ($bit = 0; $bit < 8; $bit++) {
                if (($crc & 0x8000) !== 0) {
                    $crc = (($crc << 1) ^ 0x1021) & 0xFFFF;
                } else {
                    $crc = ($crc << 1) & 0xFFFF;
                }
            }
        }

        return $crc;
    }

    private function buildTxid(string $prefix, float $amount): string
    {
        $prefix = $this->toAsciiUpper($prefix);
        $prefix = preg_replace('/[^A-Z0-9]/', '', $prefix) ?: 'AMORABI';
        $amountInCents = (string) (int) round($amount * 100);

        return substr($prefix . $amountInCents, 0, 25);
    }

    private function sanitizeReceiverName(string $value): string
    {
        $value = $this->toAsciiUpper($value);
        $value = preg_replace('/[^A-Z0-9 \-]/', '', $value) ?: '';

        return substr($value, 0, 25);
    }

    private function sanitizeReceiverCity(string $value): string
    {
        $value = $this->toAsciiUpper($value);
        $value = preg_replace('/[^A-Z0-9 ]/', '', $value) ?: '';

        return substr($value, 0, 15);
    }

    private function toAsciiUpper(string $value): string
    {
        $value = trim($value);
        $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);

        return strtoupper($ascii !== false ? $ascii : $value);
    }
}

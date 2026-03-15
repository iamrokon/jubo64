<?php
/**
 * PHPMailer Lite - Single File Version
 * Optimized for Gmail Port 465 (SSL)
 */

namespace LiteMailer;

class SMTP {
    protected $smtp_conn;
    public $error = "";

    public function connect($host, $port = 465, $timeout = 15) {
        $this->smtp_conn = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$this->smtp_conn) {
            $this->error = "Connection failed: $errstr ($errno)";
            return false;
        }
        $this->getResponse();
        return true;
    }

    public function hello($host = 'localhost') {
        return $this->sendCommand("EHLO $host", 250);
    }

    public function authenticate($user, $pass) {
        if (!$this->sendCommand("AUTH LOGIN", 334)) return false;
        if (!$this->sendCommand(base64_encode($user), 334)) return false;
        if (!$this->sendCommand(base64_encode($pass), 235)) return false;
        return true;
    }

    public function sendCommand($command, $expect) {
        fwrite($this->smtp_conn, $command . "\r\n");
        $response = $this->getResponse();
        if ((int)substr($response, 0, 3) !== $expect) {
            $this->error = "Command failed ($command): " . $response;
            return false;
        }
        return true;
    }

    protected function getResponse() {
        $response = "";
        while ($str = fgets($this->smtp_conn, 515)) {
            $response .= $str;
            if (isset($str[3]) && $str[3] === " ") break;
        }
        return $response;
    }

    public function mail($from) { return $this->sendCommand("MAIL FROM:<$from>", 250); }
    public function recipient($to) { return $this->sendCommand("RCPT TO:<$to>", 250); }
    public function data($data) {
        if (!$this->sendCommand("DATA", 354)) return false;
        fwrite($this->smtp_conn, $data . "\r\n.\r\n");
        return $this->sendCommand("", 250); // Dummy check for line end
    }
    public function quit() { 
        if ($this->smtp_conn) {
            fwrite($this->smtp_conn, "QUIT\r\n");
            fclose($this->smtp_conn); 
        }
    }
}

function sendOTPSMTP($to, $otp) {
    $host = 'ssl://smtp.gmail.com';
    $port = 465;
    $user = 'software.promisegroup@gmail.com';
    $pass = 'ggeyhekunkpqdbiy';
    $from = 'software.promisegroup@gmail.com';
    $name = 'e-Learning & Earning Ltd.';

    $smtp = new SMTP();
    if (!$smtp->connect($host, $port)) {
        error_log($smtp->error);
        return false;
    }
    if (!$smtp->hello()) return false;
    if (!$smtp->authenticate($user, $pass)) return false;
    
    $smtp->mail($from);
    if (!$smtp->recipient($to)) return false;
    
    $subject = "Password Reset OTP";
    $body = "Your 4-digit OTP for password reset is: " . $otp . "\r\n\r\nThis code will expire in 10 minutes.";
    
    $data = "To: <$to>\r\n" .
            "From: $name <$from>\r\n" .
            "Subject: $subject\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/plain; charset=utf-8\r\n\r\n" .
            $body;
            
    if (!$smtp->data($data)) return false;
    $smtp->quit();
    return true;
}
?>

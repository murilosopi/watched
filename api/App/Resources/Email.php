<?php

namespace App\Resources;

use \PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
  private array $destinatario = [];
  private string $conteudo;
  private string $assunto;
  private string $conteudoAlternativo;
  private PHPMailer $mail;

  public function __construct()
  {
    $this->mail = new PHPMailer();
    $this->mail->isSMTP();
    $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->Port = 465;
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $this->mail->SMTPAuth = true;
    $this->mail->Username = EMAIL;
    $this->mail->Password = SENHA_EMAIL;
    $this->mail->setFrom(EMAIL, 'Watched!');
    $this->mail->CharSet = "UTF-8";
    $this->mail->Encoding = 'base64';
  }

  public function setConteudo(string $conteudo)
  {
    $this->conteudo = $conteudo;
  }

  public function setAssunto(string $assunto)
  {
    $this->assunto = $assunto;
  }

  public function setConteudoAlternativo(string $conteudo)
  {
    $this->conteudoAlternativo = $conteudo;
  }

  public function setDestinatario(string $conteudo)
  {
    $this->destinatario[] = $conteudo;
  }

  public function enviar()
  {

    foreach($this->destinatario as $dest) {
      $this->mail->addAddress($dest);
    }
    $this->mail->Subject = $this->assunto;
    $this->mail->Body = $this->conteudo;
    $this->mail->AltBody = $this->conteudo;

    $enviado = $this->mail->send();
    if (!$enviado) {
      $erro = $this->mail->ErrorInfo;

      $logger = new Logger('email');
      $logger->registrar($erro);
      
      return false;
    } else {
      return true;
    }
  }
}

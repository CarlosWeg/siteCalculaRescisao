<?php

namespace App\Models;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class SugestaoModel{
    private $oMail;
    private $sNomeContato;
    private $sEmailContato;
    private $sMensagemContato;

    public function __construct($aDados){
        $this->sNomeContato = $aDados['nome_contato'];
        $this->sEmailContato = $aDados['email_contato'];
        $this->sMensagemContato = $aDados['mensagem_contato'];

        $this->oMail = new PHPMailer(true); // O true permite que sejam lançadas exceções
    }

    public function enviar(){
        $this->oMail->isSMTP();
        $this->oMail->Host = 'smtp.gmail.com';
        $this->oMail->SMTPAuth = true;
        $this->oMail->Username = 'calososla@gmail.com';
        $this->oMail->Password = 'zgfr fqcp jdkr htez';
        $this->oMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->oMail->Port = 587;
        $this->oMail->CharSet = 'UTF-8';
        
        $this->oMail->setFrom('calososla@gmail.com','Calcula Rescisão');
        $this->oMail->addAddress('calososla@gmail.com');

        $this->oMail->isHtml(true);
        $this->oMail->Subject = 'Cacula Rescisão - Contato de : ' . $this->sNomeContato;

        $this->oMail->Body = "<html>

                                <h2>Detalhes do contato:</h2>

                                <p><strong>Nome: </strong>{$this->sNomeContato}</p>
                                <p><strong>E-mail: </strong>{$this->sEmailContato}</p>
                                <p><strong>Mensagem: </strong>{$this->sMensagemContato}</p>
                                
                                </html>";
            
        return $this->oMail->send();
    }
}
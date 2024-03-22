<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/env.php';

use MyApplication\Configure;

?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
        <title>Comprar Propheta</title>
    </head>
    <body>
        <!-- Loader -->
        <div id="loader" class="hidden">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <circle cx="50" cy="50" fill="none" stroke="#007bff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                </circle>
            </svg>
        </div>
        <div role="main" class="container-fluid">

            <?php if( !Configure::enabled() ){  include_once('componente/disabled.php');  } ?>

            <div class="row d-flex px-3" style="margin-top: 15px;">
                <div class="row">
                    <h2>Pagamento</h2>
                </div>
                
                <form method="POST" action="api/payment.php" class="row" id="frmPayment" style="margin-top: 15px;">
                    
                    <!-- Dados do pagamento -->
                    <div class="col-sm-8 border-end">
                        <!-- Metodo de Pagamento -->
                        
                        <div class="row">

                                <!-- Cartão -->
                                <div class="col-4 text-center border-end">
                                    <div class="payment-card">
                                        <div class="payment-card-icon">
                                            <i class="fa-regular fa-credit-card"></i>
                                        </div>
                                        <div class="payment-card-text">
                                            Cartão Credito/Debito
                                        </div>
                                    </div>
                                </div>
                                <!-- PIX -->
                                <div class="col-4 text-center border-end">
                                    <div class="payment-card">
                                        <div class="payment-card-icon">
                                            <i class="fa-brands fa-pix"></i>
                                        </div>
                                        <div class="payment-card-text">
                                            Pix
                                        </div>
                                    </div>
                                </div>
                                <!-- Boleto -->
                                <div class="col-4 text-center">
                                    <div class="payment-card">
                                        <div class="payment-card-icon">
                                            <i class="fa-solid fa-barcode"></i>
                                        </div>
                                        <div class="payment-card-text">
                                            Boleto
                                        </div>
                                    </div>
                                </div>

                                    
                        </div>
                        <br>
                        <!-- Dados de Pagamento -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        Dados para faturamento
                                    </div>
                                    <div class="card-body px-4">
                                        <div class="form-group"  style="padding-top: 7px;">
                                            <label for="nomeRazaoSocial">Nome/Razão Social *</label>
                                            <input type="text" class="form-control" id="nomeRazaoSocial" name="nomeRazaoSocial" minlength="3" maxlength="255" required>
                                        </div>
                                        <div class="row" style="padding-top: 7px;">
                                            <div class="form-group col-md-6">
                                                <label for="cpfCnpj">CPF/CNPJ *</label>
                                                <input type="text" class="form-control" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}|\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}"  id="cpfCnpj" name="cpfCnpj" required>
                                            </div>
                                            <div class="form-group col-md-6 hidden">
                                                <label for="inscricaoEstadual">Ins. Estadual</label>
                                                <input type="text" class="form-control" id="inscricaoEstadual" name="inscricaoEstadual" maxlength="255">
                                            </div>
                                        </div>
                                        <div class="row"  style="padding-top: 7px;">
                                            <div class="form-group col-md-6">
                                                <label for="email">Email *</label>
                                                <input type="email" class="form-control" pattern="[^\s@]+@[^\s@]+\.[^\s@]+" id="email" name="email" maxlength="255" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="telefoneCelular">Telefone/Celular *</label>
                                                <input type="tel" class="form-control" id="telefoneCelular" name="telefoneCelular" pattern="\(\d{2}\)\s\d{5}-(\d{3}|\d{4})"  maxlength="255" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        Endereço de cobrança
                                    </div>
                                    <div class="card-body">
                                        <div class="row" style="padding-top: 7px;">    
                                            <div class="form-group col-md-8">
                                                <label for="cep">CEP *</label>
                                                <input type="text" class="form-control" id="cep" name="cep" pattern="\d{5}-\d{3}"  maxlength="255" required>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 7px;">
                                            <div class="form-group col-md-12">
                                                <label for="endereco">Endereço *</label>
                                                <input type="text" class="form-control" id="endereco" name="endereco" maxlength="300" required>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 7px;">
                                            <div class="form-group col-md-6">
                                                <label for="cidade">Cidade *</label>
                                                <input type="text" class="form-control" id="cidade" name="cidade" maxlength="255" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="estado">Estado</label>
                                                <select class="form-control" id="estado" name="estado">
                                                    <option value="">Selecione o Estado</option>
                                                    <option value="AC">Acre</option>
                                                    <option value="AL">Alagoas</option>
                                                    <option value="AP">Amapá</option>
                                                    <option value="AM">Amazonas</option>
                                                    <option value="BA">Bahia</option>
                                                    <option value="CE">Ceará</option>
                                                    <option value="DF">Distrito Federal</option>
                                                    <option value="ES">Espírito Santo</option>
                                                    <option value="GO">Goiás</option>
                                                    <option value="MA">Maranhão</option>
                                                    <option value="MT">Mato Grosso</option>
                                                    <option value="MS">Mato Grosso do Sul</option>
                                                    <option value="MG">Minas Gerais</option>
                                                    <option value="PA">Pará</option>
                                                    <option value="PB">Paraíba</option>
                                                    <option value="PR">Paraná</option>
                                                    <option value="PE">Pernambuco</option>
                                                    <option value="PI">Piauí</option>
                                                    <option value="RJ">Rio de Janeiro</option>
                                                    <option value="RN">Rio Grande do Norte</option>
                                                    <option value="RS">Rio Grande do Sul</option>
                                                    <option value="RO">Rondônia</option>
                                                    <option value="RR">Roraima</option>
                                                    <option value="SC">Santa Catarina</option>
                                                    <option value="SP">São Paulo</option>
                                                    <option value="SE">Sergipe</option>
                                                    <option value="TO">Tocantins</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dados do pedido-->
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                Pedido
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                            <tr>
                                                <td>
                                                    <th> Produto </th>
                                                </td>
                                                <td>
                                                    <th> Preco R$</th>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <th> Licença Propheta </th>
                                                </td>
                                                <td>
                                                    <th> R$ <?=number_format($_ENV['PROPHETA_PRICE'], 2, ',', '.')?> </th>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>
                                                    <th> Total </th>
                                                </td>
                                                <td>
                                                    <th> R$ <?=number_format($_ENV['PROPHETA_PRICE'], 2, ',', '.')?> </th>
                                                </td>
                                            </tr>
                                        </tfoot>
                                </table>
                                <div class="row px-3">
                                    <div class="col-sm-12 ml-auto">
                                        <p class="text-right small text-muted">
                                            Ao clicar em Confirmar pedido, você concorda com os nossos <a href="url-dos-termos-de-uso">termos de Uso</a>. Além disso, ao proceder, você confirma seu desejo de efetuar o pagamento.
                                        </p>
                                    </div>
                                </div>
                                <div class="row px-3">
                                    <div class="col-sm-4 ml-auto">
                                        <!-- Este espaço em branco é criado automaticamente para alinhar o botão à direita -->
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary col-sm-8">
                                        Confirmar pedido
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div class="row px-3" style="padding-top: 12px;">
                            <div class="col-sm-12 ml-auto">
                                <p class="text-right small text-muted">
                                    A nota fiscal e o codigo de licença será enviado para:
                                    <br/>
                                    <strong id="emailFiscal" style="word-break: break-all;">email@email.com</strong>
                                </p>
                                <div class="row text-center">
                                    <img style="width: 21%;" src="https://s3-sa-east-1.amazonaws.com/asaas-static/images/invoice/site-seguro.png" class="marg-t-24" title="Site seguro" alt="Site seguro">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <style>
            #loader{
                padding-top: 20px;
                text-align: center;
                position: absolute;
                top:0;
                left: 0;
                z-index: 1;
                height: 100vh;
                width: 100vw;
                overflow: hidden;
                background-color: #f6f6f69c;
            }
            #loader svg{
                width: 40%;
            }
            .hidden {
                display: none;
            }
            .payment-card{
                background: rgba(158,158,158, 0.20);
                padding: 20px 25px 10px 25px;
                color: rgb(0 0 0 / 51%);
                font-weight: 500;
                border-radius: 5px;
                font-size: 13px;
                cursor: pointer;
                display: flex;
                flex-wrap: nowrap;
                flex-direction: column;
                align-content: center;
                justify-content: center;
                align-items: center;
                min-height: 180px;
            }
            .payment-card.active{
                background: #0d6efdd4;
                color: white;
                border-radius: 7px;
                border: solid 1px #eee;
            }

            .payment-card .payment-card-icon{
                font-size: 3.6em;
            }

            .payment-card .payment-card-text{
                font-size: 1.3em;
                padding-top: 7px;
                font-weight: bold;
            }

            .payment-card.active .payment-card-text{
                font-size: 1.5em;
                
            }
        </style>
        <script>

            $(document).ready(function() {
                $('#cpfCnpj').mask('000.000.000-00', {reverse: true});
                $('#telefoneCelular').mask('(00) 00000-0000');
                $('#cep').mask('00000-000');

                $('#frmPayment').on('submit', function(event) {

                    event.preventDefault()

                    var nomeRazaoSocial = $('#nomeRazaoSocial').val().trim();
                    var cpfCnpj = $('#cpfCnpj').val().replace(/[^\d]/g, '');
                    var email = $('#email').val().trim();
                    var telefoneCelular = $('#telefoneCelular').val().replace(/[^\d]/g, '');

                    if (!nomeRazaoSocial || !cpfCnpj || !email || !telefoneCelular) {
                        return alert('Todos os campos são obrigatórios.');
                    }

                    $('#loader').removeClass('hidden');

                    var formData = $(this).serialize();
                    var action = $(this).attr('action');
                    // ajax api/payment.php
                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: formData
                    }).then(res=>{
                        $('#loader').addClass('hidden');
                        console.log("Res:", res);
                        if(res.invoiceUrl){
                            window.location = res.invoiceUrl;
                        }
                    }).catch(e =>{
                        $('#loader').addClass('hidden');
                        console.log("Res:", e);
                        //menssagem de sistema indisponivel!!
                    });
                });

                $('#cpfCnpj').on('keydown', function(event) {
                    
                    var valor = $(this).val().replace(/[^\d]/g, '');
                    
                    console.log("Oiii", valor.length)

                    if (valor.length < 11) {
                        $(this).mask('000.000.000-00', {reverse: true});
                        $('#inscricaoEstadual').parent().addClass('hidden');
                    } else {
                        $(this).mask('00.000.000/0000-00', {reverse: true});
                        $('#inscricaoEstadual').parent().removeClass('hidden');
                    }
                });

                $('#email').on('input', function(){
                    $('#emailFiscal').text( $(this).val() )
                });

                $('#cep').on('input', function() {
                    var cep = $(this).val().replace(/\D/g, '');
                    if (cep.length === 8) {
                        buscarEndereco(cep);
                    }
                });

                $('.payment-card').click(function(){
                    let card = $(this);
                    if(!card.hasClass('active')){
                        $('.payment-card').removeClass('active');
                    }

                    if(card.toggleClass('active')){
                        console.log("Alterar input[name=method]");
                    }
                })
            });

            function buscarEndereco(cep) {
                $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                    if (!("erro" in data)) {
                        $('#cidade').val(data.localidade);
                        $('#endereco').val(data.logradouro);
                        $('#estado').val(data.uf);
                    } else {
                        alert('CEP não encontrado');
                    }
                }).fail(function() {
                    alert('Erro ao buscar CEP. Por favor, tente novamente mais tarde.');
                });
            }

        </script>
    </body>
</html>

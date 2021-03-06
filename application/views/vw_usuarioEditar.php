<?php
$form = array('id' => 'form-login', 'class' => 'form-horizontal', 'role' => 'form');
$usuario = array('name' => 'nome', 'id' => 'nome', 'class' => 'form-control');
$lusuario = array('class' => 'form-control');
$this->db->where('nome_user', $this->session->userdata('nome'));
$query = $this->db->get('tb_users');
$query = $query->result();
if($query[0]->tipo > 0)
    redirect('/home/guiaLista');
else{
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Marciso Gonzalez Martines">

        <title><?=$query[0]->titulo?></title>

        <link href="<?= base_url() ?>css/bootstrap.css" rel="stylesheet">
        <link href="<?= base_url() ?>css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url() ?>font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
    </head>
    <body>
        <div id="wrapper">
            <!-- barra lateral -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href=""><?=$query[0]->empresa?></a>
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li><a href="<?php echo base_url() . "index.php/home/" ?>"><i class="fa fa-dashboard"></i> Geral</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/reserva" ?>"><i class="fa fa-ticket"></i> Reserva</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/cliente?pagina=0" ?>"><i class="fa fa-users "></i> Cliente</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/agenda?pagina=0" ?>"><i class="fa fa-calendar"></i> Agendamento</a></li>
<!--                        <li><a href="<?php echo base_url() . "index.php/home/orcamento" ?>"><i class="fa fa-file-text-o"></i> Orçamento</a></li>-->
                        <li><a href="<?php echo base_url() . "index.php/home/onibus" ?>"><i class="fa fa-truck"></i> Ônibus</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/viagem" ?>"><i class="fa fa-tasks"></i> Destino</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/motorista" ?>"><i class="fa fa-car"></i> Motorista</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/guiaLista" ?>"><i class="fa fa-bus"></i> Guia</a></li>
                        <li class="active"><a href="<?php echo base_url() . "index.php/home/usuario" ?>"><i class="fa fa-user"></i> Usuário</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/relatorio" ?>"><i class="fa fa-bar-chart-o"></i> Relatórios</a></li>
                    </ul>
                    <!-- Menu superior alinhado a direita-->
                    <ul class="nav navbar-nav navbar-right navbar-user">
                        <li class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= $query[0]->nome_user ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-user"></i> Perfil</a></li>
                                <li><?= form_open('home/editarUsuario') ?>
                                <input type="hidden" name="id_users" value="<?= $query[0]->id_users ?>" />
                                <button type="submit" class="btn btn-link"><i class="fa fa-gear"></i> Configurações</button>
                                </form></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url() . "index.php/home/logout" ?>"><i class="fa fa-power-off"></i> Sair</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <!--fim do menu superior alinhado a direita-->
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Usuário <small>Edição</small></h1>
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-user"></i><a href="<?php echo base_url() . "index.php/home/usuario" ?>"> Usuário</a>/Editar</li>
                        </ol>
                    </div>
                </div><!-- /.row -->
                <div class="row">
                    <h3>Editar Usuário</h3>
                    <?php
                    echo form_open('home/editarValidacaoUsuario', $form);
                    $this->db->where('id_users', $this->input->post('id_users'));
                    $query = $this->db->get('tb_users');
                    foreach ($query->result_array() as $row) {
                        $usuarioDados = $row;
                    }
                    echo validation_errors();
                    echo "<div class='row'>";
                    echo "<div class='col-md-4'>";
                    echo form_label('Nome: ', 'nome');
                    echo "<input type='text' name='nome' id='nome' class='form-control input-sm' value='".$usuarioDados['nome_comp']."'>";
                    echo "</div>";
                    echo "<div class='col-md-2'>";
                    echo form_label('Nome de Usuario: ', 'nomeUsuario');
                    echo "<input type='text' name='usuario' id='usuario' class='form-control input-sm' value='".$usuarioDados['nome_user']."'>";
                    echo "</div>";
                    echo "<div class='col-md-3'>";
                    echo form_label('E-mail: ', 'email');
                    echo "<input type='text' name='email' id='email' class='form-control input-sm' value='".$usuarioDados['email']."'>";
                    echo '</div>';
                    echo '</div>';
                    echo "<div class='row'>";
                    echo "<div class='col-md-3'>";
                    echo form_label('Senha: ', 'senha');
                    echo "<input type='password' name='senha' id='senha' class='form-control input-sm'>";
                    echo "</div>";
                    echo "<div class='col-md-2'>";
                    echo form_label('Telefone: ', 'telefone');
                    echo "<input type='text' name='telefone' id='telefone' class='form-control input-sm' value='".$usuarioDados['telefone']."'>";
                    echo "</div>";
                    echo "<div class='col-md-2'>";
                    echo form_label('Celular: ', 'celular');
                    echo "<input type='text' name='celular' id='celular' class='form-control input-sm' value='".$usuarioDados['celular']."'>";
                    echo "</div>";
                    $tipo = array(
                        '0' => 'Usuário',
                        '1' => 'Guia'
                    );
                    echo "<div class='col-md-2'>";
                    echo form_label('Tipo: ');
                    echo form_dropdown('tipo',$tipo,$usuarioDados['tipo'],'class=form-control');
                    echo "</div>";
                    echo '</div>';
                    echo "<div class='row'>";
                    echo "<div class='col-md-2'>";
                    $ativo = array(
                        'name' => 'status',
                        'id' => 'status',
                        'value' => 'A',
                        'checked' => ($usuarioDados['status'] == 'A' ? TRUE : FALSE),
                    );
                    $inativo = array(
                        'name' => 'status',
                        'id' => 'status',
                        'value' => 'I',
                        'checked' => ($usuarioDados['status'] == 'A' ? FALSE : TRUE),
                    );
                    echo form_label('Situação: ');
                    echo "Ativo " . form_radio($ativo);
                    echo " Inativo " . form_radio($inativo);
                    echo form_hidden('id_users', $this->input->post('id_users'));
                    echo "</div>";
                    echo '</div>';
                    echo '<br>';
                    echo '<input type="submit" class="btn btn-primary" value="Editar">';

                    echo form_close();
                    ?>
                    <!--Fim da Panel verde-->
                </div>
            </div><!-- /#page-wrapper -->
        </div><!-- /#wrapper -->
        <!-- JavaScript -->
        <script src="<?= base_url() ?>js/jquery-1.10.2.js"></script>
        <script src="<?= base_url() ?>js/bootstrap.js"></script>
        <!-- Page Specific Plugins -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
        <script src="<?= base_url() ?>js/morris/chart-data-morris.js"></script>
        <script src="<?= base_url() ?>js/tablesorter/jquery.tablesorter.js"></script>
        <script src="<?= base_url() ?>js/tablesorter/tables.js"></script>
    </body>
</html>
<?php
}
?>
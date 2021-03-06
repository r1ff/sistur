<!DOCTYPE html>
<?php
$this->db->where('nome_user', $this->session->userdata('nome'));
$query = $this->db->get('tb_users');
$query = $query->result();
if($query[0]->tipo > 0)
    redirect('/home/guiaLista');
else{
?>
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
        <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui.css">
        <link href='<?= base_url() ?>charisma/css/jquery.cleditor.css' rel='stylesheet'>
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
                        <li><a href="<?php echo base_url() . "index.php/home/usuario" ?>"><i class="fa fa-user"></i> Usuário</a></li>
                        <li class="active"><a href="<?php echo base_url() . "index.php/home/relatorio" ?>"><i class="fa fa-bar-chart-o"></i> Relatórios</a></li>
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
                        <h1>E-mail <small>Contato</small></h1>
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-envelope"></i> E-mail</li>
                        </ol>
                    </div>
                </div><!-- /.row -->
                <div class="controls">
                    <?= form_open('home/validacaoEmail') ?>
                    <table>
                        <tr>
                            <td><?php
                                $this->db->order_by('nome', 'asc');
                                $this->db->where('email !=','');
                                $query = $this->db->get('tb_clients');
                                $opcao[] = '';
                                echo form_label('Cliente: ');
                                foreach ($query->result() as $bus) {
                                    $opcao[$bus->id_clients] = $bus->nome;
                                }
                                ?>
                            </td>
                            <td>                    
                                <?= form_dropdown('id_client', $opcao, $this->input->post('id_client'), 'class=form-control') ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <textarea class="cleditor" name="textarea2" id="textarea2" rows="3"></textarea>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Enviar E-mail">
                    <?= form_close() ?>
                </div>
                <div id="relatorio" class=" row-fluid">
                </div>
            </div><!-- /#page-wrapper -->
        </div><!-- /#wrapper -->
        <!-- JavaScript -->
        <script src="<?= base_url() ?>js/jquery-1.11.1.js"></script>
        <script src="<?= base_url() ?>js/bootstrap.js"></script>
        <!-- Page Specific Plugins -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
        <script src="<?= base_url() ?>js/morris/chart-data-morris.js"></script>
        <script src="<?= base_url() ?>js/tablesorter/jquery.tablesorter.js"></script>
        <script src="<?= base_url() ?>js/tablesorter/tables.js"></script>
        <script src="<?= base_url() ?>js/funcao.js"></script>
        <script src="<?= base_url() ?>js/jquery-ui.js"></script>
        <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
        <!-- jQuery -->
        <script src="<?= base_url() ?>charisma/js/jquery-1.7.2.min.js"></script>
        <!-- jQuery UI -->
        <script src="<?= base_url() ?>charisma/js/jquery-ui-1.8.21.custom.min.js"></script>
        <!-- transition / effect library -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-transition.js"></script>
        <!-- alert enhancer library -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-alert.js"></script>
        <!-- modal / dialog library -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-modal.js"></script>
        <!-- custom dropdown library -->
        <!--<script src="<?= base_url() ?>charisma/js/bootstrap-dropdown.js"></script>-->
        <!-- scrolspy library -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-scrollspy.js"></script>
        <!-- library for creating tabs -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-tab.js"></script>
        <!-- library for advanced tooltip -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-tooltip.js"></script>
        <!-- popover effect library -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-popover.js"></script>
        <!-- button enhancer library -->
        <!--<script src="<?= base_url() ?>charisma/js/bootstrap-button.js"></script>-->
        <!-- accordion library (optional, not used in demo) -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-collapse.js"></script>
        <!-- carousel slideshow library (optional, not used in demo) -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-carousel.js"></script>
        <!-- autocomplete library -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-typeahead.js"></script>
        <!-- tour library -->
        <script src="<?= base_url() ?>charisma/js/bootstrap-tour.js"></script>
        <!-- library for cookie management -->
        <script src="<?= base_url() ?>charisma/js/jquery.cookie.js"></script>
        <!-- calander plugin -->
        <script src='<?= base_url() ?>charisma/js/fullcalendar.min.js'></script>
        <!-- data table plugin -->
        <script src='<?= base_url() ?>charisma/js/jquery.dataTables.min.js'></script>

        <!-- chart libraries start -->
        <script src="<?= base_url() ?>charisma/js/excanvas.js"></script>
        <script src="<?= base_url() ?>charisma/js/jquery.flot.min.js"></script>
        <script src="<?= base_url() ?>charisma/js/jquery.flot.pie.min.js"></script>
        <script src="<?= base_url() ?>charisma/js/jquery.flot.stack.js"></script>
        <script src="<?= base_url() ?>charisma/js/jquery.flot.resize.min.js"></script>
        <!-- chart libraries end -->

        <!-- select or dropdown enhancer -->
        <script src="<?= base_url() ?>charisma/js/jquery.chosen.min.js"></script>
        <!-- checkbox, radio, and file input styler -->
        <script src="<?= base_url() ?>charisma/js/jquery.uniform.min.js"></script>
        <!-- plugin for gallery image view -->
        <script src="<?= base_url() ?>charisma/js/jquery.colorbox.min.js"></script>
        <!-- rich text editor library -->
        <script src="<?= base_url() ?>charisma/js/jquery.cleditor.min.js"></script>
        <!-- notification plugin -->
        <script src="<?= base_url() ?>charisma/js/jquery.noty.js"></script>
        <!-- file manager library -->
        <script src="<?= base_url() ?>charisma/js/jquery.elfinder.min.js"></script>
        <!-- star rating plugin -->
        <script src="<?= base_url() ?>charisma/js/jquery.raty.min.js"></script>
        <!-- for iOS style toggle switch -->
        <script src="<?= base_url() ?>charisma/js/jquery.iphone.toggle.js"></script>
        <!-- autogrowing textarea plugin -->
        <script src="<?= base_url() ?>charisma/js/jquery.autogrow-textarea.js"></script>
        <!-- multiple file upload plugin -->
        <script src="<?= base_url() ?>charisma/js/jquery.uploadify-3.1.min.js"></script>
        <!-- history.js for cross-browser state change on ajax -->
        <script src="<?= base_url() ?>charisma/js/jquery.history.js"></script>
        <!-- application script for Charisma demo -->
        <script src="<?= base_url() ?>charisma/js/charisma.js"></script>
    </body>
</html>
<?php
}
?>
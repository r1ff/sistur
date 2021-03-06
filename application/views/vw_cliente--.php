<!DOCTYPE html>
<?php
if(isset($_REQUEST['pagina']))
{
    $pagina= $_REQUEST['pagina'];
}else{
    $pagina=0;
}
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
        <link href="<?= base_url() ?>css/jquery.dataTables.min.css" rel="stylesheet">
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
                        <li class="active"><a href="<?php echo base_url() . "index.php/home/cliente?pagina=0" ?>"><i class="fa fa-users "></i> Cliente</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/agenda?pagina=0" ?>"><i class="fa fa-calendar"></i> Agendamento</a></li>
<!--                        <li><a href="<?php echo base_url() . "index.php/home/orcamento" ?>"><i class="fa fa-file-text-o"></i> Orçamento</a></li>-->
                        <li><a href="<?php echo base_url() . "index.php/home/onibus" ?>"><i class="fa fa-truck"></i> Ônibus</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/viagem" ?>"><i class="fa fa-tasks"></i> Destino</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/motorista" ?>"><i class="fa fa-car"></i> Motorista</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/guiaLista" ?>"><i class="fa fa-bus"></i> Guia</a></li>
                        <li><a href="<?php echo base_url() . "index.php/home/usuario" ?>"><i class="fa fa-user"></i> Usuário</a></li>
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
                        <h1>Cliente <small>Listagem</small></h1>
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-users"></i> Cliente</li>
                            <li class="pull-right"><a href="<?php echo base_url() . "index.php/home/clienteCadastro" ?>" class="btn btn-primary btn-xs" role="button">Novo Cliente</a></li>
                        </ol>
                    </div>
                </div><!-- /.row -->
                <div class="row">
                    <div class="col-md-3">
                <?php
                    echo form_open('home/detalharCliente');
                    $query = $this->db->get('tb_clients');
                    $cliente[] = '';
                    foreach ($query->result() as $clt) {
                        $cliente[$clt->id_clients] = $clt->nome;
                    }
                    include 'teste.php';
                    ?>
                    </div>
                    <div class="col-md-3">   
                    <?php
                    echo form_button(array(
                        "class"=>"btn btn-primary",
                        "content"=>"<i class='fa fa-search'></i> Pesquisar",
                        "type"=>"submit"
                    ));
                    echo form_close();
                ?>
                    </div>
                </div>
                <table class="table tablesorter table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>RG</th>
                            <th>Telefone</th>
                            <th>Celular</th>
                            <th>Data Nascimento</th>
                            <th>Loc. Embarque</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <?php
                    $query=$this->db->query("SELECT id_clients,nome,telefone,rg,celular,data_nascimento,loc_embarque
                                      FROM tb_clients ORDER BY nome asc LIMIT {$pagina},30"); 
                    
                    foreach ($query->result() as $row) {
                        $data_nascimento = implode("/", array_reverse(explode("-", $row->data_nascimento)));
                        ?>
                        <tr>
                            <td><?= $row->nome ?></td>
                            <td><?= $row->rg ?></td>
                            <td><?= $row->telefone ?></td>
                            <td><?= $row->celular ?></td>
                            <td><?= $data_nascimento ?></td>
                            <td><?= $row->loc_embarque ?></td>
                            <td width='220px'><?= form_open('home/excluirCliente') ?>
                                <input type="hidden" name="id_clients" value="<?= $row->id_clients ?>" />
                                <input type="submit" class="btn btn-danger btn-xs pull-right" value="Excluir">
                                </form><?= form_open('home/editarCliente') ?>
                                <input type="hidden" name="id_clients" value="<?= $row->id_clients ?>" />
                                <input type="submit" class="btn btn-warning btn-xs pull-right" value="Editar">
                                </form><?= form_open('home/detalharCliente') ?>
                                <input type="hidden" name="id_clients" value="<?= $row->id_clients ?>" />
                                <input type="submit" class="btn btn-success btn-xs pull-right" value="Detalhar">
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <nav class="pull-right">
                    <ul class="pagination">
                        <?php
                            $queryLista = $this->db->get('tb_clients');

                            $nPagina = count($queryLista->result_array());
                            $nPagina/=30;
                            $nPagina = ceil($nPagina);
                            $nPagina = (int) $nPagina;
                            $lista = 0;
                            for ($i = 1; $i <= $nPagina; $i++) {
                                echo "<li><a href='cliente?pagina=$lista'>{$i}</a></li>";
                                $lista+=30;
                            }
                         ?>
                    </ul>
                </nav>
            </div><!-- /#page-wrapper -->
        </div><!-- /#wrapper -->
        <!-- JavaScript -->
<!--<script src="<?= base_url() ?>js/jquery-1.10.2.js"></script>-->
        <script type='text/javascript' src="<?= base_url() ?>js/jquery-1.11.1.js"></script>
        <script type='text/javascript' src="<?= base_url() ?>js/bootstrap.js"></script>
        <!-- Page Specific Plugins -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
        <script src="<?= base_url() ?>js/morris/chart-data-morris.js"></script>
        <script type='text/javascript' src="<?= base_url() ?>js/jquery-ui.js"></script>
<!--        <script src="<?= base_url() ?>js/funcao.js"></script>
        
        <script src="<?= base_url() ?>js/jquery.autocomplete.js"></script>
        <script src="<?= base_url() ?>js/jquery.mask.min.js"></script>-->
    </body>
</html>
<?php
}
?>
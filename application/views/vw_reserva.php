<!DOCTYPE html>
<?php
$this->db->where('nome_user', $this->session->userdata('nome'));
$query = $this->db->get('tb_users');
$query = $query->result();
if ($query[0]->tipo > 0)
    redirect('/home/guiaLista');
else {
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
            <script type="text/javascript">
                $().ready(function () {
                    $("#course").autocomplete("home/autoComplete", {
                        width: 260,
                        matchContains: true,
                        selectFirst: false
                    });
                });
            </script>
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
                            <li class="active"><a href="<?php echo base_url() . "index.php/home/reserva" ?>"><i class="fa fa-ticket"></i> Reserva</a></li>
                            <li><a href="<?php echo base_url() . "index.php/home/cliente?pagina=0" ?>"><i class="fa fa-users "></i> Cliente</a></li>
                            <li><a href="<?php echo base_url() . "index.php/home/agenda?pagina=0" ?>"><i class="fa fa-calendar"></i> Agendamento</a></li>
<!--                            <li><a href="<?php echo base_url() . "index.php/home/orcamento" ?>"><i class="fa fa-file-text-o"></i> Orçamento</a></li>-->
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
                            <h1>Reserva <small>passagem</small></h1>
                            <ol class="breadcrumb">
                                <li class="active"><i class="fa fa-ticket"></i> Reserva</li>
                            </ol>
                        </div>
                    </div><!-- /.row -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-clock-o"></i> Viagens</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="list-group">
                                        <table class="table table-bordered table-hover table-striped">
                                            <?php
                                            $this->db->select('*');
                                            $this->db->from('tb_tour');
                                            $this->db->join('tb_viagem','tb_tour.id_viagem=tb_viagem.id_viagem');
                                            $this->db->join('tb_cars','tb_cars.id_cars=tb_tour.id_car');
                                            $this->db->where('tb_tour.status','A');
                                            $this->db->where('tb_tour.tipo','v');
                                            $this->db->order_by('tb_tour.id_viagem,tb_tour.data_saida','ASC');
                                            $query=$this->db->get();
                                            
                                            foreach ($query->result() as $row) {
                                                $reserva = 0;
                                                $un_res = 0;
                                                for ($i = 1; $i <= $row->nr_poltrona; $i++) {
                                                    $this->db->where('id_tour', $row->id_tour);
                                                    $this->db->where('nr_poltrona', $i);
                                                    $livre = $this->db->get('tb_reservs');
                                                    if ($livre->num_rows() > 0) {
                                                        foreach ($livre->result() as $livre)
                                                            if ($livre->tipo == 'i' || $livre->tipo == 'v') {
                                                                $un_res++;
                                                                if ($un_res == 2) {
                                                                    $reserva++;
                                                                    $un_res = 0;
                                                                }
                                                            }
                                                        if ($livre->tipo == 'd') {
                                                            $reserva++;
                                                        }
                                                    }
                                                }
                                                $data_saida = implode("/", array_reverse(explode("-", $row->data_saida)));
                                                ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-calendar"></i> <?= $row->destino ?> - <?php
                                                        if ($row->tipo == 'v')
                                                            echo "Viagem";
//                                                        elseif ($row->tipo == 'f')
//                                                            echo "Fretado";
//                                                        elseif ($row->tipo == 't')
//                                                            echo "Turismo";
//                                                        elseif ($row->tipo == 'e')
//                                                            echo "Excursão";
                                                        ?> - <?= $data_saida ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($row->nr_poltrona - $reserva > 0) {
                                                            echo form_open('home/reservaMapa') . '<input type="hidden" name="id_tour" value="' . $row->id_tour . '"><input type="submit" class="btn btn-success btn-xs" value="Disponivel"></form>';
                                                        } else {
                                                            echo form_open('home/reservaMapa') . '<input type="hidden" name="id_tour" value="' . $row->id_tour . '"><input type="submit" class="btn btn-danger btn-xs" value="Esgotado"></form>';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            <script src="<?= base_url() ?>js/funcao.js"></script>
            <script src="<?= base_url() ?>js/jquery-ui.js"></script>
            <script src="<?= base_url() ?>js/jquery.autocomplete.js"></script>
        </body>
    </html>
    <?php
}
?>
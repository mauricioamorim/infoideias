


<?php

//=>  Critica deve ser igual ao botão Proposta do Detelhamento de imóvel
$mostrar_proposta = "S";
if ($_SESSION['var_tem_imovel_cadastrado'] == 'N'){
	$mostrar_proposta = "N";
}


//
$mostrar_registro_venda = "N";
$mostrar_analise = "N";
$mostrar_graficos = "N";
if ($_SESSION['trb_versao_sistema'] == 'C' or $_SESSION['trb_versao_sistema'] == 'L' ){
	if ($_SESSION['trb_usa_registro_vendas'] <> '0' and $_SESSION['trb_utiliza_registro_vendas'] == 'S')  { 
		$mostrar_registro_venda = "S";
	}
	//
	$mostrar_analise = "S";
	$mostrar_graficos = "S";	
}



?>	

<li>
	<a href="javascript:void(0);">
		<span class="menu-icons icone-vendas"></span>
		Vendas
	</a>
 
<ul class="menu-dropdown">


<?php

if ($mostrar_proposta == 'S' ){
?>
<li class = 'menuparent'><a href='#' > Proposta </a>
	<ul>
		<?php			
		if( $_SESSION['trb_utiliza_emissao_proposta'] == 'S'){
				print '<li><a href="grid_busca_imovel_proposta" target="iframe_principal"  onclick="_fechar()";> Nova Proposta</a></li>';
		}	?>
		<li><a href="control_filtro_proposta/control_filtro_proposta.php?menu=S" target="iframe_principal" onclick="_fechar()";> Consultar </a></li>
	</ul>
<?php }	



// 	
if ($_SESSION['trb_usa_registro_vendas'] <> '0' and $_SESSION['trb_utiliza_registro_vendas'] == 'S')  { 
?>
<li class = 'menuparent'><a href='#' > Registro de vendas </a>
	<ul>
		<?php
			if ($_SESSION['trb_permissao_lancar_registro_vendas'] != '0') { ?>
				<li><a href="grid_busca_imovel_registro" target="iframe_principal" onclick="_fechar()";> Novo Registro</a>
				<li><a href="control_rv_consulta_seletiva/control_rv_consulta_seletiva.php?regvenda_veio_menu=N" target="iframe_principal" onclick="_fechar()";> Consultar </a></li>
			<?php } ?>

			<li><a href="control_rv_lancamento_usuario/" target="iframe_principal" onclick="_fechar()";> Contas Corrente</a></li>

		<?php
			if ($_SESSION['trb_permissao_lancar_registro_vendas'] == '2') {
				print '<li><a href="grid_comissoes_pendentes_liberacao/" target="iframe_principal" onclick="_fechar()";> Comissões Pendentes de liberação</a></li>';
			}
		?>

		<li><a href="control_mapa_comissao_pendete_e_ou_liberada/"  target="iframe_principal" onclick="_fechar()";> Comissões Pagas, Pendentes e Liberadas</a></li>
		<?php
			if ($_SESSION['trb_permissao_lancar_registro_vendas'] == '2') {
				print '<li><a href="control_mapa_liberacao_comissao_vales_estornos"  target="iframe_principal" onclick="_fechar()";> Autorizações de Pagamentos</a></li>';
				print '<li><a href="control_rv_emissao_recibo_comissao/" target="iframe_principal" onclick="_fechar()";> Emissão de Recibos de pagamentos e vales</a></li>';
			}
		?>
	</ul>	
<?php } ?>


<?php

if ($mostrar_analise == 'S' ){
?>
    <li class = 'menuparent'><a href='#' > Análises </a>
	<ul>
		<?php
			if ($_SESSION['trb_permissao_lancar_registro_vendas'] != '0') {
				print '<li><a href="control_ranking_vendas/" target="iframe_principal" onclick="_fechar()";> Ranking de Vendas</a></li>';
				print '<li><a href="control_rv_ranking_comissao/" target="iframe_principal" onclick="_fechar()";> Ranking de Comissões da Equipe</a></li>';
			}
		?>
		<li><a href="control_relatorio_produtividade/" target="iframe_principal" onclick="_fechar()";> Produtividade</a></li>
		<li><a href="control_analitico_producao_vendas/" target="iframe_principal" onclick="_fechar()";> Detalhamento da Produção</a></li>

	</ul>	

<?php } ?>



<?php 
if ($mostrar_graficos == 'S' ){
	if ($_SESSION['trb_cargo_usuario'] == 'D' or $_SESSION['trb_cargo_usuario'] == 'S' or $_SESSION['trb_cargo_usuario'] == 'G' )  {
	?>
	<li class = 'menuparent'><a href='#' > Gráficos </a>
		<ul>
			<li><a href="graficos/tipo_midia_comissao.php" target="iframe_principal" onclick="_fechar()";>Vendas por Tipo de Mídia</a></li>
			<li><a href="graficos/midia_comissao.php" target="iframe_principal" onclick="_fechar()";>Vendas por Mídia</a></li>
			<li><a href="graficos/classe_imovel_comissao.php" target="iframe_principal" onclick="_fechar()";> Vendas por Classe de Imóvel</a></li>
			<li><a href="graficos/tipo_imovel_comissao.php" target="iframe_principal" onclick="_fechar()";> Vendas por Tipo de Imóvel</a></li>	
		</ul>
	<?php  
	}
} 
print '</ul></li>';
?>

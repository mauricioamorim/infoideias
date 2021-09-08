<?php 
	
include('conexao.php');	
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link rel="stylesheet" type="text/css" href="css_graficos.css" /> 

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>
$(function () {
	$('#container').highcharts({
		title: {
			text: 'Gráfico de comissão por tipo de imóvel',
			x: -20 //center
		},
		subtitle: {
			text: 'Escala: R$ 1,00 / R$ 1.000,00',
			x: -20
		},
		xAxis: {
			categories: [<?php 
								$categoria = "";
								$i=12;
								$dataAnterior = date('m/Y', strtotime("12 month"));
								for($i=12;$i>=0;$i--){
									if($categoria == "") {
										$categoria .= "'".date('m/Y', strtotime("-".$i." month"))."'";	
									} else {
										$categoria .= ",'".date('m/Y', strtotime("-".$i." month"))."'";		
									}
								}
								
								echo $categoria;
						?>]
		},
		yAxis: {
			min: 0,//Inicio da escala
            tickInterval: 150, //Intervalo da escala
			title: {
				text: 'Os valores estão convertidos em centena de milhares',
				layout: 'horizontal',
				align: 'left',
				verticalAlign: 'bottom'
			},
			plotLines: [{
				value: 0,
				width: 3,
				color: '#808080'
			}]
		},
		tooltip: {
			//valueSuffix: 'R$ ',
			//valuePrefix: 'R$ ',
			valueDecimals: 2
			
		},
		legend: {
			layout: 'horizontal',
			align: 'center',
			verticalAlign: 'bottom',
			borderWidth: 0
		},
		series: [<?php 			
									
									$sql_tipo = mysql_query("SELECT
																	(SELECT imoveis_tipos.descr_tipo FROM imoveis
																	INNER JOIN imoveis_tipos ON imoveis_tipos.id_imovel_tipo = imoveis.id_imovel_tipo
																	WHERE imoveis.id_imovel = mov_vendas.id_imovel) AS tipo,
																	it.id_imovel_tipo
																FROM mov_vendas
																INNER JOIN imoveis AS i ON i.id_imovel = mov_vendas.id_imovel
																INNER JOIN imoveis_tipos AS it ON it.id_imovel_tipo = i.id_imovel_tipo
																WHERE `data` >= SUBDATE(Now(), INTERVAL 13 MONTH) AND mov_vendas.situacao = 'N'  AND mov_vendas.compra_locacao = 'C'
																GROUP BY tipo
																ORDER BY tipo
																");
$where_filial = "";									
if($_SESSION['trb_id_filial'] != 0 and (!isset($_GET['filial']) or $_GET['filial'] == '0')){
	$where_filial = "AND id_filial = ".$_SESSION['trb_id_filial']." ";
}

if($_SESSION['trb_id_filial'] == 0 and isset($_GET['filial'])){
	$where_filial = "AND id_filial = ".$_GET['filial']." ";
}									

while($tipo = mysql_fetch_array($sql_tipo))
{


$sql_valores = mysql_query("SELECT
   i.id_imovel_tipo,
     (SELECT        IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 12 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 12 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_12,

     (SELECT        IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 11 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') =DATE_FORMAT(SUBDATE(NOW(), INTERVAL 11 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_11,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 10 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 10 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_10,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 9 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 9 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_9,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 8 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 8 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_8,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 7 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 7 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_7,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 6 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 6 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_6,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 5 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 5 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_5,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 4 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 4 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_4,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 3 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 3 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_3,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 2 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 2 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_2,

     (SELECT       IF(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 1 MONTH), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(SUBDATE(NOW(), INTERVAL 1 MONTH), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_1,

	 (SELECT       IF(DATE_FORMAT(NOW(), '%m/%Y') = DATE_FORMAT(`data`, '%m/%Y'), (SUM(valor_comissao)/1000), 0)
       FROM mov_vendas AS mv   INNER JOIN imoveis  ON imoveis.id_imovel = mv.id_imovel 
       WHERE DATE_FORMAT(`data`, '%m/%Y') = DATE_FORMAT(NOW(), '%m/%Y') 
       AND imoveis.id_imovel_tipo = i.id_imovel_tipo  AND mv.id_filial = mov_vendas.id_filial  AND mv.situacao = 'N' AND  mv.compra_locacao = 'C') AS valor_0
    
FROM mov_vendas INNER JOIN imoveis AS i ON i.id_imovel = mov_vendas.id_imovel 

WHERE i.id_imovel_tipo = ".$tipo['id_imovel_tipo']." ".$where_filial."  AND mov_vendas.situacao = 'N'  AND mov_vendas.compra_locacao = 'C'

GROUP BY  i.id_imovel_tipo 

ORDER BY i.id_imovel_tipo");	
									

	$valor = mysql_fetch_array($sql_valores);
											
												echo "{ name: '".$tipo['tipo']."', data: [";
												
												
												echo $valor['valor_12'].",";
												echo $valor['valor_11'].",";
												echo $valor['valor_10'].",";
												echo $valor['valor_9'].",";
												echo $valor['valor_8'].",";
												echo $valor['valor_7'].",";
												echo $valor['valor_6'].",";
												echo $valor['valor_5'].",";
												echo $valor['valor_4'].",";
												echo $valor['valor_3'].",";
												echo $valor['valor_2'].",";
												echo $valor['valor_1'].",";
												echo $valor['valor_0']."";
												echo "]
												},";
											
											//$x++;
										
									}
								

						?>]
	});
	
	$("input:radio[name=tipo_grafico]").click(function(){
		 var radio = "";
		//Executa Loop entre todas as Radio buttons com o name de valor
		$('input:radio[name=tipo_grafico]').each(function() {
			//Verifica qual está selecionado
			if ($(this).is(':checked'))
				radio = $(this).val();
				
		});
		
		if(radio == 'venda'){
			window.location = 'tipo_imovel_venda.php';
		}
		if(radio == 'quantidade'){
			window.location = 'tipo_imovel_quantidade.php';
		}
	});
	
	$("#filial").change(function(){
		var filial = $("#filial").val();
		if(filial != 0){
			window.location = 'tipo_imovel_comissao.php?filial='+filial;
		} else {
			window.location = 'tipo_imovel_comissao.php';
		}
	});
});
</script>
</head>

<body>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #ddd; box-shadow: 0px 0px 5px -2px #989898;">
  <tr>
    <th height="25" align="left" valign="middle" nowrap="nowrap" bgcolor="#749bcf" class="titulo_table">Gráficos de vendas por tipo de imóvel</th>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
          <tr>
            <td><input type="radio" name="tipo_grafico" id="tipo_grafico" value="quantidade" />
              <label for="tipo_grafico">Quantidade vendida</label></td>
            <td><input type="radio" name="tipo_grafico" id="tipo_grafico" value="comissao" checked/>
              <label for="tipo_grafico">Comissão gerada</label></td>
            <td><input type="radio" name="tipo_grafico" id="tipo_grafico" value="venda" />
              <label for="tipo_grafico">Valor do imóvel</label></td>
            
            <td>&nbsp;</td>
			<td>
			<?php
			
				if($_SESSION['trb_id_filial'] == 0){
			?>
			<strong>Filial:</strong>
            <select name="filial" id="filial">
			<option value='0'>Todas filiais</option>
			<?php
				$sql_filial = mysql_query("SELECT id_filial, descr_filial FROM filiais WHERE ativo = 'S'");
				while($filial = mysql_fetch_array($sql_filial)){
				
					if(isset($_GET['filial'])){
						if($_GET['filial'] == $filial['id_filial']){
							echo "<option value='".$filial['id_filial']."' SELECTED>".$filial['descr_filial']."</option>";
						} else {
								echo "<option value='".$filial['id_filial']."'>".$filial['descr_filial']."</option>";
						}
					} else {
						echo "<option value='".$filial['id_filial']."'>".$filial['descr_filial']."</option>";
					}
				}
			?>
            	
            </select>
			<?php } else{  ?>
			<td>
			<strong>Filial:</strong>
            <select name="filial" id="filial">
			<?php
				$sql_filial = mysql_query("SELECT id_filial, descr_filial FROM filiais WHERE id_filial = ".$_SESSION['trb_id_filial']." AND ativo = 'S'");
				while($filial = mysql_fetch_array($sql_filial)){
					echo "<option value='".$filial['id_filial']."'>".$filial['descr_filial']."</option>";
				}
			?>
            	
            </select>
			<?php } ?>
			</td>
            <td>
		<a id='sc_btn_ajuda_top' title='Ajuda com Manuais e Vídeo aulas' style='vertical-align: middle; display:inline-block;'  href='https://sistema.midasweb.imb.br/mw_ajuda/?ht_kb=venda-por-tipo-de-imovel' target='_blank''>
		 <img id='id_img_sc_btn_ajuda_top' src='../_lib/img/grp__NM__ajuda.png' style='border-width: 0; cursor: pointer'>
		</a>						
			</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
